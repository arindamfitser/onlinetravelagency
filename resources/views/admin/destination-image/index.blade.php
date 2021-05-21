@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">Destination Image
                    <div class="float-right">
                        <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                            <?php @langOption(); ?>
                        </select>
                    </div>
                </div>
                <div class="card-body table-responsive">
                 @include('admin.layouts.messages')
                     <table class="table" id="order-listing">
                    <thead class=" text-primary">
                        <th>Image</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $lang = @\Session::get('language');?>
                        <tr>
                            <td>
                                <img src="{{ url('/public').Storage::disk('local')->url('uploads/destination-image/'.$image->image) }}" style="height: 200px;">
                            </td>
                            <td class="text-primary">
                                <a href="{{ route('admin.destination.image.edit', [ 'id' => $image->id]) }}" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
             </div>
         </div>
     </div>
 </div>
@endsection
@section('th_foot')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endsection