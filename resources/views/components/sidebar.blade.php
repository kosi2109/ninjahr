<!-- Sidebar  -->
<nav id="sidebar" class="fixed-top bg-secondary shadow">
    <div class="sidebar-header d-flex justify-content-between align-items-center bg-dark">
        <h5>Ninja HR</h5>
        <button type="button" id="sidebarCollapseClose" style="border: none;outline:none;background-color:inherit">
            <i class="fa-solid fa-xmark text-white fs-3"></i>
        </button>
    </div>

    <div class="d-flex align-items-center p-2" style="width: 100%">
        <div class="me-3 rounded-2 overflow-hidden">
            <img width="70" src="storage/{{auth()->user()->profile_img}}" alt="">
        </div>
        <div class="d-flex flex-column justify-content-center">
            <h6>{{auth()->user()->employee_id}}</h6>
            <h6>{{auth()->user()->department_id ? auth()->user()->department->title : "" }}</h6>
            <h6><i class="fa fa-circle text-success me-2" style="font-size: 10px;coloe:green"></i> online</h6>
        </div>
    </div>

    <ul class="list-unstyled">
        <li>
            <a href="/"><i class="fa-solid fa-house"></i> Home</a>
        </li>
        <li>
            <a href="/employee"><i class="fa-solid fa-user-group"></i> Employee</a>
        </li>
        <li>
            <a href="/department"><i class="fa-solid fa-code-branch"></i> Departments</a>
        </li>
        <li>
            <a href="/role"><i class="fa-solid fa-unlock"></i> Role</a>
        </li>
        <li>
            <a href="/permission"><i class="fa-solid fa-circle-exclamation"></i> Permission</a>
        </li>
    </ul>
</nav>