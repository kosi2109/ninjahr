<x-guest-layout>
    <x-slot name="title">Check In & Out</x-slot>
    <div class="col-md-4 m-auto card p-5 shadow">
        <form method="POST">
            @csrf
            <h4 class="text-center text-lg mb-3">Check In & Out</h4>
            <div class="d-flex justify-content-center align-items-center">
                {{QrCode::size(200)->generate($qr);}}
            </div>
        </form>

    </div>



</x-guest-layout>
