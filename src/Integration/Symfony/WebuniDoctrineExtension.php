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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;
use Webuni\DoctrineExtensions\Mapping\AutoQuotingSubscriber;
use Webuni\DoctrineExtensions\Mapping\PluralNamingStrategy;

class WebuniDoctrineExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->register(AutoQuotingSubscriber::class)->addTag('doctrine.event_subscriber');

        $container
            ->register('doctrine.orm.naming_strategy.plural_default', PluralNamingStrategy::class)
            ->setArgument(0, new Reference('doctrine.orm.naming_strategy.default'))
        ;

        $container
            ->register('doctrine.orm.naming_strategy.plural_underscore', PluralNamingStrategy::class)
            ->setArgument(0, new Reference('doctrine.orm.naming_strategy.underscore'))
        ;
    }
}
