<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

/**
 * Class Permission
 *
 * @property string $id
 * @property string $name
 * @property StatusEnum $status
 */
class Permission extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * @var string[]
     */
    public array $sortable = [
        'id',
        'name',
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'status' => StatusEnum::class,
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * @param bool $withTrashed
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function withTrashed(bool $withTrashed = true): \Illuminate\Database\Eloquent\Builder
    {
        return parent::query()
            ->when($withTrashed, function ($query) {
                return $query->withTrashed();
            });
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
