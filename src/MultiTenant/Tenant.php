<?php

namespace Webuni\DoctrineExtensions\MultiTenant;

final class Tenant
{
    /** @var string */
    private $connectionName;

    /** @var array */
    private $connectionParams;

    public function __construct(string $connectionName, array $connectionParams)
    {
        $this->connectionName = $connectionName;
        $this->connectionParams = $connectionParams;
    }

    public function getConnectionName(): string
    {
        return $this->connectionName;
    }

    public function getConnectionParams(): array
    {
        return $this->connectionParams;
    }
}
