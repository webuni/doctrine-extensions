<?php

namespace Webuni\DoctrineExtensions\Decorator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\UnitOfWork;

abstract class UnitOfWorkDecorator extends UnitOfWork
{
    protected $wrapped;

    /**
     * @inheritDoc
     **/
    public function __construct(UnitOfWork $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    /**
     * @inheritDoc
     **/
    public function commit($entity = null)
    {
        $this->wrapped->commit($entity);
    }

    /**
     * @inheritDoc
     **/
    public function & getEntityChangeSet($entity)
    {
        return $this->wrapped->getEntityChangeSet($entity);
    }

    /**
     * @inheritDoc
     **/
    public function computeChangeSet(ClassMetadata $class, $entity)
    {
        $this->wrapped->computeChangeSet($class, $entity);
    }

    /**
     * @inheritDoc
     **/
    public function computeChangeSets()
    {
        $this->wrapped->computeChangeSets();
    }

    /**
     * @inheritDoc
     **/
    public function recomputeSingleEntityChangeSet(ClassMetadata $class, $entity)
    {
        $this->wrapped->recomputeSingleEntityChangeSet($class, $entity);
    }

    /**
     * @inheritDoc
     **/
    public function scheduleForInsert($entity)
    {
        $this->wrapped->scheduleForInsert($entity);
    }

    /**
     * @inheritDoc
     **/
    public function isScheduledForInsert($entity)
    {
        return $this->wrapped->isScheduledForInsert($entity);
    }

    /**
     * @inheritDoc
     **/
    public function scheduleForUpdate($entity)
    {
        $this->wrapped->scheduleForUpdate($entity);
    }

    /**
     * @inheritDoc
     **/
    public function scheduleExtraUpdate($entity, array $changeset)
    {
        $this->wrapped->scheduleExtraUpdate($entity, $changeset);
    }

    /**
     * @inheritDoc
     **/
    public function isScheduledForUpdate($entity)
    {
        return $this->wrapped->isScheduledForUpdate($entity);
    }

    /**
     * @inheritDoc
     **/
    public function isScheduledForDirtyCheck($entity)
    {
        return $this->wrapped->isScheduledForDirtyCheck($entity);
    }

    /**
     * @inheritDoc
     **/
    public function scheduleForDelete($entity)
    {
        $this->wrapped->scheduleForDelete($entity);
    }

    /**
     * @inheritDoc
     **/
    public function isScheduledForDelete($entity)
    {
        return $this->wrapped->isScheduledForDelete($entity);
    }

    /**
     * @inheritDoc
     **/
    public function isEntityScheduled($entity)
    {
        return $this->wrapped->isEntityScheduled($entity);
    }

    /**
     * @inheritDoc
     **/
    public function addToIdentityMap($entity)
    {
        return $this->wrapped->addToIdentityMap($entity);
    }

    /**
     * @inheritDoc
     **/
    public function getEntityState($entity, $assume = null)
    {
        return $this->wrapped->getEntityState($entity, $assume);
    }

    /**
     * @inheritDoc
     **/
    public function removeFromIdentityMap($entity)
    {
        return $this->wrapped->removeFromIdentityMap($entity);
    }

    /**
     * @inheritDoc
     **/
    public function getByIdHash($idHash, $rootClassName)
    {
        return $this->wrapped->getByIdHash($idHash, $rootClassName);
    }

    /**
     * @inheritDoc
     **/
    public function tryGetByIdHash($idHash, $rootClassName)
    {
        return $this->wrapped->tryGetByIdHash($idHash, $rootClassName);
    }

    /**
     * @inheritDoc
     **/
    public function isInIdentityMap($entity)
    {
        return $this->wrapped->isInIdentityMap($entity);
    }

    /**
     * @inheritDoc
     **/
    public function containsIdHash($idHash, $rootClassName)
    {
        return $this->wrapped->containsIdHash($idHash, $rootClassName);
    }

    /**
     * @inheritDoc
     **/
    public function persist($entity)
    {
        $this->wrapped->persist($entity);
    }

    /**
     * @inheritDoc
     **/
    public function remove($entity)
    {
        $this->wrapped->remove($entity);
    }

    /**
     * @inheritDoc
     **/
    public function merge($entity)
    {
        return $this->wrapped->merge($entity);
    }

    /**
     * @inheritDoc
     **/
    public function detach($entity)
    {
        $this->wrapped->detach($entity);
    }

    /**
     * @inheritDoc
     **/
    public function refresh($entity)
    {
        $this->wrapped->refresh($entity);
    }

    /**
     * @inheritDoc
     **/
    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->wrapped->lock($entity, $lockMode, $lockVersion);
    }

    /**
     * @inheritDoc
     **/
    public function getCommitOrderCalculator()
    {
        return $this->wrapped->getCommitOrderCalculator();
    }

    /**
     * @inheritDoc
     **/
    public function clear($entityName = null)
    {
        $this->wrapped->clear($entityName);
    }

    /**
     * @inheritDoc
     **/
    public function scheduleOrphanRemoval($entity)
    {
        $this->wrapped->scheduleOrphanRemoval($entity);
    }

