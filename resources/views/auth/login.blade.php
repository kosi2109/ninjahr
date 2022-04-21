<x-guest-layout>
    <x-slot name="title">Login</x-slot>
    <div class="col-md-4 m-auto card px-5 py-3 shadow" style="height: 55vh">
        <x-application-logo/> 


        <form action="/login-option">
            <h4 class="text-center text-lg">Login</h4>
            <!-- Email Address -->
            <div class="mb-3">
                <x-label name="phone" :value="__('Phone')" />

                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus />
                @error('phone')
                    <span class="text-danger mt-1">{{$message}}</span>
                @enderror
            </div>
            <button class="btn btn-primary">Next</button>
            <div class="mt-2">
                <a href="/bio-login">Login for biomateric machine .</a>
            </div>
        </form>

    </div>

    <x-slot name="script"></x-slot>

</x-guest-layout>
