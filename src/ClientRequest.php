<?php

namespace PXC\JsonApi\Client;

use Illuminate\Support\Facades\Request;

class ClientRequest extends BasicRequest implements ClientRequestInterface
{

    /**
     * @param bool $public
     * @return array
     */
    function getHeader(bool $public): array
    {
        if ($public) {
            return $this->headers;
        }
        return array_merge(
            ['Authorization' => "Bearer " . $token = Request::get('pxc.token')], $this->headers
        );
    }


}
