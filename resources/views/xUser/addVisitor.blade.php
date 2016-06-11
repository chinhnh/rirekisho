@extends('xCV.template')
<title>Thêm m?i vistitor</title>

@section('content')
   <form action="{{ asset('store') }}" method="post" class="form-inline" id="profile-forms" enctype="multipart/form-data">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <table class="table table-striped table-bordered">
  <thead>
  <th>Name</th>
  <th>Email</th>
  <th>Password</th>
  <th>Role</th>
  <th></th>
  </thead>
  <tbody>
  <td><input type="text" name="name" class="form-control" /></td>
  <td><input type="email" name="email" class="form-control" /></td>
  <td><input type="text" name="password" class="form-control" /></td>
  <td> 
  <select class="form-control" name="role">
       <option value="0">Applicant</option>
       <option value="1">Visitor</option>
       <option value="2">Admin</option></select>
       </td>
   
       
     <td><input type="submit" class="btn btn-primary" value="Add" /></td> 
    </form>
</tbody>
  </table>


@stop