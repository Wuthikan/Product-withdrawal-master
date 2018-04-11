<?php
namespace DurianSoftware\Services;

use DurianSoftware\Services\CustomPasswordBroker;
use InvalidArgumentException;
use Illuminate\Auth\Passwords\PasswordBrokerManager as Broker;

class PasswordBrokerManager extends Broker
{
    protected function resolve($name)
    {
        $config = $this->getConfig($name);
        if (is_null($config)) {
            throw new InvalidArgumentException("Password resetter [{$name}] is not defined.");
        }

        return new CustomPasswordBroker(
            $this->createTokenRepository($config),
            $this->app['auth']->createUserProvider($config['provider'])
        );
    }
}
