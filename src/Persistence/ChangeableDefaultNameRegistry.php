<?php

namespace Webuni\DoctrineExtensions\Persistence;

final class ChangeableDefaultNameRegistry extends ManagerRegistryDecorator
{
    private $defaultConnectionName;
    private $defaultManagerName;

    public function getDefaultConnectionName()
    {
        return $this->defaultConnectionName ?? parent::getDefaultConnectionName();
    }

    public function setDefaultConnectionName($name)
    {
        $this->defaultConnectionName = $name;
    }

    public function getConnection($name = null)
    {
        return parent::getConnection($name ?? $this->getDefaultConnectionName());
    }

    public function getDefaultManagerName()
    {
        return $this->defaultManagerName ?? parent::getDefaultManagerName();
    }

    public function setDefaultManagerName($name)
    {
        $this->defaultManagerName = $name;
    }

    public function getManager($name = null)
    {
        return parent::getManager($name ?? $this->getDefaultManagerName());
    }

    public function resetManager($name = null)
    {
        return parent::resetManager($name ?? $this->getDefaultManagerName());
    }

    public function getRepository($persistentObject, $persistentManagerName = null)
    {
        return parent::getRepository($persistentObject, $persistentManagerName ?? $this->getDefaultManagerName());
    }
}
