@extends('layouts.app')

@section('title','Full Calendar')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Full Calendrier</title>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="alert alert-success alert-dismissible fade show d-none" id="alert" role="alert">
                <strong>success : </strong><span id="alertMessage"></span>
                <button type="button" class="btn-close" id="btnClose" aria-label="Close"></button>
            </div>                
            <div class="col-12">
                <h4 class="text-center">Full Calendar</h4>
                <div class="col-md-12 text-center py-5" id="calendar"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Créer un Événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Créer un Événement du <span id="start_date"></span> au <span id="end_date"></span></h5>

                    <form id="eventForm">
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="eventName">
                            <div id="nameError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Description</label>
                            <textarea id="eventDesc" class="form-control" cols="3" rows="3" style="resize: none"></textarea>
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Modifier l'Événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editEventForm">
                        <div class="mb-3">
                            <label for="editEventName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editEventName">
                            <div id="editNameError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editEventDescription" class="form-label">Description</label>
                            <textarea id="editEventDesc" class="form-control" cols="3" rows="3" style="resize: none"></textarea>
                        </div>
                        <button type="submit" id="update" class="btn btn-primary">Mettre à jour</button>
                        <button type="button" id="delete" class="btn btn-danger">Supprimer</button>
                    </form>
                    <div class="alert alert-warning fade show d-none my-3" id="alertWarning" role="alert">
                        <strong>info : </strong><span id="alertInfo"></span>
                    </div>                        
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            let eves  = @json($events);
            let calendrier  = @json($calendrier);
        
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#btnClose").on('click',function(e){
                $("#alert").addClass("d-none");
            });

            let calendarEl = document.getElementById('calendar');
            let start_date = new Date();
            let end_date = new Date();
            
            let calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left:"prev,next today",
                    center:"title",
                    right : "dayGridMonth, timeGridWeek, timeGridDay, listMonth"
                    // dayGridYear
                },
                initialView: 'dayGridMonth',
                timeZone: 'Africa/Casablanca',
                editable: true,
                selectable: true,
                // validRange: {
                //     start: new Date().toISOString().split('T')[0],
                // },
                events : eves.map(event => ({
                    id: event.id,
                    title: event.name,
                    start: event.start_date,
                    end: event.end_date,
                    description: event.description
                })),
                droppable: true,
                select: function(info) {
                    start_date = info.startStr;
                    end_date = info.endStr;
                    
                    $('#eventStart').val(info.startStr);
                    $('#eventEnd').val(info.endStr);

                    $('#start_date').text(info.startStr);
                    $('#end_date').text(info.endStr);

                    $('#eventName').val('');
                    $('#eventDesc').val('');

                    $('#eventModal').modal('toggle');

                    calendar.unselect();
                },
                eventClick: function(info) {
                    // $('#editEventId').val(info.event.id);
                    // $('#editEventStart').val(info.event.startStr);
                    // $('#editEventEnd').val(info.event.endStr);

                    id = info.event.id;
                    start_date = info.event.startStr;
                    end_date = info.event.endStr;
                    $('#editEventName').val(info.event.title);
                    $('#editEventDesc').val(info.event.extendedProps.description);
                    
                    $("#alertInfo").text('');
                    $("#alertWarning").addClass("d-none");

                    $('#editEventModal').modal('show');
                },
                eventDrop: function(info) {
                    let id = info.event.id;
                    let start_date = info.event.startStr;
                    let end_date = info.event.endStr;

                    $.ajax({
                        url: `/events/${id}/update-date`,
                        method: "PUT",
                        data: {
                            start_date: start_date,
                            end_date: end_date
                        },
                        success: function(response) {
                            console.log(response.message);
                            $("#alertMessage").text(response.message);
                            $("#alert").removeClass("d-none");
                        },
                        error: function(xhr) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                console.log('Message d\'erreur:', response.message);
                            }
                        }
                    });
                }

            });

            calendar.render();

            $('#eventForm').on('submit', function(e) {
                e.preventDefault();

                let name = $('#eventName').val();
                let description = $('#eventDesc').val();

                $.ajax({
                    url: "/events",
                    method: "Post",
                    data : {
                        name: name,
                        start_date: start_date,
                        end_date: end_date,
                        description: description,
                        calendrier_id: calendrier.id
                    },
                    success: function(response) {
                        console.log(response);
                        
                        $('#eventModal').modal('hide');
                        
                        calendar.addEvent({
                            id: response.event.id,
                            title: response.event.name,
                            start: response.event.start_date,
                            end: response.event.end_date,
                            description: response.event.description
                        });

                        if(response.message) {
                            $("#alertMessage").text(response.message);
                            $("#alert").removeClass("d-none");
                        }

                    },
                    error: function(xhr) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            console.log('Message d\'erreur:', response.message);
                        }
                        if (response.errors) {
                            $('#nameError').text(response.errors.name);
                        }
                    }
                });
            });
            $('#editEventForm').on('submit', function(e) {
                e.preventDefault();

                let name = $('#editEventName').val();
                let description = $('#editEventDesc').val();
                
                $.ajax({
                    url: `/events/${id}`,
                    method: "Put",
                    data: {
                        name: name,
                        description: description,
                        start_date: start_date,
                        end_date: end_date,
                        calendrier_id: calendrier.id
                    },
                    success: function(response) {
                        $('#editEventModal').modal('hide');

                        let event = calendar.getEventById(id);

                        event.setProp('title', name);
                        event.setExtendedProp('description', description);

                        if(response.message) {
                            $("#alertMessage").text(response.message);
                            $("#alert").removeClass("d-none");

                            $("#alertInfo").text('');
                            $("#alertWarning").addClass("d-none");
                        }

                    },
                    error: function(xhr) {
                        var response = JSON.parse(xhr.responseText);

                        if (response.message) {
                            console.log('Message d\'erreur:', response.message);
                        }
                        if(response.info) {
                            $("#alertInfo").text(response.info);
                            $("#alertWarning").removeClass("d-none");
                        }
                        if (response.errors) {
                            $('#editNameError').text(response.errors.name);
                        }
                    }
                });
            });

            $('#delete').on('click', function() {

                if(confirm("are you sure you want to delete this event?")){

                    $.ajax({
                        url: `/events/${id}`,
                        method: "DELETE",
                        success: function(response) {
                            $('#editEventModal').modal('hide');
                            let event = calendar.getEventById(id);
                            event.remove();

                            $("#alertMessage").text(response.message);
                            $("#alert").removeClass("d-none");
                        },
                        error: function(xhr) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                console.log('Message d\'erreur:', response.message);
                            }
                        }
                    });

                }
            });
        });
    </script>
</body>
</html>

@endsection
