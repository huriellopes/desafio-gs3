<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between justify-items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Permissions') }}
            </h2>

            <a href="{{ route('permissions.create') }}"
               class="ms-3 text-sm font-medium text-blue-600 dark:text-blue-500 border-2 border-blue-600 dark:border-blue-500 rounded-lg px-3 py-1 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500">
                {{ __('New Permission') }}
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
                            class="flex items-center gap-3 border border-red-400 bg-red-100 text-red-700 px-4 py-3 rounded relative mb-4">
                            <span class="material-icons md-34">warning</span> {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex w-full mb-3">
                        <form action="{{ route('permissions.index') }}" method="GET" @submit.prevent="$event"
                              class="flex gap-1 ml-auto content-center items-center">
                            <x-text-input id="search"
                                          type="text"
                                          name="search"
                                          placeholder="{{ __('Search...') }}"
                                          :value="old('search') ?: request()->get('search')"
                            />
                            <x-secondary-button type="submit">
                                <span class="material-icons">search</span>
                            </x-secondary-button>
                        </form>
                    </div>

                    <table class="w-full md:w-full table-auto mb-6">
                        <thead class="w-full border-b">
                        <tr class="text-center font-weight-bold">
                            <th>@sortablelink('id', '#', ['parameter' => 'smile'], ['rel' => 'nofollow'])</th>
                            <th>@sortablelink('name', 'Nome')</th>
                            <td>{{ __('Situation') }}</td>
                            <th>{{ __('Created at') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody class="w-full border-b px-3 text-center px-6 py-6">
                        @forelse($permissions as $permission)
                            <tr class="border-b">
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                        <span
                                            class="ms-3 text-sm font-bold border-2 rounded-lg px-3 py-1 {{ $permission->status->value === 1 ? 'text-green-600 dark:text-green-500 border-green-600 dark:border-green-500' : 'text-red-600 dark:text-red-500 border-red-600 dark:border-red-500'}}">
                                            {{ __($permission->status->name) }}
                                        </span>
                                </td>
                                <td>{{ $permission->created_at->format('d/m/Y H:i:s') }}</td>
                                <td class="flex gap-3 justify-center">
                                    <x-secondary-button type="button"
                                                        onclick="window.location='{{ route('permissions.edit', $permission->id) }}'">
                                                <span class="material-icons text-xs">
                                                    edit
                                                </span>
                                    </x-secondary-button>
                                    @if ($permission->status->value == 1)
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" @click="$event.preventDefault()">
                                            @csrf
                                            @method('DELETE')
                                            <x-secondary-button type="submit">
                                                        <span class="material-icons text-xs">
                                                            delete
                                                        </span>
                                            </x-secondary-button>
                                        </form>
                                    @else
                                        <form action="{{ route('permissions.restore', $permission->id) }}" method="POST">
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
                    {!! $permissions->appends(request()->except('page'))->render() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
