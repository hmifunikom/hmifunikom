@if(App::environment('production'))
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
@else
<script src="{{ asset('assets/js/jquery-1.10.2.min.js') }}"></script>
@endif
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-markdown.js') }}"></script>
<script src="{{ asset('assets/js/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/js/markdown.js') }}"></script>
<script src="{{ asset('assets/js/panel.js?v1.2') }}"></script>