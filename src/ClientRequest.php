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
            return [];
        }
        return ['Authorization' => "Bearer " . $token = Request::session()->get('pxc.token')];
    }


}
