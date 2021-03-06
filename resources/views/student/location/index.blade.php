@extends('layouts.dash')

@section('css')

  <link rel="stylesheet" href="{{ asset('/public/assets/plugins/datatables/dataTables.bootstrap4.css') }}">

@endsection

@section('content')

<div class="card col-md-10">
	<div class="card-header">
	  <h3 class="card-title">Availabe Vacancies</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
	  <table id="example2" class="table table-sm">
	    <thead>
	    <tr>
	      <th>#</th>
	      <th>Industry Name</th>
	      <th>Region</th>
	      <th>District</th>
	      <th>Status</th>
	      <th>Action</th>

	    </tr>
	    </thead>
	    <tbody>
	    	@if(!count($placements))
	    		<tr>
	    			<td colspan="6" class="text-center text-info"><i class="fas fa-info mr-2"></i>There is no industry vacancy availabe for you</td>
	    		</tr>
	    	@endif
	    	@php $count = 1; @endphp
	    	@foreach($placements as $placement)
		    <tr>
		      <td>{{ $count++ }}</td>
		      <td>{{ $placement->name }}</td>
		      <td>{{ $placement->region }}</td>
		      <td>{{ $placement->district }}</td>
		      <td>
		      	@if($placement->remain)
		      		<span class="badge badge-pill badge-primary">Available</span>
		      	@else
		      		<span class="badge badge-pill badge-danger">Unavailable</span>
		      	@endif
		      </td>
		      <td>
			      	<button class="btn btn-sm btn-primary @if(!$placement->remain) disabled @endif" data-toggle="modal" data-target="#exampleModalCenter"><i class="pr-2 fas fa-check"></i>Request</button>

		      	<form action="{{ route('request.placement', $placement->id) }}" method="post">
			      		@csrf
			      	<!-- Modal -->
					<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalCenterTitle"><i class="text-info pr-1 fas fa-info-circle"></i>Important</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <p class="text-info">By Requesting Industrial placement this means that you want to attend your IPT at that place, and if you decided to change location please remove your request so that other can get placement...</p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					        <button type="submit" class="btn btn-primary">Confirm</button>
					      </div>
					    </div>
					  </div>
					</div>
		      	</form>
		      </td>
		    </tr>
		    @endforeach
		    <tr>
		    	@if(!isset($placements))
		    		<p class="text-center">There is no industrial vaccancy available for your department</p>
		    	@endif
		    </tr>
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
