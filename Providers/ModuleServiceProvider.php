<?php

declare(strict_types=1);

/**
 * Contains the ModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-03-17
 *
 */

namespace Vanilo\Taxes\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Vanilo\Taxes\Calculators\NullTaxCalculator;
use Vanilo\Taxes\Contracts\TaxRateResolver;
use Vanilo\Taxes\Models\TaxCategory;
use Vanilo\Taxes\Models\TaxCategoryType;
use Vanilo\Taxes\Models\TaxRate;
use Vanilo\Taxes\Resolver\TaxEngineManager;
use Vanilo\Taxes\TaxCalculators;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        TaxCategory::class,
        TaxRate::class,
    ];

    protected $enums = [
        TaxCategoryType::class,
    ];

    public function register(): void
    {
        parent::register();

        $this->app->singleton(TaxEngineManager::class, fn ($app) => new TaxEngineManager($app));
        $this->app->bind(TaxRateResolver::class, fn ($app) => $app->make(TaxEngineManager::class)->driver());

        TaxCalculators::register('none', NullTaxCalculator::class);
    }
}
