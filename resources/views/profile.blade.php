<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6  bg-white border-b border-gray-200">

                    <form method="GET" action="{{ route('profile.new.token') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />

                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name',Auth::user()->name)" required autofocus :disabled=true />

                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />

                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email',Auth::user()->email)" required :disabled=true />

                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Token -->
                        <div class="mt-4">
                            <x-input-label for="token" :value="__('Token')" />

                            <x-text-input id="token" class="block mt-1 w-full" type="text" name="token"
                                :value="old('token',Auth::user()->tokenAccess)" required :disabled=true />
                        </div>

                        @if(Auth::user()->role === 'admin')
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Generate New Token') }}
                            </x-primary-button>
                        </div>
                        @endif

                    </form>

                </div>
            </div>
        </div>
    </div>


</x-app-layout>