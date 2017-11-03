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
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal"> Add Events</a>
            </div>
        </div>
    </div>
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
                    <form action="{{route('post')}}" method="POST" id="updateForm">
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
                    <input type="hidden" class="id" name="id">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group">
                            <input type="text" id="updatetaskName" name="updateTaskName" class="form-control disable" disabled="disabled">
                            <span class="input-group-btn">
                            <button class="btn btn-default editBtn"  type="button"><i class="fa fa-pencil"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group">
                            <input type="text" id="updateDescription" name="updateDescription" class="form-control disable" disabled="disabled" contenteditable="false">
                            <span class="input-group-btn">
                            <button class="btn btn-default editBtn"  type="button"><i class="fa fa-pencil"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group">
                            <input type="text" id="updateTaskDate" name="updateTaskDate" class="form-control disable" disabled="disabled" contenteditable="false">
                            <span class="input-group-btn">
                            <button class="btn btn-default editBtn"  type="button"><i class="fa fa-pencil"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

                    </div>

                    <button class="btn btn-primary" id="updateBtn" disabled="disabled">Update</button>
                </form>
                        <div class="pull-right">
                        <form action="{{route('delete')}}" id="frmDelete" method="POST">
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
                        <form id="frmAdd" action="{{route('store')}}" method="POST">
                            {{ CSRF_FIELD()}}
                        <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Task Name:</strong>
                                    <input type="text" id="taskName" name="taskName" class="form-control" placeholder="Task Name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Task Description:</strong>
                                    <input type="text" id="description" name="description" class="form-control" placeholder="Description">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Date:</strong>
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

        getData();

        $('#myCalender').fullCalendar({

            header: {
                left: '',
                center: 'prev title next',
                right: ''
            },

            eventClick:  function(event, jsEvent, view) {
                $('#updatetaskName').attr('value',event.title);
                $('#updateDescription').attr('value',event.description);
                $('#updateTaskDate').attr('value',event.start);
                $('.id').attr('value',event.id);

                $('#fullCalModal').modal();
                return false;
            },
            eventSources:[
                event_array
            ]
        });
        $('#add-event').click(function(e) {
            e. preventDefault();
            var i = true;
            //setting variables based on the input fields
            var name = $('input[name="taskName"]').val();
            var description = $('input[name="description"]').val();
            var taskDate = $('input[name="taskDate"]').val();
            //console.log(data);

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
                        $('#myCalender').fullCalendar('rerenderEvents' );
                        toastr.success('Task Added Successfully', 'Success Alert', {timeOut: 5000});

                    }
                });
        });
        //delete product and remove it from list
        $('#delete').click(function(e) {
            e.preventDefault();
            var eventID = $('.id').val();
            $.ajax({

                url: "{{route('delete')}}",
                method: "POST",
                data: {
                    id: eventID,_token: "{{Session::token()}}"

                },

                success: function () {
                    $('#frmDelete').trigger("reset");
                    $('#fullCalModal').modal('hide');
                    getData();
                    $('#myCalender').fullCalendar('removeEvents');
                    $('#myCalender').fullCalendar('addEventSource', event_array);
                    $('#myCalender').fullCalendar('rerenderEvents' );
                    toastr.success('Task Deleted Successfully', 'Success Alert', {timeOut: 5000});
                }
            });
        });

    });
    $('.editBtn').on('click', function(event) {
        event.preventDefault();

        if ($('.disable').attr('disabled')){
            $('.disable').attr('contenteditable','true');
            $('.disable').removeAttr('disabled');
            $('#updateBtn').removeAttr('disabled');
        }else{
            $('.disable').attr('contenteditable','false');
            $('.disable').attr('disabled', 'disabled');
            $('#updateBtn').attr('disabled','disabled');
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
                    event_array.push({title: data[i].name,description:data[i].description ,start: data[i].task_date,id:data[i].id});
                }
            },
            error: function () {
                toastr.error('There was an error while fetching events.', 'Request Failed', {timeOut: 5000});
            }
        });

    }
</script>
<script>



    $('#taskDate').datepicker({
        autoclose: true,
        dateFormat: "yy-mm-dd"
    });
</script>
@endsection