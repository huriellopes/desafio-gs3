<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between justify-items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('New User') }}
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

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="flex justify-center w-full gap-6">
                            <div class="w-full">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="block mt-1 w-full"
                                    :value="old('name')"
                                    placeholder="{{ __('Enter name') }}"
                                    required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="w-full">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="block mt-1 w-full"
                                    :value="old('email')"
                                    placeholder="{{ __('Enter email') }}"
                                    required
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="w-full">
                                <x-input-label for="role_id" :value="__('Role')" />
                                <select name="role_id" id="role_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value selected disabled>{{ __('Select profile') }}</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ __($role->name) }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                            </div>
                        </div>

{{--                        <div class="flex justify-center w-full gap-6 mt-4">--}}
{{--                            <div class="w-full">--}}
{{--                                <x-input-label for="password" :value="__('Senha')" />--}}
{{--                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" required autofocus />--}}
{{--                                <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--                            </div>--}}

{{--                            <div class="w-full">--}}
{{--                                <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" />--}}
{{--                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" :value="old('password_confirmation')" required autofocus />--}}
{{--                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <x-secondary-button type="submit" class="mt-4">
                            {{ __('Save') }}
                        </x-secondary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
