@extends('frontend.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
@endsection
@section('content')
<!--Banner sec-->
<section class="profile dashboard hometop_gap">
  @include('frontend.layouts.hotelier_sidenav')
  <div class="dashboard_content">
    <h1>Room Rate</h1>
    @include('frontend.layouts.messages')
    <span id="message"></span>
    <div class="row">
      <div class="col-sm-12">
       <table class="table table-bordered" id="price_table">
        <thead>
          <tr>
            <th>From</th>
            <th>To</th>
            <th>Base Rate</th>
            <th>Extra Bed</th>
            <th>Charge per person</th>
            <th>Charge per Child</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="rack_rate_list">
          @foreach($price as $p)
          <tr>
            <td>{{ $p->eff_start_date }}</td>
            <td>{{ $p->eff_end_date }}</td>
            <td>{{ $p->base_price }}</td>
            <td>{{ $p->extra_bed }}</td>
            <td>{{ $p->per_person }}</td>
            <td>{{ $p->per_child }}</td>
            <td class="numeric"><a class="btn btn-info btn-sm tip" title="Edit" href="javascript:;" onclick="editRackRate({{ $p->id }}, '{{ route('user.hotels.rooms.price_edit', ['id' => $p->id]) }}');"> <i class="fa fa-pencil"></i> </a> &nbsp;
               <form id="delete-form-{{ $p->id }}" method="post" action="{{ route('user.hotels.rooms.delprice', $p->id) }}" style="display: none;">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                    </form>
              <a class="btn btn-danger btn-sm tip" title="Delete" href="javascript:;" onclick="if(confirm('Are you sure, You want to delete this?')){event.preventDefault();document.getElementById('delete-form-{{ $p->id }}').submit();}else{event.preventDefault();}"> <i class="fa fa-trash"></i> </a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <form action="{{ route('user.hotels.rooms.addprice', ['id' => $id]) }}" method="POST" id="frm_rack_rate">
    {{ csrf_field() }}
    <input type="hidden" name="price_id" id="price_id">
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
          <label>Basic Rate <span class="required">*</span></label>
          <input type="text" name="base_price" onkeyup="apply_base_rate(this.value);" id="base_price" class="form-control" placeholder="Basic Rate" required />
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Extra Bed <span class="required">*</span></label>
          <input type="text" name="extra_bed" id="extra_bed" class="form-control" placeholder="Extra Bed" onkeyup="apply_extra_bed(this.value);" required />
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Plan Charge per person <span class="required">*</span></label>
          <input type="text" name="food_rate" id="food_rate" onkeyup="apply_food_rate(this.value);" class="form-control" placeholder="Plan Charge per person" required />
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Plan Charge per Child <span class="required">*</span></label>
          <input type="text" name="child_rate" id="child_rate" onkeyup="apply_child_rate(this.value);" class="form-control" placeholder="Plan Charge per Child" required />
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Effective Start Date  <span class="required">*</span></label>
          <input type="text" name="eff_start_date" id="eff_start_date" class="form-control datepicker" placeholder="Effective Start Date" required />
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Effective End Date   <span class="required">*</span></label>
          <input type="text" name="eff_end_date" id="eff_end_date" class="form-control datepicker" placeholder="Effective End Date" required />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
       <table class="table table-bordered">
        <thead>
          <tr>
            <th>Days</th>
            <th>Add/Subtract</th>
            <th>Rate(%)</th>
            <th>Price</th>
            <th>Extra Bed</th>
            <th>Plan Charge per Person</th>
            <th>Plan Charge per Child</th>
          </tr>
        </thead>
        <tbody id="row_list"></tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </div>
  </div>
</form>
</div>
</div>
</section>
<div class="clearfix"></div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#price_table').DataTable();
} );
</script>
<script type="text/javascript">
  $('.datepicker').datepicker({
    startDate:new Date()
  });
  $(document).on('ready', function(){
    var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    var row = '';
    for (var i = 0; i < days.length; i++) {
      row += '<tr><td>'+days[i]+'</td><td><select class="form-control method" name="'+days[i].toLowerCase()+'_method" id="'+days[i].toLowerCase()+'_method" data-day="'+days[i].toLowerCase()+'" ><option value="">---</option><option value="A">Add</option><option value="S">Subtract</option></select></td><td><input type="text" name="'+days[i].toLowerCase()+'_per" id="'+days[i].toLowerCase()+'_per" class="form-control per" data-day="'+days[i].toLowerCase()+'"></td><td><input type="text" name="'+days[i].toLowerCase()+'_price" id="'+days[i].toLowerCase()+'_price" class="price-class form-control" data-day="'+days[i].toLowerCase()+'"></td><td><input type="text" name="'+days[i].toLowerCase()+'_ex_price" id="'+days[i].toLowerCase()+'_ex_price" class="extra_bed-class form-control" data-day="'+days[i].toLowerCase()+'"></td><td><input type="text" name="'+days[i].toLowerCase()+'_food_rate" id="'+days[i].toLowerCase()+'_food_rate" class="food_rate-class form-control" data-day="'+days[i].toLowerCase()+'"></td><td><input type="text" name="'+days[i].toLowerCase()+'_child_rate" id="'+days[i].toLowerCase()+'_child_rate" class="child_rate-class form-control" data-day="'+days[i].toLowerCase()+'"></td></tr>';
      $("#row_list").html(row);
    }

    $('.method').change(function (){
      var day = $(this).data("day");
      calculate_rate(day);
      cal_extra_bed(day);
      call_food_rate(day);
      call_child_rate(day);
    });
    $('.per').keyup(function (){
      var day = $(this).data("day");
      calculate_rate(day);
      cal_extra_bed(day);
      call_food_rate(day);
      call_child_rate(day);
    });

  });
  function apply_base_rate(value){
    $('.price-class').val(value);
    $('.price-class').each(function(index, element) {
      var day = $(this).data("day");
      calculate_rate(day);
    });
  }
  function apply_extra_bed(value){
    $('.extra_bed-class').val(value);
    $('.extra_bed-class').each(function(index, element) {
      var day = $(this).data("day");
      cal_extra_bed(day);
    });
  }
  function apply_food_rate(value){
    $('.food_rate-class').val(value);
    $('.food_rate-class').each(function(index, element) {
      var day = $(this).data("day");
      call_food_rate(day);
    });
  }

  function apply_child_rate(value){
    $('.child_rate-class').val(value);
    $('.child_rate-class').each(function(index, element) {
      var day = $(this).data("day");
      call_child_rate(day);
    });
  }

  function calculate_rate(day){
    var method = $('#' + day + '_method').val();
    var base_price = $('#base_price').val();

    if(base_price != '') {
      if(method != ''){
        var rate_val = $('#' + day + '_per').val();
        if(rate_val != ''){
          if(method == 'A'){
            var modifi_price= ((parseFloat(rate_val)/100)*parseFloat(base_price))+parseFloat(base_price);
            $('#' + day + '_price').val(modifi_price);
          }
          else{
            var modifi_price= parseFloat(base_price)-((parseFloat(rate_val)/100)*parseFloat(base_price));
            $('#' + day + '_price').val(modifi_price);
          }
        }
        else{
          $('#' + day + '_price').val(base_price);
        }
      }
      else{
        $('#' + day + '_price').val(base_price);
      }
    }
  }

  function cal_extra_bed(day){
    var method = $('#' + day + '_method').val();
    var extra_bed = $('#extra_bed').val();

    if(extra_bed != '') {
      if(method != ''){
        var rate_val = $('#' + day + '_per').val();
        if(rate_val != ''){
          if(method == 'A'){
            var modifi_price = ((parseFloat(rate_val)/100)*parseFloat(extra_bed))+parseFloat(extra_bed);
            $('#' + day + '_ex_price').val(modifi_price);
          }
          else{
            var modifi_price = parseFloat(extra_bed)-((parseFloat(rate_val)/100)*parseFloat(extra_bed));
            $('#' + day + '_ex_price').val(modifi_price);
          }
        }
        else{
          $('#' + day + '_ex_price').val(extra_bed);
        }
      }
      else{
        $('#' + day + '_ex_price').val(extra_bed);
      }
    }
  }
  function call_food_rate(day){
    var method = $('#' + day + '_method').val();
    var food_rate = $('#food_rate').val();

    if(food_rate != '') {
      if(method != ''){
        var rate_val = $('#' + day + '_per').val();
        if(rate_val != ''){
          if(method == 'A'){
            var modifi_price = ((parseFloat(rate_val)/100)*parseFloat(food_rate))+parseFloat(food_rate);
            $('#' + day + '_food_rate').val(modifi_price);
          }
          else{
            var modifi_price = parseFloat(food_rate)-((parseFloat(rate_val)/100)*parseFloat(food_rate));
            $('#' + day + '_food_rate').val(modifi_price);
          }
        }
        else{
          $('#' + day + '_food_rate').val(food_rate);
        }
      }
      else{
        $('#' + day + '_food_rate').val(food_rate);
      }
    }
  }
  function call_child_rate(day){
    var method = $('#' + day + '_method').val();
    var child_rate = $('#child_rate').val();

    if(child_rate != '') {
      if(method != ''){
        var rate_val = $('#' + day + '_per').val();
        if(rate_val != ''){
          if(method == 'A'){
            var modifi_price = ((parseFloat(rate_val)/100)*parseFloat(child_rate))+parseFloat(child_rate);
            $('#' + day + '_child_rate').val(modifi_price);
          }
          else{
            var modifi_price = parseFloat(child_rate)-((parseFloat(rate_val)/100)*parseFloat(child_rate));
            $('#' + day + '_child_rate').val(modifi_price);
          }
        }
        else{
          $('#' + day + '_child_rate').val(child_rate);
        }
      }
      else{
        $('#' + day + '_child_rate').val(child_rate);
      }
    }
  }
   $('form[id="frm_rack_rate"]').validate({
    rules: {
      base_price: {
        required: true,
        number: true
      },
      extra_bed: {
        required: true,
        number: true
      },
      food_rate: {
        required: true,
        number: true
      },
      child_rate: {
        required: true,
        number: true
      },
      eff_start_date: {
        required: true
      },
      eff_end_date: {
        required: true
      }
    },
    submitHandler: function(form){
      genericAjax(form);
    }
  });
  function genericAjax(form){
    $.ajax({
      type     : $(form).attr('method'),
      url      : $(form).attr('action'),
      data     : $(form).serialize(),
      cache    : false,
      success  : function(data) {
        //console.log(data);
        var result = $.parseJSON(data);
        $('#message').html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '+result.message+'</div>');
        setTimeout(function(){
          location.reload();
        }, 1000);
      },
      error    : function(err){
        console.log(err);
      }
    });
  }
  function editRackRate(data_id, url){
      $.ajax({
      type     : 'GET',
      url      :  url,
      cache    : false,
      success  : function(data) {
      var result = JSON.parse(data);
      var price_rack = result.price_rack;
      var price = result.price;
      $('#price_id').val(price[0].id);
      $('#base_price').val(price[0].base_price);
      $('#extra_bed').val(price[0].extra_bed);
      $('#food_rate').val(price[0].per_person);
      $('#child_rate').val(price[0].per_child);
      $('#eff_start_date').val(price[0].eff_start_date);
      $('#eff_end_date').val(price[0].eff_end_date);
       for (key in price_rack) {
         $('#'+price_rack[key].days.toLowerCase()+'_per').val(price_rack[key].rate);
         $('#'+price_rack[key].days.toLowerCase()+'_price').val(price_rack[key].base_price);
         $('#'+price_rack[key].days.toLowerCase()+'_ex_price').val(price_rack[key].extra_bed);
         $('#'+price_rack[key].days.toLowerCase()+'_food_rate').val(price_rack[key].per_person);
         $('#'+price_rack[key].days.toLowerCase()+'_child_rate').val(price_rack[key].per_child);
       }
      },
      error    : function(err){
        console.log(err);
      }
    });
  }

</script>
@endsection