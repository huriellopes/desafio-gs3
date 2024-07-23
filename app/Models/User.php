<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

/**
 * Class User
 * @package App\Models
 *
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role_id
 * @property string $status
 * @property string $accessed_first_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Sortable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'accessed_first_at',
    ];

    /**
     * @var string[]
     */
    public array $sortable = [
        'id',
        'name',
        'email',
        'role_id',
        'status',
        'created_at',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'status' => StatusEnum::class,
            'email_verified_at' => 'datetime',
            'accessed_first_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];
    }

    public static function withTrashed(bool $withTrashed = true): \Illuminate\Database\Eloquent\Builder
    {
        return parent::query()
            ->when($withTrashed, function ($query) {
                return $query->withTrashed();
            });
    }

    /**
     * @return BelongsTo
     */
    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
