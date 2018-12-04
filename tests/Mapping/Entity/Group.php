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

namespace Webuni\DoctrineExtensions\Tests\Mapping\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
class Group
{
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="group")
     */
    private $users;
}
