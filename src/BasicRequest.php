<?php

namespace PXC\JsonApi\Client;

use Swis\JsonApi\Client\Interfaces\ClientInterface;
use Swis\JsonApi\Client\Interfaces\DocumentInterface;
use Swis\JsonApi\Client\Interfaces\ItemDocumentInterface;
use Swis\JsonApi\Client\Interfaces\ParserInterface;
use Swis\JsonApi\Client\Interfaces\ResponseInterface;
use Swis\JsonApi\Client\ItemDocumentSerializer;
use Swis\JsonApi\Client\Document;
use Swis\JsonApi\Client\InvalidResponseDocument;

abstract class BasicRequest implements BasicRequestInterface
{
    /**
     * @var \Swis\JsonApi\Client\Interfaces\ClientInterface
     */
    protected $client;

    /**
     * @var \Swis\JsonApi\Client\ItemDocumentSerializer
     */
    protected $itemDocumentSerializer;

    /**
     * @var \Swis\JsonApi\Client\Interfaces\ParserInterface
     */
    protected $parser;

    /**
     * @var array
     */
    protected $headers = [
        'Accept'       => 'application/json',
        'Content-Type' => 'application/json',
    ];

    /**
     * @param \Swis\JsonApi\Client\Interfaces\ClientInterface $client
     * @param \Swis\JsonApi\Client\ItemDocumentSerializer $itemDocumentSerializer
     * @param \Swis\JsonApi\Client\Interfaces\ParserInterface $parser
     */
    public function __construct(
        ClientInterface $client,
        ItemDocumentSerializer $itemDocumentSerializer,
        ParserInterface $parser
    )
    {
        $this->client = $client;
        $this->itemDocumentSerializer = $itemDocumentSerializer;
        $this->parser = $parser;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->client->getBaseUri();
    }

    /**
     * @param string $baseUri
     */
    public function setBaseUri(string $baseUri)
    {
        $this->client->setBaseUri($baseUri);
    }

    /**
     * @param array $headers
     */
    public function setHeader(array $headers) {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * @param string $endpoint
     *
     * @param bool $public
     * @return \Swis\JsonApi\Client\Interfaces\DocumentInterface
     */
    public function get(string $endpoint, bool $public = false): DocumentInterface
    {
        return $this->parseResponse($this->client->get($endpoint, $this->getHeader($public)));
    }

    /**
     * @param string $endpoint
     * @param \Swis\JsonApi\Client\Interfaces\ItemDocumentInterface $body
     *
     * @param bool $public
     * @return \Swis\JsonApi\Client\Interfaces\DocumentInterface
     */
    public function post(string $endpoint, ItemDocumentInterface $body, bool $public = false): DocumentInterface
    {
        return $this->parseResponse($this->client->post($endpoint, $this->prepareBody($body), $this->getHeader($public)));
    }

    /**
     * @param string $endpoint
     * @param \Swis\JsonApi\Client\Interfaces\ItemDocumentInterface $body
     *
     * @param bool $public
     * @return \Swis\JsonApi\Client\Interfaces\DocumentInterface
     */
    public function patch(string $endpoint, ItemDocumentInterface $body, bool $public = false): DocumentInterface
    {
        return $this->parseResponse($this->client->patch($endpoint, $this->prepareBody($body), $this->getHeader($public)));
    }

    /**
     * @param string $endpoint
     *
     * @param bool $public
     * @return \Swis\JsonApi\Client\Interfaces\DocumentInterface
     */
    public function delete(string $endpoint, bool $public = false): DocumentInterface
    {
        return $this->parseResponse($this->client->delete($endpoint, $this->getHeader($public)));
    }

    /**
     * @param \Swis\JsonApi\Client\Interfaces\ItemDocumentInterface $body
     *
     * @return string
     */
    protected function prepareBody(ItemDocumentInterface $body): string
    {
        return $this->sanitizeJson($this->itemDocumentSerializer->serialize($body));
    }

    /**
     * @param string $json
     *
     * @return string
     */
    protected function sanitizeJson(string $json): string
    {
        return str_replace('\r\n', '\\n', $json);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return \Swis\JsonApi\Client\Interfaces\DocumentInterface
     */
    protected function parseResponse(ResponseInterface $response): DocumentInterface
    {
        if ($response->hasBody()) {
            return $this->parser->deserialize($response->getBody());
        }

        if ($response->hasSuccessfulStatusCode()) {
            return new Document();
        }

        return new InvalidResponseDocument();
    }
}
