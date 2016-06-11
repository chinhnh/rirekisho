@extends('xCV.template')
<title>Chỉnh sửa trạng thái người dùng</title>

@section('content')
  
    <form action="{{ asset('update') }}/{{ $post->id }}" method="post" class="form-inline" id="profile-forms" enctype="multipart/form-data">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <table class="table table-striped table-bordered">
       <thead>
       <th>ID</th>
       <th>Name</th>
        <th>Email</th>
       <th>Status</th>
       <th></th>
       </thead>
       <tbody>
       <td>{{ $post->id }}</td>
       <td>{{ $post->name }}</td>
       <td>{{ $post->email }}</td>
       <td>
       
             <select name="status" class="form-control">
      
       <?php if(($post->status)==0) { ?>
             <option value="0"> Active </option>
             <option value="1"> NotActive </option>
            <?php
            }
           else {
           ?>
     <option value="1"> NotActive </option>
     <option value="0"> Active </option>
             
     <?php }?>
      
       </select>
       </td>
       <td><input type="submit" class="btn btn-primary" value="ok" /></td>
       </tbody>
       
      
 </table>

    </form>



@stop