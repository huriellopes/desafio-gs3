<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Role;
use App\Traits\Utils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    use Utils;

    /**
     * @param bool $withTrashed
     * @return Collection
     */
    public function list(bool $withTrashed = false) : Collection
    {
        $query = Role::query();

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->select('id', 'name', 'slug', 'status', 'created_at')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * @param object $params
     * @return Role
     */
    public function store(object $params) : Role
    {
        $role = new Role();
        $role->name = $this->clear_tags($params->name);
        $role->slug = $this->set_slug($role->name);
        $role->description = $this->clear_tags($params->description);
        $role->status = StatusEnum::ACTIVE;

        $role->save();

        return $role;
    }

    /**
     * @param Role $role
     * @param object $params
     * @return Role|null
     */
    public function update(Role $role, object $params) : ?Role
    {
        $role->name = $this->clear_tags($params->name);
        $role->slug = $this->set_slug($role->name);
        $role->description = $this->clear_tags($params->description);
        $role->updated_at = Carbon::now();

        $role->save();

        $role->refresh();

        return $role;
    }

    /**
     * @param Role $role
     * @return Role|null
     * @throws \Exception
     */
    public function delete(Role $role) : ?Role
    {
        if ($role->users->isNotEmpty()) {
            throw new \Exception('Essa permissão não pode ser excluída, exclua primeiro os usuários.', 400);
        }

        if ($role->status === StatusEnum::INACTIVE) {
            $role->status = StatusEnum::ACTIVE;
            $role->restore();
        } else {
            $role->status = StatusEnum::INACTIVE;
            $role->delete();
        }

        $role->save();

        $role->refresh();

        return $role;
    }
}
