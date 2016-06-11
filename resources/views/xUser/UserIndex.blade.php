@extends('xCV.template')
<title>Danh sách người dùng</title>
@section('content')
<div id="list_table" data-table="table-user">
  <div class="table_action">
    <div class="top_action"> </div>
    <div class="bottom_action">
      <ul class="tabs">
        <li class="tab">
          Sắp xếp danh sách:
        </li>
        <li class="tab select" data-field="name"  data-sort="asc" data-keyword="" >
          <a>Tên </a>
        </li>
        <li class="tab select"  data-field="email" data-sort="asc" data-keyword="">
          <a>Email </a>
        </li>
        <li class="" data-field="updated_at" data-sort="asc" data-keyword="">
          <a>Ngày cập nhật</a>
        </li>
        <li class="" data-field="role" data-sort="asc" data-keyword="">
          <a>Role</a>
        </li>
      </ul>
     <ul ><li><a href="{{ asset('create') }}"> ||   Add User</a></li></ul>


      <div class="search">
        <div class="search-forms" >
          <label class="search_icon" for="text">
            <i class="fa fa-search"></i>  
          </label>
          <input id="table-search" class="list_search " placeholder="Search " type="text">
        </div>
      </div>
    </div>
    <div class="clear-fix"></div>
  </div>
  <div >
    <table id="the_list">
      <thead>
        <tr>
          <th></th>
          <th data-field="">#</th>
          <th data-field="name" style="width: 20%;"><a>Name</a></th>
          <th data-field="email" style="width: 25%;"><a>Email</a></th>
          <th style="width: 10%;">Type</th>
          <th style="width: 10%;">&nbsp</th>
          <th style="width: 10%;">Status</th>
        </tr>
      </thead>
      <tbody id="list-table-body" data-reload="true">
        @if(!$count)
        <tr class= "no-record">
          <td colspan="5"><center>There are no records to display</center></td>
        </tr>
        @else
        @foreach ($users as $row)
        <tr class="data">
          <td class="image"><a href=""><img
            src="http://i.forbesimg.com/media/lists/people/bill-gates_100x100.jpg"
            alt=""></a>
          </td>
          <td class="rank">{{ $row->id }}</td>
          <td class="name"><a href="{{url('User',$row->id)}} ">{{ $row->name }} </a> </td>
          <td class="name">{{ $row->email }}  </td>
          <td> {{ $row->getRole() }}</td>
          <td><a href="{{url('User',[$row->id,'edit'])}}">Sửa</a></td>
          <td>
           <?php
           if(($row->status)==0) 
            echo "Active";
           else 
            echo "NotActive";
           ?>

         
            <br/><a href="{{ asset('edit/')}}/{{ $row->id }}">Đổi</a>

          </td>
        </tr>
        @endforeach
        <tr id="number-result" style="display: none;">
          <td colspan="5">Có {{$count }} kết quả  </td>
        </tr>
        @endif
      </tbody>
    </table>
    <?php echo $users->render(); ?>
  </div>


</div>

@stop

