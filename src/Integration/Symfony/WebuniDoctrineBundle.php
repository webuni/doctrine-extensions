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

namespace Webuni\DoctrineExtensions\Integration\Symfony;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class WebuniDoctrineBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return WebuniDoctrineExtension::class;
    }
}
