<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between justify-items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('New Permission') }}
            </h2>

            <a href="{{ route('permissions.index') }}" class="ms-3 text-sm font-medium text-blue-600 dark:text-blue-500 border-2 border-blue-600 dark:border-blue-500 rounded-lg px-3 py-1 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500">
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

                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="px-4 py-6 sm:p-8">
                            <div class="w-full">
                                <x-input-label for="name" :value="__('Permission')" />
                                <x-text-input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="block mt-1 w-full"
                                    placeholder="example - {{ __('view-any-modules') }}"
                                    :value="old('name')"
                                    required
                                    autofocus
                                />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    @foreach($roles as $role)
                                        <div class="relative flex gap-x-3">
                                            <div class="flex h-6 items-center">
                                                <x-text-input
                                                    value="{{$role->id}}" id="role-{{$role->id}}" name="role_id[]" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"/>
                                            </div>
                                            <div class="text-sm leading-6">
                                                <x-input-label for="role-{{$role->id}}" :value="__($role->name)" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <x-secondary-button type="submit" class="mt-4">
                            {{ __('Save') }}
                        </x-secondary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
