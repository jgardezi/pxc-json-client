<?php

namespace PXC\JsonApi\Client\Providers;

use PXC\JsonApi\Client\ClientRequestInterface;
use PXC\JsonApi\Client\MachineRequestInterface;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;
use Illuminate\Foundation\Application;
use Swis\JsonApi\Client\Interfaces\ClientInterface as ApiClientInterface;
use Swis\JsonApi\Client\Interfaces\ResponseParserInterface;
use \JsonSerializable;
use PXC\JsonApi\Client\ClientRequest;
use PXC\JsonApi\Client\MachineRequest;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__, 2) . '/config/' => config_path(),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__, 2) . '/config/jsonapi.php',
            'jsonapi'
        );

        $this->app->bind(
            ClientRequestInterface::class,
            function (Application $app) {
                return new ClientRequest(
                    $app->make(ApiClientInterface::class),
                    new JsonSerializable(),
                    $app->make(ResponseParserInterface::class)
                );
            }
        );

        $this->app->bind(
            MachineRequestInterface::class,
            function (Application $app) {
                return new MachineRequest(
                    $app->make(ApiClientInterface::class),
                    new JsonSerializable(),
                    $app->make(ResponseParserInterface::class)
                );
            }
        );
    }

    protected function getHttpClient(): HttpClient
    {
        return HttpClientDiscovery::find();
    }

    protected function getMessageFactory(): MessageFactory
    {
        return MessageFactoryDiscovery::find();
    }
}
