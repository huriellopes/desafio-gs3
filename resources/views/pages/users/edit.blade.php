<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between justify-items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit User') }}
            </h2>

            <a href="{{ route('users.index') }}" class="ms-3 text-sm font-medium text-blue-600 dark:text-blue-500 border-2 border-blue-600 dark:border-blue-500 rounded-lg px-3 py-1 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500">
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

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex justify-center w-full gap-6">
                            <div class="w-full">
                                <x-input-label for="name" :value="__('Nome')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name ?? old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="w-full">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email ?? old('email')" required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="w-full">
                                <x-input-label for="role_id" :value="__('Role')" />
                                <select id="role_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" name="role_id" required>
                                    <option value selected disabled>Selecione o perfil</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{$user->role->id === $role->id ? 'selected': ''}}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
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
