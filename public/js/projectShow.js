
$(document).ready(function () {
    



    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-dark",
        },
        buttonsStyling: false,
    });

   
    $(document).on("click", ".delete_task_btn", function () {
        const taskId = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this task .",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    url: `/task/${taskId}/delete`,
                }).done(function () {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                    getTasks();
                }); 
            }
          })
    })

    $(document).on("click", ".edit_task_btn", function () {
        const task = $(this).data("task");
        const members_al = $(this).data("members");
        let task_members = "";
        leaders.forEach(function (leader) {
            task_members += `<option ${(members_al.includes(leader.id) ? "selected" : "")} value="${leader.id}">${leader.name}</option>`;
        });
        members.forEach(function (member) {
            task_members += `<option ${(members_al.includes(member.id) ? "selected" : "")} value="${member.id}">${member.name}</option>`;
        });

        swalWithBootstrapButtons
            .fire({
                title: "Add Task",
                html: `<form id="editTaskForm">
            <input type="hidden" name="project_id" value="${pjId}" />
            <input  type="hidden" name="status" value="${task.status}"  />
            
            <div class="mb-3">
                <label class="form-label" for="title">Title</label>
                <input  type="text" name="title" id="title" class="form-control" value="${
                    task.title
                }" />
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Title</label>
                <textarea name="description" id="description" cols="30" rows="3" class="form-control">${
                    task.description
                }</textarea>
            </div>
            

            <div class="mb-3">
                <label class="form-label" for="start_date">Start Date</label>
                <input  type="date" name="start_date" id="start_date" class="form-control" value="${
                    task.start_date
                }" />
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="deadline">Deadline</label>
                <input  type="date" name="deadline" id="deadline" class="form-control" value="${
                    task.deadline
                }" />
            </div>
            
            
            <div class="mb-3">
                <label class="form-label" for="priority">Priority</label>
                <select name="priority" id="priority" class="form-control">
                    <option ${
                        task.priority == "low" ? "selected" : ""
                    } value="low">Low</option>
                    <option ${
                        task.priority == "middle" ? "selected" : ""
                    } value="middle">Middle</option>
                    <option ${
                        task.priority == "high" ? "selected" : ""
                    } value="high">High</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="status">Members</label>
                <select name="members[]" id="members" class="form-control" multiple>
                    ${task_members}      
                </select>
            </div>

            </form>`,
                customClass: {
                    confirmButton: "btn btn-dark",
                },
                confirmButtonText: "Add",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    const form = $("#editTaskForm");

                    const data = form.serializeArray();
                    $.ajax({
                        method: "POST",
                        url: `/task/${task.id}/update`,
                        data: data,
                    }).done(function () {
                        getTasks();
                    }); 
                }
            });
    });

    function getTasks() {
        let task_members = "";
        leaders.forEach(function (leader) {
            task_members += `<option value="${leader.id}">${leader.name}</option>`;
        });
        members.forEach(function (member) {
            task_members += `<option value="${member.id}">${member.name}</option>`;
        });
        $.ajax({
            method: "GET",
            url: `/project/${pjId}/tasks`,
            success: function (data) {
                $("#tasks").html(data);

                var pending = document.getElementById('pending_board');
                var progress = document.getElementById('in_progress_board');
                var complete = document.getElementById('complete_board');


                Sortable.create(pending,{
                    group: "tasks", 
                    sort: true,
                    animation: 150,
                    store : {
                        set : function(sortable){
                            var order = sortable.toArray()
                            localStorage.setItem('pendingSort',order.join(','))
                            sortSerial('pending',order)
                        }
                    },
                    onAdd: function(evt) {
                        let to = evt.to.id.split('_')[0]
                        let task = evt.item.dataset.id
                        teskMoveHandaler(to,task)
                    }
                });
                Sortable.create(progress,{
                    group: "tasks",
                    sort: true,
                    animation: 150,
                    store : {
                        set : function(sortable){
                            var order = sortable.toArray()
                            localStorage.setItem('progressSort',order.join(','))
                            sortSerial('in_progress',order)
                        }
                    },
                    onAdd: function(evt) {
                        let to = evt.to.id.split('_')[0]+'_'+evt.to.id.split('_')[1]
                        let task = evt.item.dataset.id
                       
                        teskMoveHandaler(to,task)
                    }
                });
                Sortable.create(complete,{
                    group: "tasks",
                    sort: true,
                    animation: 150,
                    store : {
                        set : function(sortable){
                            var order = sortable.toArray()
                            localStorage.setItem('completeSort',order.join(','))
                            sortSerial('complete',order)
                        }
                    },
                    onAdd: function(evt) {
                        let to = evt.to.id.split('_')[0]
                        let task = evt.item.dataset.id
                        teskMoveHandaler(to,task)
                    }
                });

                $("#complete , #in_progress , #pending").click(function () {
                    swalWithBootstrapButtons
                        .fire({
                            title: "Add Task",
                            html: `<form id="addTaskForm">
                    <input type="hidden" name="project_id" value="${pjId}" />
                    <input  type="hidden" name="status" value="${this.id}" />
                    
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input  type="text" name="title" id="title" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="description">Title</label>
                        <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                    

                    <div class="mb-3">
                        <label class="form-label" for="start_date">Start Date</label>
                        <input  type="date" name="start_date" id="start_date" class="form-control" />
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" for="deadline">Deadline</label>
                        <input  type="date" name="deadline" id="deadline" class="form-control" />
                    </div>
                    
                    
                    <div class="mb-3">
                        <label class="form-label" for="priority">Priority</label>
                        <select name="priority" id="priority" class="form-control">
                            <option value="low">Low</option>
                            <option value="middle">Middle</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="status">Members</label>
                        <select name="members[]" id="members" class="form-control" multiple>
                            ${task_members}      
                        </select>
                    </div>

                    </form>`,
                            customClass: {
                                confirmButton: "btn btn-dark",
                            },
                            confirmButtonText: "Add",
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                const form = $("#addTaskForm");

                                const data = form.serializeArray();
                                $.ajax({
                                    method: "POST",
                                    url: `/task/store`,
                                    data: data,
                                }).done(function () {
                                    getTasks();
                                });
                            }
                        });
                });
            },
        });
    }
    getTasks();


    function teskMoveHandaler (to,task){
        $.ajax({
            method: "POST",
            url: `/task/${task}/move`,
            data: {to},
        }).done(function () {
            console.log("done");
        });
    }

    function sortSerial (tasks,status){
        $.ajax({
            method: "POST",
            url: `/task/sort`,
            data: {status,tasks},
        }).done(function () {
            console.log("done");
        });
    }
});
const gallery = new Viewer(document.getElementById("images"));
