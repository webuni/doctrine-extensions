<?php

namespace Webuni\DoctrineExtensions\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\MappingException;

final class PreserveIdGeneratorDecorator extends GeneratorDecorator
{
    public function generate(EntityManager $em, $entity)
    {
        $metadata = $em->getClassMetadata(get_class($entity));
        try {
            $field = $metadata->getSingleIdentifierFieldName();
            $id = $metadata->getFieldValue($entity, $field);

            if (null !== $id) {
                return $id;
            }
        } catch (MappingException $e) {
        }

        return $this->generate($em, $entity);
    }
}
