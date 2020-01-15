<?php

namespace App\Translatable;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AssignedGenerator as BaseAssignedGenerator;
use Doctrine\ORM\ORMInvalidArgumentException;
use Webuni\DoctrineExtensions\Decorator\EntityManagerDecorator;

class AssignedGenerator extends BaseAssignedGenerator
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
