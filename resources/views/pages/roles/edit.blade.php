<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between justify-items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Role') }}
            </h2>

            <a href="{{ route('roles.index') }}" class="ms-3 text-sm font-medium text-blue-600 dark:text-blue-500 border-2 border-blue-600 dark:border-blue-500 rounded-lg px-3 py-1 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if(session('error'))
                        <div
                            class="flex items-center gap-3 border border-red-400 bg-red-100 text-red-700 px-4 py-3 rounded relative mb-4">
                            <span class="material-icons md-34">warning</span> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('roles.update', $role->slug) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="flex justify-center w-full gap-6">
                            <div class="w-full">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="block mt-1 w-full"
                                    :value="$role->name ?? old('name')"
                                    required
                                    autofocus
                                />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="w-full">
                                <x-input-label for="description" :value="__('Description')" />
                                <x-text-input
                                    type="text"
                                    name="description"
                                    id="description"
                                    class="block mt-1 w-full"
                                    :value="$role->description ?? old('description')"
                                    required
                                />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <x-secondary-button type="submit" class="mt-4">
                            {{ __('Edit') }}
                        </x-secondary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
