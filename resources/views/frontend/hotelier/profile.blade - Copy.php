@extends('frontend.layouts.app')
@section('content')
<!--Banner sec-->


<section class="profile dashboard">
        <div class="container">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="sidenav">
                       <ul>
                           <li></li>
                           <li></li>
                           <li></li>
                           <li></li>
                           <li></li>
                           <li></li>
                       </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                <h1>Our Dashboard</h1>
                                
                                <div class="owl-carousel owl-theme" id="client_logo_slider">
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/1.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/2.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/3.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/4.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/5.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/6.jpg') }}" /> </div>
                                    </div>
                                    <div class="item">
                                            <div class="logo_box_inner"> <img src="{{ asset('frontend/images/partners/7.jpg') }}" /> </div>
                                    </div>
                            </div>
                                
                        </div>

                </div>
        </div>
</section>

@endsection