    /**
     * @inheritDoc
     **/
    public function cancelOrphanRemoval($entity)
    {
        $this->wrapped->cancelOrphanRemoval($entity);
    }

    /**
     * @inheritDoc
     **/
    public function scheduleCollectionDeletion(PersistentCollection $coll)
    {
        $this->wrapped->scheduleCollectionDeletion($coll);
    }

    /**
     * @inheritDoc
     **/
    public function isCollectionScheduledForDeletion(PersistentCollection $coll)
    {
        return $this->wrapped->isCollectionScheduledForDeletion($coll);
    }

    /**
     * @inheritDoc
     **/
    public function createEntity($className, array $data, &$hints = [])
    {
        return $this->wrapped->createEntity($className, $data, $hints);
    }

    /**
     * @inheritDoc
     **/
    public function triggerEagerLoads()
    {
        $this->wrapped->triggerEagerLoads();
    }

    /**
     * @inheritDoc
     **/
    public function loadCollection(PersistentCollection $collection)
    {
        $this->wrapped->loadCollection($collection);
    }

    /**
     * @inheritDoc
     **/
    public function getIdentityMap()
    {
        return $this->wrapped->getIdentityMap();
    }

    /**
     * @inheritDoc
     **/
    public function getOriginalEntityData($entity)
    {
        return $this->wrapped->getOriginalEntityData($entity);
    }

    /**
     * @inheritDoc
     **/
    public function setOriginalEntityData($entity, array $data)
    {
        $this->wrapped->setOriginalEntityData($entity, $data);
    }

    /**
     * @inheritDoc
     **/
    public function setOriginalEntityProperty($oid, $property, $value)
    {
        $this->wrapped->setOriginalEntityProperty($oid, $property, $value);
    }

    /**
     * @inheritDoc
     **/
    public function getEntityIdentifier($entity)
    {
        return $this->wrapped->getEntityIdentifier($entity);
    }

    /**
     * @inheritDoc
     **/
    public function getSingleIdentifierValue($entity)
    {
        return $this->wrapped->getSingleIdentifierValue($entity);
    }

    /**
     * @inheritDoc
     **/
    public function tryGetById($id, $rootClassName)
    {
        return $this->wrapped->tryGetById($id, $rootClassName);
    }

    /**
     * @inheritDoc
     **/
    public function scheduleForDirtyCheck($entity)
    {
        $this->wrapped->scheduleForDirtyCheck($entity);
    }

    /**
     * @inheritDoc
     **/
    public function hasPendingInsertions()
    {
        return $this->wrapped->hasPendingInsertions();
    }

    /**
     * @inheritDoc
     **/
    public function size()
    {
        return $this->wrapped->size();
    }

    /**
     * @inheritDoc
     **/
    public function getEntityPersister($entityName)
    {
        return $this->wrapped->getEntityPersister($entityName);
    }

    /**
     * @inheritDoc
     **/
    public function getCollectionPersister(array $association)
    {
        return $this->wrapped->getCollectionPersister($association);
    }

    /**
     * @inheritDoc
     **/
    public function registerManaged($entity, array $id, array $data)
    {
        $this->wrapped->registerManaged($entity, $id, $data);
    }

    /**
     * @inheritDoc
     **/
    public function clearEntityChangeSet($oid)
    {
        $this->wrapped->clearEntityChangeSet($oid);
    }

    /**
     * @inheritDoc
     **/
    public function propertyChanged($entity, $propertyName, $oldValue, $newValue)
    {
        $this->wrapped->propertyChanged($entity, $propertyName, $oldValue, $newValue);
    }

    /**
     * @inheritDoc
     **/
    public function getScheduledEntityInsertions()
    {
        return $this->wrapped->getScheduledEntityInsertions();
    }

    /**
     * @inheritDoc
     **/
    public function getScheduledEntityUpdates()
    {
        return $this->wrapped->getScheduledEntityUpdates();
    }

    /**
     * @inheritDoc
     **/
    public function getScheduledEntityDeletions()
    {
        return $this->wrapped->getScheduledEntityDeletions();
    }

    /**
     * @inheritDoc
     **/
    public function getScheduledCollectionDeletions()
    {
        return $this->wrapped->getScheduledCollectionDeletions();
    }

    /**
     * @inheritDoc
     **/
    public function getScheduledCollectionUpdates()
    {
        return $this->wrapped->getScheduledCollectionUpdates();
    }

    /**
     * @inheritDoc
     **/
    public function initializeObject($obj)
    {
        $this->wrapped->initializeObject($obj);
    }

    /**
     * @inheritDoc
     **/
    public function markReadOnly($object)
    {
        $this->wrapped->markReadOnly($object);
    }

    /**
     * @inheritDoc
     **/
    public function isReadOnly($object)
    {
        return $this->wrapped->isReadOnly($object);
    }

    /**
     * @inheritDoc
     **/
    public function hydrationComplete()
    {
        $this->wrapped->hydrationComplete();
    }

    public function getEntityManager(): EntityManagerInterface
    {
        $reflection = new \ReflectionProperty(UnitOfWork::class, 'em');
        $reflection->setAccessible(true);

        return $reflection->getValue($this->wrapped);
    }
}
