<?php

namespace App\Http\Controllers;

use App\Http\DTO\SearchDTO;
use App\Http\DTO\UserDTO;
use App\Http\Requests\SearchFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserUpdateFormRequest;
use App\Jobs\JobSendingNewUser;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    protected string $viewPath = 'pages.users.';

    /**
     * @param UserService $userService
     */
    public function __construct(
        protected UserService $userService,
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(SearchFormRequest $request)
    {
        $params = SearchDTO::from($request->validated());

        $users = $this->userService->list($params);

        Cache::put('list-users', $users, Carbon::now()->addMinutes(10));

        $users = Cache::get('list-users');

        return view($this->viewPath.'index', compact('users'));
    }

    /**
     * @param RoleService $roleService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create(RoleService $roleService)
    {
        $roles = $roleService->list();

        return view($this->viewPath.'create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {
        try {
            DB::beginTransaction();
                $params = UserDTO::from($request->validated());

                $user = $this->userService->store($params);

                JobSendingNewUser::dispatch($user->id)->onQueue('default');
            DB::commit();

            return redirect()
                ->route('users.index')
                ->with(['success' => 'Usuário criado com sucesso!']);
        } catch (Exception|Throwable $e) {
            DB::rollBack();
            Log::channel('log-error')->error([
                'method' => $request->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . '-' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withErrors(['error' => 'Erro ao criar usuário!'])
                ->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, RoleService $roleService)
    {
        $user->load('role');

        $roles = $roleService->list();

        return view($this->viewPath.'edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateFormRequest $request, User $user)
    {
        try {
            $params = UserDTO::from($request->validated());

            $this->userService->update($user, $params);

            return redirect()
                ->route('users.index')
                ->with(['success' => 'Usuário atualizado com sucesso!']);

        } catch (Exception|Throwable $e) {
            Log::channel('log-error')->error([
                'method' => $request->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . '-' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withErrors(['error' => 'Erro ao atualizar o usuário']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $this->userService->deleteOrRestore($user);

            return redirect()
                ->route('users.index')
                ->with(['success' => 'Usuário excluído com sucesso!']);
        } catch (Exception|Throwable $e) {
            Log::channel('log-error')->error([
                'method' => request()->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . '-' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with(['error' => 'erro ao excluir o usuário']);
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(User $user)
    {
        try {
            $this->userService->deleteOrRestore($user);

            return redirect()
                ->route('users.index')
                ->with(['success' => 'Usuário recuperado com sucesso!']);
        } catch (Exception|Throwable $e) {
            Log::channel('log-error')->error([
                'method' => request()->method(),
                'url' => request()->url(),
                'user' => auth()->user()->id . '-' .auth()->user()->name,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withErrors(['error' => 'erro ao recuperar o usuário']);
        }
    }
}
