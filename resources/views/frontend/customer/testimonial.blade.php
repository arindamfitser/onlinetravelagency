@extends('frontend.layouts.app')
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
  @include('frontend.layouts.customer_sidenav')
  <div class="dashboard_content">
    <h1>My Testimonials</h1>
    @include('frontend.layouts.messages')
    <div class="update_profile">
      <a href="javascript:void(0);" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i> ADD</a>
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Testimonial</h4>
            </div>
            <form action="{{ route('customer.testimonial.add') }}" method="post">
              {{ csrf_field() }}
            <div class="modal-body">
              <?php 
              $lang = @\Session::get('language');
              $user = auth('web')->user();
              ?>
              <input type="hidden" name="locale" id="locale" value="<?php echo $lang; ?>">
              <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->id; ?>">
              <input type="hidden" name="testimonials_name" id="testimonials_name" value="<?php echo $user->first_name.' '.$user->last_name; ?>">
              <textarea class="form-control" name="testimonials_content" id="  testimonials_content" placeholder="Please write some text..."></textarea>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-default">Submit</button>
            </div>
            </form>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered table-hover" id="hotel">
            <thead>
              <tr>
                <th scope="col">Testimonial</th>
                <th scope="col">Status</th>
                <th scope="col">Created Date</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($testimonials))
              @foreach($testimonials as $testimonial)
              <tr>
                <td>{{ $testimonial->testimonials_content }}</td>
                <td>
                  <?php
                  if($testimonial->status == 1){ 
                  ?>
                  <span class="label label-success">Approved</span>
                  <?php }else{
                    ?>
                    <span class="label label-primary">Pending</span>
                    <?php 
                  } ?>
                </td>
                <td>{{ date('j , F Y', strtotime($testimonial->created_at)) }}</td>
                <td>
                  <a href="javascript:void(0);" onclick="if(confirm('Are you sure want to delete?') == true){document.getElementById('delete-form-{{ $testimonial->id }}').submit();}else{}" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></a>
                  <form id="delete-form-{{ $testimonial->id }}" method="post" action="{{ route('customer.testimonial.del', ['id' => $testimonial->id]) }}" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                  </form>
                </td>
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="5" class="text-center">Data Not Available.</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>
@endsection