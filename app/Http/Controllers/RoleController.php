<?php

namespace App\Http\Controllers;

use App\Http\DTO\RolesDTO;
use App\Http\Requests\RoleFormRequest;
use App\Models\Role;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\Traits\Utils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class RoleController extends Controller
{
    use Utils;

    protected string $viewPath = 'pages.roles.';

    /**
     * @param RoleService $roleService
     * @param PermissionService $permissionService
     */
    public function __construct(
        protected RoleService $roleService,
        protected PermissionService $permissionService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Role::class);

        $roles = $this->roleService->list(true);

        return view($this->viewPath.'index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Role::class);

        return view($this->viewPath.'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleFormRequest $request)
    {
        Gate::authorize('create', Role::class);

        try {
            DB::beginTransaction();
                $params = RolesDTO::from($request->validated());

                $params->role = $this->roleService->store($params);
            DB::commit();

            return redirect()
                ->route('roles.index')
                ->with(['success' => 'Perfil criado com sucesso!']);
        } catch (Exception|Throwable $e) {
            DB::rollBack();

            Log::channel('log-error')->error([
                'method' => $request->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . ' ' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with(['error' => 'Error ao criar o perfil!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        Gate::authorize('view', $role);
        return response()->json($role);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize('update', $role);

        return view($this->viewPath.'edit', compact('role'));
    }

    /**
     * @param RoleFormRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(RoleFormRequest $request, Role $role)
    {
        Gate::authorize('update', $role);

        try {
            DB::beginTransaction();
                $params = RolesDTO::from($request->validated());

                $params->role = $this->roleService->update($role, $params);
            DB::commit();

            return redirect()
                ->route('roles.index')
                ->with(['success' => 'Perfil atualizado com sucesso!']);
        } catch (Exception|Throwable $e) {
            DB::rollBack();

            Log::channel('log-error')->error([
                'method' => $request->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . ' ' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with(['error' => 'Error ao atualizar o perfil!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Gate::authorize('delete', $role);

        try {
            $this->roleService->delete($role);

            return redirect()
                ->route('roles.index')
                ->with(['success' => 'Perfil excluída com sucesso!']);
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
                ->with('error', $e->getMessage() ?? 'Error ao excluir o perfil!');
        }
    }

    /**
     * @param Role $role
     * @return RedirectResponse
     */
    public function restore(Role $role) : RedirectResponse
    {
        Gate::authorize('restore', $role);

        try {
            $this->roleService->delete($role);

            return redirect()
                ->route('roles.index')
                ->with(['success' => 'Perfil excluída com sucesso!']);
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
                ->with('error', $e->getMessage() ?? 'Error ao recuperar o perfil');
        }
    }
}
