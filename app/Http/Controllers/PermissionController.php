<?php

namespace App\Http\Controllers;

use App\Http\DTO\SearchDTO;
use App\Http\Requests\PermissionFormRequest;
use App\Http\Requests\SearchFormRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use App\Services\RoleService;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class PermissionController extends Controller
{
    /**
     * @param PermissionService $permissionService
     * @param string $viewPath
     */
    public function __construct(
        protected PermissionService $permissionService,
        protected string $viewPath = 'pages.permissions.'
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(SearchFormRequest $request)
    {
        $params = SearchDTO::from($request->validated());

        $permissions = $this->permissionService->list($params);

        return view($this->viewPath.'index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(RoleService $roleService)
    {
        $roles= $roleService->list();
        return view($this->viewPath.'create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionFormRequest $request)
    {
        try {
            $permission = Permission::create($request->validated());

            $permission->roles()->sync($request->role_id);

            return redirect()
                ->route('permissions.index')
                ->with(['success' => 'Permissão criada com sucesso!']);

        } catch (Exception|Throwable $e) {
            Log::channel('log-error')->error([
                'method' => $request->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . ' ' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Erro ao inserir a permissão!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return view('permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission, RoleService $roleService)
    {
        $permission->load('roles');

        $roles = $roleService->list();
        return view($this->viewPath.'edit', compact('permission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionFormRequest $request, Permission $permission)
    {
        try {
            $permission->update($request->validated());

            $permission->roles()->detach();

            $permission->roles()->sync($request->role_id);

            return redirect()
                ->route('permissions.index')
                ->with(['success' => 'Permissão atualizada com sucesso!']);
        } catch (Exception|throwable $e) {
            Log::channel('log-error')->error([
                'method' => $request->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . ' ' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Erro ao inserir a permissão!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $this->permissionService->deleteOrRestore($permission);

            return redirect()
                ->route('permissions.index')
                ->with(['success' => 'Permissão excluída com sucesso!']);
        } catch (\Exception|\Throwable $e) {
            Log::channel('log-error')->error([
                'method' => request()->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . ' ' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', $e->getMessage() ?? 'Erro ao excluir a permissão');
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Permission $permission)
    {
        try {
            $this->permissionService->deleteOrRestore($permission);

            return redirect()
                ->route('permissions.index')
                ->with(['success' => 'Permissão recuperada com sucesso!']);
        } catch (Exception|Throwable $e) {
            Log::channel('log-error')->error([
                'method' => request()->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . ' ' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', $e->getMessage() ?? 'erro ao recuperar a permissão');
        }
    }
}
