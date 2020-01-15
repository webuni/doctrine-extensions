<?php

namespace Webuni\DoctrineExtensions\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMInvalidArgumentException;
use Webuni\DoctrineExtensions\Decorator\EntityManagerDecorator;

final class EntityManagerInterfaceGeneratorDecorator extends GeneratorDecorator
{
    public function generate($em, $entity)
    {
        if (!$em instanceof EntityManagerInterface && !$em instanceof EntityManager) {
            throw new ORMInvalidArgumentException('');
        }

        if (!$em instanceof EntityManager) {
            $em = new EntityManagerDecorator($em);
        }

        return parent::generate($em, $entity);
    }
}
