<x-app-layout>
    
    <x-slot name="title">
        Attendances Overview
    </x-slot>
    
    <div class="card shadow my-4 p-3">
        <h4 class="text-muted">Overview</h4>
        <div class="d-flex justify-content-between">
            <div style="font-size:0.8rem">
                <p class="me-2"><i class="fa-solid fa-circle-check text-success"></i> - Present</p>
                <p class="me-2"><i class="fa-solid fa-person-running text-warning"></i> - Late</p>
                <p class="me-2"><i class="fa-solid fa-circle-exclamation text-warning"></i> - Early checkout</p>
                <p class="me-2"><i class="fa-solid fa-circle-xmark text-danger"></i> - Absent</p>
            </div>
            <div>
                <input type="text" class="form-control mb-2" id="employee_id" name="employee_id" placeholder="Employee Id">
                <select name="month" id="month" class="form-select mb-2">
                    <option value="01" @if(now()->format('m') == '01') selected @endif>Jan</option>
                    <option value="02" @if(now()->format('m') == '02') selected @endif>Feb</option>
                    <option value="03" @if(now()->format('m') == '03') selected @endif>Mar</option>
                    <option value="04" @if(now()->format('m') == '04') selected @endif>Apr</option>
                    <option value="05" @if(now()->format('m') == '05') selected @endif>May</option>
                    <option value="06" @if(now()->format('m') == '06') selected @endif>Jun</option>
                    <option value="07" @if(now()->format('m') == '07') selected @endif>July</option>
                    <option value="08" @if(now()->format('m') == '08') selected @endif>Aug</option>
                    <option value="09" @if(now()->format('m') == '09') selected @endif>Sep</option>
                    <option value="10" @if(now()->format('m') == '10') selected @endif>Oct</option>
                    <option value="11" @if(now()->format('m') == '11') selected @endif>Nov</option>
                    <option value="12" @if(now()->format('m') == '12') selected @endif>Dec</option>
                </select>

                <select name="year" id="year" class="form-select mb-2">
                    @for ($i = 0; $i < 5; $i++)
                        <option value="{{now()->subYear($i)->format('Y')}}" @if(now()->format('Y') == now()->subYear($i)->format('Y')) @endif>{{now()->subYear($i)->format('Y')}}</option>
                    @endfor
                </select>

                <div class="d-flex justify-content-end" id="searchBtn">
                    <button class="btn btn-dark" >Search</button>
                </div>
            </div>
        </div>
        <div class="table-responsive" id="tableContainer">
            
        </div>
    </div>


    <x-slot name="script">
        <script>

                function getTable (employee_id,month,year){
                    $.ajax({
                        url : `/attendance/overview-table?employee_id=${employee_id}&month=${month}&year=${year}`,
                        type : 'GET',
                        success : function(data){
                            $('#tableContainer').html(data)
                        }
                    })
                }
            $(document).ready(
                $('#searchBtn').click(function(){
                    const month = $('#month').val()
                    const year = $('#year').val()
                    const employee_id = $('#employee_id').val()
                    getTable(employee_id,month,year)
                })

            
            )
           
        </script>
    </x-slot>
</x-app-layout>