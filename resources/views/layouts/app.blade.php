<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS only -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/datatables/datatables.mark.css')}}">

</head>
<body>
    <div class="wrapper">
        <x-sidebar/>
        <div id="content" class="container-fluid">
            <x-nav title="{{$title}}" />
            {{-- body --}}
            <div class="container py-5 overflow-x-hidden">
                {{$slot}}
            </div>

            <x-nav-bottom/>
        </div>
    </div>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    {{-- datatable --}}
    {{-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script> --}}
    <script src="{{asset('js/datatable/dataTables.min.js')}}"></script>
    <script src="{{asset('js/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('js/datatable/dataTables.rowReorder.min.js')}}"></script>
    <script src="{{asset('js/datatable/datatables.mark.js')}}"></script>
    <script src="{{asset('js/datatable/jquery.mark.min.js')}}"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{$script}}
    <script>
        $(function ($){
            let token = document.head.querySelector('meta[name="csrf-token"]')
            if (token){
                $.ajaxSetup({
                    headers : {
                        'X-CSRF-TOKEN' : token.content
                    }
                })
            }
        })

        $.extend(true, $.fn.dataTable.defaults, {
            mark: true,
            responsive: true,
            processing: true,
            serverSide: true,
            language: {
                paginate: {
                    previous: '<i class="fa-solid fa-chevron-left"></i>',
                    next : '<i class="fa-solid fa-chevron-right"></i>'
                    }
                }
        });

        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
            $('#sidebarCollapseClose').on('click', function () {
                $('#sidebar').removeClass('active');
            });
            $(window).click(function() {
                $('#sidebar').removeClass('active');
            });
            $('#sidebar , #sidebarCollapse ,#sidebarCollapseClose ').click(function(event){
                event.stopPropagation();
            });
            $('#back').click(function(event){
                event.stopPropagation();
                window.history.go(-1)
                return false
            });
        });
    </script>
</body>
</html>