<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 * @package App\Models
 *
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $status
 *
 */
class Role extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status'
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
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return HasMany
     */
    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
