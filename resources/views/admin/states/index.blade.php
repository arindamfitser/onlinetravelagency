@extends('admin.layouts.master')

@section('th_head')

@endsection

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title ">State Management
                    <div class="float-right">
                        <select id="sitelang" name="sitelang" class="browser-default btn-round custom-select">
                            <?php @langOption(); ?>
                        </select>
                        <a href="{{ route('admin.states.add') }}" class="btn-sm btn-success btn-round "> 
                            <i class="material-icons">create</i> New</a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                       @include('admin.layouts.messages')
                       <table class="table" id="order-listing">
                        <thead class=" text-primary"> 
                            <th>Name</th>
                            <th>Country ID</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php $lang = @\Session::get('language');?>
                            <?php foreach($states as $k=>$state) {
                              //echo $state->status;
                            ?>
                            <tr>
                                <td><?php echo $state->states_name ?></td>
                                <td><?php echo $state->countries_id ?></td>
                                
                                <td class="text-primary">
                                     <a href="<?php echo route('admin.states.edit', ['lang' => $state->locale, 'id' => $state->id]); ?> " title="Edit">
                                        <i class="fa fa-edit"></i>
                                     </a>
                                 <?if($state->status==1) {?>
                                     <a href="<?php echo route('admin.states.edit', ['lang' => $state->locale, 'id' => $state->id]); ?>" style="color:#4caf50" title="Published">
                                         <i  class="fa fa-toggle-on" aria-hidden="true"></i>
                                     </a>
                                 <?php }else{ ?>
                                     <a href="<?php echo route('admin.states.edit', ['lang' => $state->locale, 'id' => $state->id]); ?>" style="color:red" title="Draft">
                                         <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                     </a>
                                 <?php } ?>
                                
                        </td>
                                
                           </tr>
                            
                    <?php } ?>
                </tbody>
                <tbody>
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