<?php

namespace Webuni\DoctrineExtensions\Mapping;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\ORM\Mapping\MappingException;

final class MergeMappingDriver implements MappingDriver
{
    /** @var \SplObjectStorage<MappingDriver, string> */
    private $drivers;

    public function __construct()
    {
        $this->drivers = new \SplObjectStorage();
    }

    public function addDriver(MappingDriver $driver, $namespace)
    {
        $this->drivers->attach($driver, $namespace);
    }

    public function loadMetadataForClass($className, ClassMetadata $metadata)
    {
        /** @var MappingDriver $driver */
        foreach ($this->drivers as $driver) {
            $namespace = $this->drivers[$driver];
            if (strpos($className, $namespace) === 0) {
                try {
                    $driver->loadMetadataForClass($className, $metadata);
                } catch (MappingException $e) {
                }
            }
        }
    }

    public function getAllClassNames()
    {
        $classNames = [];
        $driverClasses = [];

        /** @var MappingDriver $driver */
        foreach ($this->drivers as $driver) {
            $namespace = $this->drivers[$driver];
            $oid = spl_object_hash($driver);

            if (!isset($driverClasses[$oid])) {
                $driverClasses[$oid] = $driver->getAllClassNames();
            }

            foreach ($driverClasses[$oid] as $className) {
                if (strpos($className, $namespace) !== 0) {
                    continue;
                }

                $classNames[$className] = true;
            }
        }

        return array_keys($classNames);
    }

    public function isTransient($className)
    {
        $transient = true;
        /** @var MappingDriver $driver */
        foreach ($this->drivers as $driver) {
            $namespace = $this->drivers[$driver];
            if (strpos($className, $namespace) === 0) {
                $transient = $transient && $driver->isTransient($className);
            }
        }

        return $transient;
    }
}
