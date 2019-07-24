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
 * @ORM\Table(indexes={@ORM\Index(name="search_idx", columns={"select", "where"})})
 */
class User
{
    /**
     * @ORM\Column(name="`select`")
     */
    private $select;

    /**
     * @ORM\Column()
     */
    private $where;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     */
    private $groups;

    /**
     * @ORM\Column(type="integer")
     */
    private $defaultInteger = 1;

    /**
     * @ORM\Column(type="float")
     */
    private $defaultFloat = 1.1;

    /**
     * @ORM\Column(type="string")
     */
    private $defaultString = 'def';

    /**
     * @ORM\Column(type="boolean")
     */
    private $defaultBoolean = false;

    /**
     * @ORM\Column(type="array")
     */
    private $defaultArray = ['foo', 'bar'];

    /**
     * @ORM\Column(type="simple_array")
     */
    private $defaultSimpleArray = ['foo', 'bar'];

    /**
     * @ORM\Column(type="json")
     */
    private $defaultJson = ['foo' => [1], 'bar' => ['data']];
}
