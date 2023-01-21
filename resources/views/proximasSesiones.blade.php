@push('head-content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
@endpush

<!-- Event calendar -->
<div id='calendar' class="my-3"></div>

@push('scripts')
    <script>
        $(document).ready(function () {
            var SITEURL = "{{env('APP_URL')}}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                height: 400,
                editable: true,
                events: SITEURL + "/eventos",
                displayEventTime: true,
                eventRender: function (event, element, view) {
                    event.allDay = event.allDay === 'true';
                }, eventColor: '#378006',
            });
        });

        function displayMessage(message) {
            toastr.success(message, 'Event');
        }

    </script>

    <!--DONT CHANGE THE ORDER-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endpush