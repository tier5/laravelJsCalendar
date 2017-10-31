@extends('layouts.default')
@section('content')
<h3>Manage Event</h3>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <a class="btn btn-primary" href="{{ route('calendars.create') }}"> Add Events</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div id="bootstrapModalFullCalendar"></div>
        </div>
    </div>
</div>
<div id="fullCalModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-primary" id="eventUrl" target="_blank">Event Page</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#bootstrapModalFullCalendar').fullCalendar({
            header: {
                left: '',
                center: 'prev title next',
                right: ''
            },
            eventClick:  function(event, jsEvent, view) {
                $('#modalTitle').html(event.title);
                $('#modalBody').html(event.description);
                $('#eventUrl').attr('href',event.url);
                $('#fullCalModal').modal();
                return false;
            },
            events : [
                    @foreach($calendar as $cal)
                {

                    title : '{{ $cal->name}}',
                    description: '{{ $cal->description }}',
                    start : '{{ $cal->task_date }}',
                    url : '{{ route('calendars.create', $cal->id) }}'
                },
                @endforeach
            ],
        })
    });
</script>
@endsection