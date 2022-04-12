@foreach ($biomateric as $b)
    <div class="col-3">
        <button data-id="{{$b->id}}" class="delete p-4 mb-2 m-0 rounded-2 bg-white border border-dark relative d-flex flex-column justify-content-center align-items-center" style="width:60px;height:60px;position:relative">
            <i class="fa-solid fa-fingerprint fs-2 text-primary"></i>
            <h6 style="position: absolute;right:5%;bottom:0%">{{$loop->iteration}}</h6>
        </button>
    </div>
@endforeach
