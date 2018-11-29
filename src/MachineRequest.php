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
            return [];
        }
        return ['Authorization' => "Bearer " . env('MACHINE_COMMUNICATE_TOKEN')];
    }


}
