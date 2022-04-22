<!-- Sidebar  -->
<nav id="sidebar" class="fixed-top bg-secondary shadow">
    <div class="sidebar-header d-flex justify-content-between align-items-center bg-dark">
        <h4 class="fs-6 text-left p-0 m-0">The Popup Company Ltd</h4>
        <button type="button" id="sidebarCollapseClose" style="border: none;outline:none;background-color:inherit">
            <i class="fa-solid fa-xmark text-white fs-5"></i>
        </button>
    </div>

    <div class="d-flex align-items-center p-2" style="width: 100%">
        <div class="me-3 rounded-2 overflow-hidden">
            <img width="70" src="{{auth()->user()->profile_img}}" alt="">
        </div>
        <div class="d-flex flex-column justify-content-center">
            <h6>{{auth()->user()->employee_id}}</h6>
            <h6>{{auth()->user()->department_id ? auth()->user()->department->title : "" }}</h6>
            <h6><i class="fa fa-circle text-success me-2" style="font-size: 10px;coloe:green"></i> online</h6>
        </div>
    </div>

    <ul class="list-unstyled components">
        <li>
            <a href="/"><i class="fa-solid fa-house"></i> Home</a>
        </li>
        @can('view_company')
        <li>
            <a href="/company/1/show"><i class="fa-solid fa-building"></i> Company</a>
        </li>
        @endcan
        @can('view_employee')
        <li>
            <a href="/employee"><i class="fa-solid fa-user-group"></i> Employee</a>
        </li>
        @endcan

        @can('view_department')
        <li>
            <a href="/department"><i class="fa-solid fa-network-wired"></i> Departments</a>
        </li>
        @endcan

        @can('view_role')
        <li>
            <a href="/role"><i class="fa-solid fa-unlock"></i> Role</a>
        </li>
        @endcan

        @can('view_permission')
        <li>
            <a href="/permission"><i class="fa-solid fa-circle-exclamation"></i> Permission</a>
        </li>
        @endcan
        

        @can('view_attendance')
        <li>
            <a href="/attendance"><i class="fa-solid fa-list-check"></i> Attendance</a>
        </li>
        @endcan

        @can('view_attendance')
        <li>
            <a href="/attendance/overview"><i class="fa-solid fa-chart-simple"></i> Attendance Overview</a>
        </li>
        @endcan

        @can('view_salary')
        <li>
            <a href="/salary"><i class="fa-solid fa-coins"></i> Salary</a>
        </li>
        @endcan

        @can('view_payroll')
        <li>
            <a href="/payroll"><i class="fa-solid fa-chart-pie"></i> Payrolls</a>
        </li>
        @endcan

        @can('view_project')
        <li>
            <a href="/project"><i class="fa-solid fa-diagram-project"></i> Projects</a>
        </li>
        @endcan
        
    </ul>
    <ul class="list-unstyled px-2">
        <li>
            <form action="/logout" method="POST">
                @csrf
                <button style="width: 100%" class="btn btn-dark">Logout</button>
            </form>
        </li>
    </ul>
</nav>