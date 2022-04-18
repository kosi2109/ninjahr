<x-app-layout>
    <x-slot name="title">
        Attedance
    </x-slot>
    <div class="row py-4">
      <div class="shadow card text-center p-3 mb-2">
          <div class="d-flex justify-content-center p-3">
              <img class="text-primary" src="{{asset('images/qr.svg')}}" alt="qr" style="max-width: 80%">
          </div>
          <h6>Please scan qr for CheckIn & CheckOut</h6>
          <button type="button" data-bs-toggle="modal" data-bs-target="#qrmodal" class="btn btn-primary btn-sm mt-2" style="width: 120px;align-self:center">Scan</button>
      </div>
      <div class="shadow card p-3">
        <a href="/my-attendance" class="btn btn-success btn-md">Check Your Attendance</a>
      </div>
    </div>

    <!-- Modal -->
<div class="modal modal-centered fade" id="qrmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Scan QR</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <video id="preview" width="100%"></video>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-centered fade" id="pinmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enter Pin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="text" name="mycode" id="pincode-input1" autofocus>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <x-slot name="script">
        <script src="{{asset('js/attendance.js')}}"></script>
    </x-slot>
</x-app-layout>