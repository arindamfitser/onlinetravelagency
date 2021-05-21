@extends('frontend.layouts.app')
@section('content')

<!--/////////////////////////////////////////-->
<section class="search_result_section innertop_gap">
  <div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <div class="holidaysection text-center" style="padding:25px">
                	<h2> Search result not found! please try another!!</h2>
                	<a class="btn" href="{{ URL::previous() }}"> Back </a>
               </div>
         </div>
    </div>
  </div>
</section>
<!--/////////////////////////////////////////-->

@endsection
