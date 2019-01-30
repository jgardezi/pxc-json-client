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

        $token = Request::get('pxc.token');
        if (!$token) {
            $token = Request::session()->get('pxc.token');
        }
        return array_merge(
            ['Authorization' => "Bearer " . $token], $this->headers
        );
    }


}
