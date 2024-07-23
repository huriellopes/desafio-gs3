<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Jobs\JobSendingNewUser;
use App\Models\User;
use App\Traits\Utils;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    use Utils;

    /**
     * @param object|null $params
     * @return LengthAwarePaginator
     */
    public function list(object $params = null) : LengthAwarePaginator
    {
        $query = User::query()
            ->withTrashed()
            ->where('id', '<>', auth()->user()->id);

        if (!empty($params->search)) {
            $query->where('name', 'ilike', "%{$params->search}%");
        }

        return $query->sortable()
            ->select('id', 'name', 'email', 'role_id', 'status', 'created_at')
            ->paginate(10);
    }

    /**
     * @param object $params
     * @return User
     */
    public function store(object $params) : User
    {
        $user = new User();
        $user->name = $this->clear_tags($params->name);
        $user->email = $this->clear_tags($params->email);
        $user->password = bcrypt('secret');
        $user->role_id = $this->clear_tags($params->role_id);

        $user->save();

        return $user;
    }

    /**
     * @param User $user
     * @param object $params
     * @return User
     */
    public function update(User $user, object $params) : User
    {
        $user->name = $params->name;
        $user->email = $params->email;
        $user->role_id = $params->role_id;
        $user->updated_at = Carbon::now();

        $user->save();

        $user->refresh();

        return $user;
    }

    /**
     * @param User $user
     * @return User|null
     * @throws \Exception
     */
    public function deleteOrRestore(User $user) : ?User
    {
        if ($user->id === auth()->user()->id) {
            throw new \Exception('Você não pode se excluir.', 400);
        }

        if ($user->status === StatusEnum::INACTIVE) {
            $user->status = StatusEnum::ACTIVE;
            $user->restore();
        } else {
            $user->status = StatusEnum::INACTIVE;
            $user->delete();
        }

        $user->save();

        $user->refresh();

        return $user;
    }
}
