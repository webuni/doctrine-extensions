<?php

$header = <<<EOF
This is part of the webuni/doctrine-extensions package.

(c) Martin Hasoň <martin.hason@gmail.com>
(c) Webuni s.r.o. <info@webuni.cz>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return PhpCsFixer\Config::create()
    ->setRules(array(
        '@PSR2' => true,
        '@PHP71Migration' => true,
        '@Symfony' => true,
        '@PHP71Migration:risky' => true,
        '@Symfony:risky' => true,
        '@PHPUnit60Migration:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'header_comment' => [
            'header' => $header,
        ],
        'ordered_class_elements' => true,
        'ordered_imports' => true,
    ))
    ->setLineEnding("\n")
    ->setUsingCache(false)
    ->setFinder(PhpCsFixer\Finder::create()->in([__DIR__.'/src', __DIR__.'/tests']))
;
