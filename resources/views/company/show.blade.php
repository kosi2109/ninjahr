<x-app-layout>
    <x-slot name="title">
        {{$company->company_name}}
    </x-slot>

    <div class="position-relative card my-5 p-3 shadow">
        @can('edit_company')
        <div class="position-absolute" style="right:2%" >    
            <a href="/company/1/edit" style="width: 40px;height: 40px;" class="btn btn-dark rounded-circle"><i class="fa-solid fa-pen-to-square"></i></a>
        </div>
        @endcan
        <div class="col-md-6 mx-auto text-center">
            <h2 class="mb-3 fs-1">{{$company->company_name}}</h2>
            <h5 class="mb-3 text-muted fs-4">{{$company->company_phone}} | {{$company->company_email}}</h5>
            <p class="mb-3 fs-4">{{$company->company_address}}</p>
            <p>Office Time ({{$company->office_start_time}} to {{$company->office_end_time}})</p>
            <p>Break Time ({{$company->break_start_time}} to {{$company->break_end_time}})</p>
        </div>
    </div>
    
    <x-slot name="script">
        
    </x-slot>


</x-app-layout>