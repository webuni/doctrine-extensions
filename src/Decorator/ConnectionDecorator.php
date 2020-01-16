<?php

namespace Webuni\DoctrineExtensions\Decorator;

use Closure;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Connection;
use function func_get_args;
use function call_user_func_array;

class ConnectionDecorator extends Connection
{
    private $wrapped;

    public function __construct(Connection $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    public function connect()
    {
        return $this->wrapped->connect();
    }

    public function executeQuery($query, array $params = [], $types = [], ?QueryCacheProfile $qcp = null)
    {
        return $this->wrapped->executeQuery($query, $params, $types, $qcp);
    }

    public function prepare($statement)
    {
        return $this->wrapped->prepare($statement);
    }

    public function query()
    {
        return call_user_func_array([$this->wrapped, 'query'], func_get_args());
    }

    public function getParams()
    {
        return $this->wrapped->getParams();
    }

    public function getDatabase()
    {
        return $this->wrapped->getDatabase();
    }

    public function getHost()
    {
        return $this->wrapped->getHost();
    }

    public function getPort()
    {
        return $this->wrapped->getPort();
    }

    public function getUsername()
    {
        return $this->wrapped->getUsername();
    }

    public function getPassword()
    {
        return $this->wrapped->getPassword();
    }

    public function getDriver()
    {
        return $this->wrapped->getDriver();
    }

    public function getConfiguration()
    {
        return $this->wrapped->getConfiguration();
    }

    public function getEventManager()
    {
        return $this->wrapped->getEventManager();
    }

    public function getDatabasePlatform()
    {
        return $this->wrapped->getDatabasePlatform();
    }

    public function getExpressionBuilder()
    {
        return $this->wrapped->getExpressionBuilder();
    }

    public function isAutoCommit()
    {
        return $this->wrapped->isAutoCommit();
    }

    public function setAutoCommit($autoCommit)
    {
        return $this->wrapped->setAutoCommit($autoCommit);
    }

    public function setFetchMode($fetchMode)
    {
        $this->wrapped->setFetchMode($fetchMode);
    }

    public function fetchAssoc($statement, array $params = [], array $types = [])
    {
        return $this->wrapped->fetchAssoc($statement, $params, $types);
    }

    public function fetchArray($statement, array $params = [], array $types = [])
    {
        return $this->wrapped->fetchArray($statement, $params, $types);
    }

    public function fetchColumn($statement, array $params = [], $column = 0, array $types = [])
    {
        return $this->wrapped->fetchColumn($statement, $params, $column, $types);
    }

    public function isConnected()
    {
        return $this->wrapped->isConnected();
    }

    public function isTransactionActive()
    {
        return $this->wrapped->isTransactionActive();
    }

    public function delete($tableExpression, array $identifier, array $types = [])
    {
        return $this->wrapped->delete($tableExpression, $identifier, $types);
    }

    public function close()
    {
        $this->wrapped->close();
    }

    public function setTransactionIsolation($level)
    {
        return $this->wrapped->setTransactionIsolation($level);
    }

    public function getTransactionIsolation()
    {
        return $this->wrapped->getTransactionIsolation();
    }

    public function update($tableExpression, array $data, array $identifier, array $types = [])
    {
        return $this->wrapped->update($tableExpression, $data, $identifier, $types);
    }

    public function insert($tableExpression, array $data, array $types = [])
    {
        return $this->wrapped->insert($tableExpression, $data, $types);
    }

    public function quoteIdentifier($str)
    {
        return $this->wrapped->quoteIdentifier($str);
    }

    public function quote($input, $type = null)
    {
        return $this->wrapped->quote($input, $type);
    }

    public function fetchAll($sql, array $params = [], $types = [])
    {
        return $this->wrapped->fetchAll($sql, $params, $types);
    }

    public function executeCacheQuery($query, $params, $types, QueryCacheProfile $qcp)
    {
        return $this->wrapped->executeCacheQuery($query, $params, $types, $qcp);
    }

    public function project($query, array $params, Closure $function)
    {
        return $this->wrapped->project($query, $params, $function);
    }

    public function executeUpdate($query, array $params = [], array $types = [])
    {
        return $this->wrapped->executeUpdate($query, $params, $types);
    }

    public function exec($statement)
    {
        return $this->wrapped->exec($statement);
    }

    public function getTransactionNestingLevel()
    {
        return $this->wrapped->getTransactionNestingLevel();
    }

    public function errorCode()
    {
        return $this->wrapped->errorCode();
    }

    public function errorInfo()
    {
        return $this->wrapped->errorInfo();
    }

    public function lastInsertId($seqName = null)
    {
        return $this->wrapped->lastInsertId($seqName);
    }

    public function transactional(Closure $func)
    {
        return $this->wrapped->transactional($func);
    }

    public function setNestTransactionsWithSavepoints($nestTransactionsWithSavepoints)
    {
        $this->wrapped->setNestTransactionsWithSavepoints(
            $nestTransactionsWithSavepoints
        );
    }

    public function getNestTransactionsWithSavepoints()
    {
        return $this->wrapped->getNestTransactionsWithSavepoints();
    }

    public function beginTransaction()
    {
        return $this->wrapped->beginTransaction();
    }

    public function commit()
    {
        return $this->wrapped->commit();
    }

    public function rollBack()
    {
        $this->wrapped->rollBack();
    }

    public function createSavepoint($savepoint)
    {
        $this->wrapped->createSavepoint($savepoint);
    }

    public function releaseSavepoint($savepoint)
    {
        $this->wrapped->releaseSavepoint($savepoint);
    }

    public function rollbackSavepoint($savepoint)
    {
        $this->wrapped->rollbackSavepoint($savepoint);
    }

    public function getWrappedConnection()
    {
        return $this->wrapped->getWrappedConnection();
    }

    public function getSchemaManager()
    {
        return $this->wrapped->getSchemaManager();
    }

    public function setRollbackOnly()
    {
        $this->wrapped->setRollbackOnly();
    }

    public function isRollbackOnly()
    {
        return $this->wrapped->isRollbackOnly();
    }

    public function convertToDatabaseValue($value, $type)
    {
        return $this->wrapped->convertToDatabaseValue($value, $type);
    }

    public function convertToPHPValue($value, $type)
    {
        return $this->wrapped->convertToPHPValue($value, $type);
    }

    public function resolveParams(array $params, array $types)
    {
        return $this->wrapped->resolveParams($params, $types);
    }

    public function createQueryBuilder()
    {
        return $this->wrapped->createQueryBuilder();
    }

    public function ping()
    {
        return $this->wrapped->ping();
    }
}
