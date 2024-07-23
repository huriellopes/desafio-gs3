<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PermissionService
{
    /**
     * @param object|null $params
     * @return LengthAwarePaginator
     */
    public function list(?object $params) : LengthAwarePaginator
    {
        $permissions = Permission::query()
            ->withTrashed();

        if (!empty($params->search)) {
            $permissions->where('name', 'ilike', '%'.$params->search.'%');
        }

        return $permissions
            ->sortable()
            ->select('id', 'name', 'status', 'created_at')
            ->paginate(10);
    }

    /**
     * @param Permission $permission
     * @return Permission
     * @throws \Exception
     */
    public function deleteOrRestore(Permission $permission)
    {
        if($permission->roles->map(fn($role) => $role->users->isNotEmpty())->first()) {
            throw new \Exception('Desvincule o perfil dos usuários para excluir esta permissão.', 400);
        }

        if ($permission->status === StatusEnum::INACTIVE) {
            $permission->status = StatusEnum::ACTIVE;
            $permission->roles()->withTrashed()->get()->map(function ($role) {
                return $role->update(['status' => StatusEnum::ACTIVE]);
            });
            $permission->roles()->withTrashed()->get()->map(fn($role) => $role->restore());
            $permission->restore();
        } else {
            $permission->status = StatusEnum::INACTIVE;
            $permission->roles->map(function ($role) {
                return $role->update(['status' => StatusEnum::INACTIVE]);
            });
            $permission->roles->map(fn($role) => $role->delete());
            $permission->delete();
        }

        $permission->save();

        $permission->refresh();

        return $permission;
    }
}
