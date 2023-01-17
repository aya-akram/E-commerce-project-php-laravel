@extends('site.master')



@section('content')
<section class="products section">
	   <div class="container">
	      <h3>All Notifications ({{Auth::user()->notifications->count() }} )</h3>
        </div>
</section> 

@stop
