@extends('layouts.default')
@section('content')

<div class="log_inner text-center">
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
</div>

<div class="container" id="boot_calender">
    <h3>Manage Event</h3>
    <div class="row">
        <div class="col-xs-12">
            {{--<div class="bootstrapModalFullCalendar"></div>--}}
            <div id="myCalender"></div>
        </div>
    </div>
</div>

<div id="fullCalModal" class="modal fade">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title">Event</h4>
            </div>

            <div id="modalBody" class="modal-body">
                <div class="card">
                    <span class="spanFormat">
                    <form  id="updateForm">
                        {{ CSRF_FIELD()}}
                    <div class="card-body">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <input type="hidden" class="id" name="id" id="idupdate">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group">
                            <input type="text" id="updateTaskName" name="updateTaskName" class="form-control " disabled="disabled" required>
                            <span class="input-group-btn">
                            <button class="btn btn-default" id="editBtnTask"  type="button"><i class="fa fa-pencil"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group">
                            <input type="text" id="updateDescription" name="updateDescription" class="form-control " disabled="disabled" contenteditable="false">
                            <span class="input-group-btn">
                            <button class="btn btn-default" id="editBtnDes"  type="button"><i class="fa fa-pencil"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group">
                            <input type="text" id="updateTaskDate" name="updateTaskDate" class="form-control " disabled="disabled" contenteditable="false">
                            <span class="input-group-btn">
                            <button class="btn btn-default" id="editBtnDate"  type="button"><i class="fa fa-pencil"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

                    </div>

                    <button class="btn btn-primary" id="updateBtn" disabled="disabled">Update</button>
                </form>
                        <div class="pull-right">
                        <form id="frmDelete" method="POST">
                        {{CSRF_FIELD()}}
                            <input type="hidden" class="id" name="id">
                        <button class="btn btn-primary id" id="delete" value="id" name="id">Delete</button>
                    </form>
                            </div>
                    </span>



                </div>

            </div>



        </div>
    </div>



</div>
{{--Modal For Creating New Task--}}
<div id="createTaskModal" class="modal fade">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">close</span></button>
                    <h4 id="modalTitle" class="modal-title">Event</h4>
                </div>
                <div id="modalBody" class="modal-body">

                    <div class="card">
                        <form id="frmAdd">
                            {{ CSRF_FIELD()}}
                        <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Task Name(4 characters minimum, only alphanumeric characters)</strong>
                                    <input type="text" id="taskName" name="taskName" class="form-control"  placeholder="Task Name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Task Description(only alphanumeric characters)</strong>
                                    <input type="text" id="description" name="description" class="form-control" placeholder="Description">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Date</strong>
                                    <input type="text" id="taskDate" name="taskDate" class="form-control" placeholder="YYYY-MM-DD">
                                </div>
                            </div>

                        </div>
                        </div>
                    <div class="card-footer">
                        <button id="add-event" class="btn btn-primary">Submit</button>

                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
