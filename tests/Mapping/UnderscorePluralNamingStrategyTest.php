<?php

declare(strict_types=1);

/*
 * This is part of the webuni/doctrine-extensions package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\DoctrineExtension\Tests;

use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Webuni\DoctrineExtensions\Mapping\PluralNamingStrategy;

final class UnderscorePluralNamingStrategyTest extends AbstractPluralNamingStrategyTest
{
    protected function setUp(): void
    {
        $this->strategy = new PluralNamingStrategy(new UnderscoreNamingStrategy());
    }

    public function getClassToTableName()
    {
        return [
            ['My\User', 'users'],
            ['My\Group', 'groups'],
            ['My\Man', 'men'],
            ['My\Person', 'people'],
            ['My\UserGroup', 'user_groups'],
        ];
    }

    public function getPropertyToColumnName()
    {
        return [
            ['My\User', 'name', 'name'],
            ['My\Group', 'title', 'title'],
            ['My\Man', 'birthday', 'birthday'],
            ['My\Person', 'groups', 'groups'],
            ['My\UserGroup', 'users', 'users'],
            [null, 'users', 'users'],
        ];
    }

    public function getEmbeddedFieldToColumnName()
    {
        return [
            [null, null, 'address', null, 'address_'],
            ['My\User', 'My\Address', 'address', 'city', 'address_city'],
        ];
    }

    public function getJoinTableName()
    {
        return [
            ['My\User', 'My\Group', 'groups', 'users_groups'],
            ['My\User', 'My\Group', null, 'users_groups'],
        ];
    }

    public function getJoinKeyColumnName()
    {
        return [
            ['My\User', 'address', 'users_address'],
            ['My\Person', null, 'people_id'],
        ];
    }
}
