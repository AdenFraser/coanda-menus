@extends('coanda::admin.layout.main')

@section('page_title', 'Menus')

@section('content')

<div class="row">
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="{{ Coanda::adminUrl('menus') }}">Menus</a></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-name col-md-12">
		<h1 class="pull-left">Menus</h1>
		<div class="page-status pull-right">
			<span class="label label-default">Total {{ $menus->getTotal() }}</span>
		</div>
	</div>
</div>

<div class="row">
	<div class="page-options col-md-12">
		<a href="{{ Coanda::adminUrl('menus/add-menu') }}" class="btn btn-primary">Add new menu</a>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="page-tabs">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#urls" data-toggle="tab">Menus</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="urls">

					@if (Session::has('added'))
						<div class="alert alert-success">
							New menu added
						</div>
					@endif

					@if (Session::has('updated'))
						<div class="alert alert-success">
							Menu updated
						</div>
					@endif

					@if (Session::has('removed'))
						<div class="alert alert-danger">
							Menu removed
						</div>
					@endif

					@if ($menus->count() > 0)
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Name</th>
									<th>Identifier</th>
									<th>Menu Items</th>
									<th class="tight"></th>
									<th class="tight"></th>
								</tr>
							</thead>
							@foreach ($menus as $menu)
								<tr>
									<td><a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu->id) }}">{{ $menu->name }}</a></td>
									<td>{{ $menu->identifier }}</td>
									<td>{{ $menu->items->count() }}</td>
									<td><a href="{{ Coanda::adminUrl('menus/edit-menu/' . $menu->id) }}"><i class="fa fa-pencil-square-o"></i></a></td>
									<td><a href="{{ Coanda::adminUrl('menus/remove-menu/' . $menu->id) }}"><i class="fa fa-minus-circle"></i></a></td>
								</tr>
							@endforeach
						</table>

						{{ $menus->links() }}
					@else
						<p>No menu item menus have been added.</p>
					@endif

				</div>
			</div>
		</div>
	</div>
</div>

@stop
