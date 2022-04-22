<x-guest-layout>
    <x-slot name="title">Login For Biometric Machine</x-slot>
    <div class="col-md-4 m-auto card px-5 py-3 shadow" style="min-height: 55vh">
        <form method="POST">
            @csrf
            <h4 class="text-center text-lg mb-3">Login For Biometric Machine</h4>
            <x-form.input name='machine_id' />
            <x-form.input name='password' />
            <button class="btn btn-primary">Next</button>
            <div class="mt-2">
                <a href="/login">Login for employee.</a>
            </div>
        </form>
        <ul>
            @if($errors->any())
                {!! implode('', $errors->all('<li class="text-danger">:message</li>')) !!}
            @endif
          </ul>
    </div>

    <x-slot name="script"> </x-slot>

</x-guest-layout>
