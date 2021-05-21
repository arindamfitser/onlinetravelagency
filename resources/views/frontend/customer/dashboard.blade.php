@extends('frontend.layouts.app')

 @section('css')
<link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.7.1/fullcalendar.min.css'>
<link href="{{ asset('fullcalender') }}/fullcalendar.print.min.css" rel='stylesheet' media='print' />
 @endsection

@section('content')
<!--Banner sec-->
{{ asset('fullcalender') }}
<section class="profile dashboard hometop_gap">
   @include('frontend.layouts.customer_sidenav')
    <div class="dashboard_content">
    <h1>My Dashboard</h1>
          <div class="row">
          <div class="col-md-12">      
            </div>
            <div class="col-md-6">
              
        
             </div>
             <div class="col-md-6">
                      
             </div>
           </div>
    </div>
            
           
</section>
<div class="clearfix"></div>




@endsection

@section('script')
<script src="{{ asset('fullcalender') }}/lib/moment.min.js"></script>
<script src="{{ asset('fullcalender') }}/fullcalendar.js"></script>
<script type="text/javascript">
  
  $(document).ready(function() {

       $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },
      defaultDate: '2019-01-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day Event',
          start: '2019-01-01'
        },
        {
          title: 'Long Event',
          start: '2019-01-07',
          end: '2019-01-10'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2019-01-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2019-01-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2019-01-11',
          end: '2019-01-13'
        },
        {
          title: 'Meeting',
          start: '2019-01-12T10:30:00',
          end: '2019-01-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2019-01-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2019-01-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2019-01-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2019-01-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2019-01-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2019-01-28'
        }
      ]
    });

  });

</script>

<style>

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>

@endsection
