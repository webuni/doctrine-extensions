<?php

namespace Webuni\DoctrineExtensions\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class GeneratorDecorator extends AbstractIdGenerator
{
    private $wrapped;

    public function __construct(AbstractIdGenerator $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    public function generate(EntityManager $em, $entity)
    {
        return $this->wrapped->generate($em, $entity);
    }

    public function isPostInsertGenerator()
    {
        return $this->wrapped->isPostInsertGenerator();
    }
}
