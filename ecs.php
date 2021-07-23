<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;


return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
             'syntax' => 'short',
         ]]);

    // run and fix, one by one
    $containerConfigurator->import(SetList::CLEAN_CODE);
    $containerConfigurator->import(SetList::SYMFONY);
    $containerConfigurator->import(SetList::PHP_71);
    $containerConfigurator->import(SetList::PHP_73_MIGRATION);
    $containerConfigurator->import(SetList::PSR_12);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SKIP, [
        \PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer::class => null,
        \PhpCsFixer\Fixer\Phpdoc\PhpdocTrimConsecutiveBlankLineSeparationFixer::class => null,
        \PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer::class => null,
        \SlevomatCodingStandard\Sniffs\Whitespaces\DuplicateSpacesSniff::class => null,
        \PhpCsFixer\Fixer\Operator\ConcatSpaceFixer::class => null,
    ]);
};
