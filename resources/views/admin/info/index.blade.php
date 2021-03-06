@extends('layouts.dash')

@section('css')

  <link rel="stylesheet" href="{{ asset('/public/assets/plugins/datatables/dataTables.bootstrap4.css') }}">

@endsection

@section('content')

<div class="card col-md-10">
	<div class="card-header">
	  <h3 class="card-title">Added News</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
	  <table id="example2" class="table table-sm">
	    <thead>
	    <tr>
	      <th>#</th>
	      <th>Title</th>
	      <th>Description</th>
	      <th>By</th>
	      <th>Action</th>

	    </tr>
	    </thead>
	    <tbody>
	    	@php $count = 1; @endphp
	    	@foreach($news as $n)
		    <tr>
		      <td>{{ $count++ }}</td>
		      <td>{{ $n->title }}</td>
		      <td>{!! str_limit($n->description, 50) !!}</td>
		      <td>{{ $n->user->name }}</td>
		      <td class="text-center">
		      	<a href="{{ route('info.edit', $n->id) }}" title="Edit" class="text-info"><i class="fas fa-edit mr-2"></i></a>
		      	<a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" title="Delete" class="text-danger"><i class="fas fa-trash-alt"></i></a>
			      	<form action="{{ route('info.destroy', $n->id) }}" method="post" hidden>
		                @method('DELETE')
		                @csrf
		            </form>
		      </td>
		    </tr>
		    @endforeach
		    @if(!count($news))
	    		<tr>
	    			<td colspan="6" class="text-center text-info"><i class="fas fa-info mr-2"></i>There is no any News added</td>
	    		</tr>
	    	@endif
		</tbody>
	  </table>
	</div>
</div>


@endsection

@section('script')

<!-- DataTables -->
<script src="{{ asset('/public/assets/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/public/assets/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false
    });
  });
</script>

@endsection
