@extends('layouts/contentNavbarLayout')

@section('title', 'Calendar')

@section('page-script')
  @vite('resources/assets/js/Calendar.js')
@endsection

@section('content')
<div class="card p-5">
  <div id='calendar'></div>
</div>
<script>
  // Make PHP data available to JS
  window.reservations = @json($reservations);
</script>
@endsection
