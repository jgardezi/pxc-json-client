<?php

namespace PXC\JsonApi\Client;

class MachineRequest extends BasicRequest implements MachineRequestInterface
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
            ['Authorization' => "Bearer " . env('MACHINE_COMMUNICATE_TOKEN')], $this->headers
        );
    }


}
