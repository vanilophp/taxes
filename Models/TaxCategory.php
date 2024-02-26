<?php

declare(strict_types=1);

/**
 * Contains the TaxCategory class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-03-21
 *
 */

namespace Vanilo\Taxes\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Konekt\Enum\Eloquent\CastsEnums;
use Vanilo\Taxes\Contracts\TaxCategory as TaxCategoryContract;
use Vanilo\Taxes\Contracts\TaxCategoryType;

/**
 * @property-read int $id
 * @property string $name
 * @property TaxCategoryType $type
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TaxCategory extends Model implements TaxCategoryContract
{
    use CastsEnums;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'bool',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected array $enums = [
        'type' => 'TaxCategoryTypeProxy@enumClass',
    ];

    public static function findByName(string $name): ?TaxCategoryContract
    {
        return static::actives()->where('name', $name)->first();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): TaxCategoryType
    {
        return $this->type;
    }

    public function scopeActives(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
