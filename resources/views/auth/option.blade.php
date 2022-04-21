<x-guest-layout>
    <x-slot name="title">Login</x-slot>
    <div class="col-md-4 m-auto card px-5 py-3 shadow " style="height: 55vh">
        <x-application-logo/> 
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Password</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link " id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Biomateric </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <!-- Password -->
                <form action="/login" method="POST">
                    @csrf
                    <x-input value="{{$_GET['phone']}}" name='phone' id='phone' type='hidden' /> 
                    <x-label name="password" :value="__('Password')" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <button class="btn btn-primary mt-3" >Login</button>
                </form>
                @error('password')
                <span class="text-danger mt-1">{{$message}}</span>
                @enderror
            </div>
            
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <form action="POST" id="login-form">
                    @csrf

                    <button class="d-flex justify-content-center align-items-center mt-3" style="border: none;outline:none;background-color:inherit;width:100%;padding:5px">
                        <div class=" border border-2 d-flex justify-content-center align-items-center rounded-2 text-primary" style="width: 80px;height:80px" >
                            <i class="fa-solid fa-fingerprint fs-1"></i>
                        </div>
                    </button>
                </form>
            </div>

        </div>
          
        
    </div>


    <x-slot name="script">

        <!-- Login users -->
    <script>
        const login = (event) => {
            event.preventDefault();
            new Larapass({
                login: 'webauthn/login',
                loginOptions: 'webauthn/login/options'
            }).login({
                phone: document.getElementById('phone').value
            }).then(response => alert('Authentication successful!'))
              .catch(error => console.log(error))
        }
    
        document.getElementById('login-form').addEventListener('submit', login)
    </script>
    </x-slot>
</x-guest-layout>