<script>
    var event_array=[];
    $(document).ready(function() {
        $("#frmAdd").validate({
            rules: {
                taskName: {
                    required: true,
                    pattern:'^[a-zA-Z\s-]+$'
                },
                description: {
                    required: true,
                    pattern:'^[a-zA-Z\s-]+$'
                },
                taskDate: {
                    required: true,
                    pattern:'^\\d{4}\\-(0?[1-9]|1[012])\\-(0?[1-9]|[12][0-9]|3[01])$'
                },
            },
            messages: {
                taskName: {
                    pattern: "Only alphabets,spaces and hyphens are allowed",
                },
                description: {
                    pattern: "Only alphabets,spaces and hyphens are allowed",
                },
                taskDate:{
                    pattern: "Maintain yyyy-mm-dd format",
                }
            }
        });


        getData();

        $('#myCalender').fullCalendar({
            header: {
                left: 'prev,next today',
                center: ' title ',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            dayClick: function(date, jsEvent, view) {
                $("#taskDate").val(moment(date).format('YYYY-MM-DD'));
                $("#createTaskModal").modal("show");

            },

                editable : true,
//            theme: true,
//            themeSystem:'jquery-ui',
            eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view){
                var dropedDate = event.start.format("YYYY-MM-DD");
                var dropID = event.id;
//                console.log(event.id);
//                console.log(dropedDate);
                //console.log(event);
                $.ajax({
                    url: "{{route('drop')}}",
                    type: "POST",
                    data: {
                        dt:dropedDate,id: dropID,_token: "{{Session::token()}}",

                    },
                    success: function(data, textStatus) {
                        toastr.success('Task Updated Successfully', 'Success Alert', {timeOut: 5000});
                    },
                    error: function() {
                         toastr.error('There was an error while fetching events.', 'Request Failed', {timeOut: 5000});
                    }
                });
                getData();
            },
            eventClick:  function(event, jsEvent, view) {
                $('#updateTaskName').attr('value',event.title);
                $('#updateDescription').attr('value',event.description);
                $('#updateTaskDate').attr('value',event.date);
                $('.id').attr('value',event.id);
                $('#idupdate').attr('value',event.id);

                $('#fullCalModal').modal();
                return false;
            },
            eventSources:[
                event_array
            ]

        });
        $('#frmAdd').submit(function(e) {
            e. preventDefault();
//            var i = true;
            //setting variables based on the input fields
            var IsValid=$('#frmAdd').valid();
            if(IsValid) {
                //console.log(data);
                var name = $('input[name="taskName"]').val();
                var description = $('input[name="description"]').val();
                var taskDate = $('input[name="taskDate"]').val();
                $.ajax({
                    url: "{{route('store')}}",
                    type: "POST",

                    data: {name: name, des: description, dt: taskDate, _token: "{{Session::token()}}"},

                    success: function (data) {
                        $('#frmAdd').trigger("reset");
                        $('#createTaskModal').modal('hide');
                        getData();
                        $('#myCalender').fullCalendar('removeEvents');
                        $('#myCalender').fullCalendar('addEventSource', event_array);
                        $('#myCalender').fullCalendar('rerenderEvents');
                        toastr.success('Task Added Successfully', 'Success Alert', {timeOut: 5000});

                    }
                });

            }

        });
        //delete product and remove it from list
        $('#delete').click(function(e) {
            e.preventDefault();
            var eventID = $('.id').val();
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',

            }).then (function() {
                    $.ajax({

                        url: "{{route('delete')}}",
                        type: "POST",
                        data: {
                            id: eventID, _token: "{{Session::token()}}"

                        },
                        success: function () {
                            $('#frmDelete').trigger("reset");
                            $('#fullCalModal').modal('hide');
                            getData();
                            $('#myCalender').fullCalendar('removeEvents');
                            $('#myCalender').fullCalendar('addEventSource', event_array);
                            $('#myCalender').fullCalendar('rerenderEvents');
                            toastr.success('Task Deleted Successfully', 'Success Alert', {timeOut: 5000});
                        }
                    })
            }).catch(swal.noop)
        });
        $('#updateBtn').click(function(e) {
            e.preventDefault();
            var eventID = $('.id').val();
            //setting variables based on the input fields
            var name = $('input[name="updateTaskName"]').val();
            var description = $('input[name="updateDescription"]').val();
            var taskDate = $('input[name="updateTaskDate"]').val();
            $.ajax({

                url: "{{route('edit')}}",
                type: "POST",
                data: {
                    name: name, des: description, dt: taskDate,id: eventID,_token: "{{Session::token()}}"

                },
                success: function (data) {
                    $('#frmDelete').trigger("reset");
                    $('#updateTaskName').attr('disabled',true);
                    $('#updateDescription').attr('disabled',true);
                    $('#updateTaskDate').attr('disabled',true);
                    $('#fullCalModal').modal('hide');
                    getData();
                    $('#myCalender').fullCalendar('removeEvents');
                    $('#myCalender').fullCalendar('addEventSource', event_array);
                    $('#myCalender').fullCalendar('rerenderEvents' );
                    toastr.success('Task Updated Successfully', 'Success Alert', {timeOut: 5000});

                }
            });
        });

    });
    $('#editBtnTask').on('click', function(event) {
        event.preventDefault();

        if ($('#updateTaskName').attr('disabled')){
            $('#updateTaskName').attr('contenteditable','true');
            $('#updateTaskName').removeAttr('disabled');
            $('#updateBtn').removeAttr('disabled');
        }else{
            $('#updateTaskName').attr('contenteditable','false');
            $('#updateTaskName').attr('disabled');
            $('#updateBtn').attr('disabled');
        }
    });
    $('#editBtnDes').on('click', function(event) {
        event.preventDefault();

        if ($('#updateDescription').attr('disabled')){
            $('#updateDescription').attr('contenteditable','true');
            $('#updateDescription').removeAttr('disabled');
            $('#updateBtn').removeAttr('disabled');
        }else{
            $('#updateDescription').attr('contenteditable','false');
            $('#updateDescription').attr('disabled');
            $('#updateBtn').attr('disabled');
        }
    });
    $('#editBtnDate').on('click', function(event) {
        event.preventDefault();

        if ($('#updateTaskDate').attr('disabled')){
            $('#updateTaskDate').attr('contenteditable','true');
            $('#updateTaskDate').removeAttr('disabled');
            $('#updateBtn').removeAttr('disabled');
        }else{
            $('#updateTaskDate').attr('contenteditable','false');
            $('#updateTaskDate').attr('disabled');
            $('#updateBtn').attr('disabled');
        }
    });
    function getData() {
        $.ajax({
            url: '{{route('getCal')}}',
            type: 'GET',
            async: false,
            success: function (data) {
                event_array = [];
                for (i=0; i< data.length; i++) {
                    event_array.push({id:data[i].id,title: data[i].name,description:data[i].description ,date: data[i].task_date});
                }
            },
            error: function () {
                toastr.error('There was an error while fetching events.', 'Request Failed', {timeOut: 5000});
            }
        });

    }
</script>


@endsection