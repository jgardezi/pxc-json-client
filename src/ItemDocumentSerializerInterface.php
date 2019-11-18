<?php
namespace PXC\JsonApi\Client;
use Swis\JsonApi\Client\Interfaces\ItemDocumentInterface;

interface ItemDocumentSerializerInterface
{

    /**
     * @param Swis\JsonApi\Client\Interfaces\ItemDocumentInterface $itemDocument
     * @return json
     */
    function serialize(ItemDocumentInterface $itemDocument);


}