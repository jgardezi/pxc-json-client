<?php

namespace PXC\JsonApi\Client;

use Swis\JsonApi\Client\Interfaces\DocumentInterface;
use Swis\JsonApi\Client\Interfaces\ItemDocumentInterface;

interface BasicRequestInterface
{
    /**
     * @param bool $public
     * @return array
     */
    function getHeader(bool $public): array;

    /**
     * @param string $endpoint
     *
     * @param bool $public
     * @return \Swis\JsonApi\Client\Interfaces\DocumentInterface
     */
    public function get(string $endpoint, bool $public): DocumentInterface;

    /**
     * @param string $endpoint
     * @param \Swis\JsonApi\Client\Interfaces\ItemDocumentInterface $document
     *
     * @param bool $public
     * @return \Swis\JsonApi\Client\Interfaces\DocumentInterface
     */
    public function patch(string $endpoint, ItemDocumentInterface $document, bool $public): DocumentInterface;

    /**
     * @param string $endpoint
     * @param \Swis\JsonApi\Client\Interfaces\ItemDocumentInterface $document
     *
     * @param bool $public
     * @return \Swis\JsonApi\Client\Interfaces\DocumentInterface
     */
    public function post(string $endpoint, ItemDocumentInterface $document, bool $public): DocumentInterface;

    /**
     * @param string $endpoint
     *
     * @param bool $public
     * @return \Swis\JsonApi\Client\Interfaces\DocumentInterface
     */
    public function delete(string $endpoint, bool $public): DocumentInterface;

    /**
     * @return string
     */
    public function getBaseUri(): string;

    /**
     * @param string $baseUri
     */
    public function setBaseUri(string $baseUri);
}