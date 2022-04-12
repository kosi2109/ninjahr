@props(['title'])
<nav class="navbar shadow navbar-light bg-light fixed-top" style="height: 60px">
  <div class="container d-flex justify-content-between align-items-center">
      @if (request()->is('/'))
     
      <i role="button" class="fs-4 fa-solid fa-bars cursor-pointer" id="sidebarCollapse"></i>
          
      @else
        
      <i role="button" class="fs-4 fa-solid fa-chevron-left cursor-pointer"  id="back"></i>
       
      @endif
      <div>
        <h5 class="m-0">{{$title}}</h5>
      </div>
      <div>

      </div>
  </div>
</nav>