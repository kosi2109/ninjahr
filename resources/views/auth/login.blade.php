<x-guest-layout>
    <x-slot name="title">Login</x-slot>
    <div class="col-md-4 m-auto card px-5 py-3 shadow">
        <x-application-logo/> 


        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h4 class="text-center text-lg">Login</h4>
            <!-- Email Address -->
            <div class="mb-3">
                <x-label name="phone" :value="__('Phone')" />

                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus />
                @error('phone')
                    <span class="text-danger mt-1">{{$message}}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label name="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="d-flex align-items-start flex-column justify-content-end mt-4">
                

                <button class="btn btn-primary">
                    Login
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
