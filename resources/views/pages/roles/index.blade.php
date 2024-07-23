<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between justify-items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Roles') }}
            </h2>

            <a href="{{ route('roles.create') }}"
               class="ms-3 text-sm font-medium text-blue-600 dark:text-blue-500 border-2 border-blue-600 dark:border-blue-500 rounded-lg px-3 py-1 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500">
                {{ __('New Role') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div
                            class="flex items-center gap-3 border border-green-400 bg-green-100 text-green-700 px-4 py-3 rounded relative mb-4">
                            <span class="material-icons md-34">check</span> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div
                            class="flex items-center gap-3 border border-red-400 bg-red-100 text-red-700 px-4 py-3 rounded relative mb-4"
                            x-data="{ show: true }"
                            x-show="show"
                            x-init="setTimeout(() => show = false, 10000)"
                        >
                            <span class="material-icons md-34">warning</span> {{ session('error') }}
                        </div>
                    @endif

                    <table class="w-full">
                        <thead class="w-full border-b">
                        <tr class="font-uppercase">
                            <th>#</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Situation') }}</th>
                            <th>{{ __('Created at') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody class="w-full border-b px-3 text-center">
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ __($role->name) }}</td>
                                <td>
                                    <span class="ms-3 text-sm font-bold border-2 rounded-lg px-3 py-1 {{ $role->status->value === 1 ? 'text-green-600 dark:text-green-500 border-green-600 dark:border-green-500' : 'text-red-600 dark:text-red-500 border-red-600 dark:border-red-500'}}">
                                        {{ __($role->status->name) }}
                                    </span>
                                </td>
                                <td>{{ $role->created_at->format('d/m/Y H:i:s') }}</td>
                                <td class="flex gap-3 justify-center">
                                    <x-secondary-button type="button"
                                                        onclick="window.location='{{ route('roles.edit', $role->slug) }}'">
                                                <span class="material-icons text-xs">
                                                    edit
                                                </span>
                                    </x-secondary-button>
                                    @if ($role->status->value == 1)
                                        <form action="{{ route('roles.destroy', $role->slug) }}" method="POST" @click="$event.preventDefault()">
                                            @csrf
                                            @method('DELETE')
                                            <x-secondary-button type="submit">
                                                        <span class="material-icons text-xs">
                                                            delete
                                                        </span>
                                            </x-secondary-button>
                                        </form>
                                    @else
                                        <form action="{{ route('roles.restore', $role->slug) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <x-secondary-button type="submit">
                                                        <span class="material-icons text-xs">
                                                            restore
                                                        </span>
                                            </x-secondary-button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100">Não há registros....</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
