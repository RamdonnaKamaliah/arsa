<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white p-6">
        
        <div class="w-full max-w-md bg-white/90 backdrop-blur-lg shadow-2xl rounded-2xl p-8">
            
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Reset Password</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Masukkan password baru untuk akun kamu
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input 
                        id="email" 
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" 
                        type="email" 
                        name="email" 
                        :value="old('email', $request->email)" 
                        required 
                        autofocus 
                        autocomplete="username" 
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input 
                        id="password" 
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password" 
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input 
                        id="password_confirmation" 
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                        type="password"
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password" 
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-primary-button class="w-full justify-center py-3 text-base rounded-lg bg-indigo-600 hover:bg-indigo-700 transition duration-300">
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>
