@extends('coanda::admin.layout.main')

@section('page_title', 'Menu items')

@section('content')

<div class="row">
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="{{ Coanda::adminUrl('menus') }}">Menus</a></li>
			<li>{{ $menu->name }}</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-name col-md-12">
		<h1 class="pull-left">Menu items in {{ $menu->name }}</h1>
		<div class="page-status pull-right">
			<span class="label label-default">Total {{ $menus->getTotal() }}</span>
		</div>
	</div>
</div>

<div class="row">
	<div class="page-options col-md-12">
		<a href="{{ Coanda::adminUrl('menus/add/' . $menu->id) }}" class="btn btn-primary">Add new menu item</a>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="page-tabs">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#urls" data-toggle="tab">Items</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="urls">

					@if (Session::has('added'))
						<div class="alert alert-success">
							New menu item added
						</div>
					@endif

					@if (Session::has('updated'))
						<div class="alert alert-success">
							Menu updated
						</div>
					@endif

					@if (Session::has('orders_updated'))
						<div class="alert alert-success">
							Menu order updated
						</div>
					@endif

					@if (Session::has('removed'))
						<div class="alert alert-danger">
							Menu item removed
						</div>
					@endif

					@if (Session::has('menus_removed'))
						<div class="alert alert-danger">
							Menu items removed
						</div>
					@endif

					{{ Form::open(['url' => Coanda::adminUrl('menus/view-menu/' . $menu->id) ]) }}

						@if ($menus->count() > 0)
							<table class="table table-striped">
								<thead>
									<tr>
										<th class="tight"></th>
										<th>Name</th>
										<th class="tight"></th>
										<th class="tight"></th>
										<th class="tight"></th>
									</tr>
								</thead>
								@foreach ($menus as $menu)
									<tr>
										<td><input type="checkbox" name="remove_menu_ids[]" value="{{ $menu->id }}"></td>
										<td><a href="{{ Coanda::adminUrl('menus/view/' . $menu->id) }}">{{ $menu->name }}</a></td>
										<td>{{ Form::text('ordering[' . $menu->id . ']', $menu->order, ['class' => 'form-control input-sm', 'style' => 'width: 50px;']) }}</td>
										<td><a href="{{ Coanda::adminUrl('menus/edit/' . $menu->id) }}"><i class="fa fa-pencil-square-o"></i></a></td>
										<td><a href="{{ Coanda::adminUrl('menus/remove/' . $menu->id) }}"><i class="fa fa-minus-circle"></i></a></td>
									</tr>
								@endforeach
							</table>

							{{ $menus->links() }}
						@else
							<p>No menu items have been added to this menu yet.</p>
						@endif

						<div class="buttons">
							{{ Form::button('Remove selected', ['name' => 'remove_selected', 'value' => 'true', 'type' => 'submit', 'class' => 'btn btn-default']) }}
							{{ Form::button('Update orders', ['name' => 'update_order', 'value' => 'true', 'type' => 'submit', 'class' => 'btn btn-default pull-right']) }}
						</div>

					{{ Form::close() }}

				</div>
			</div>
		</div>
	</div>
</div>

@section('custom-js')
	<script src="{{ asset('packages/adenfraser/coanda-menus/js/jquery.sortable.js') }}"></script>
	<script src="{{ asset('packages/adenfraser/coanda-menus/js/coanda-menus-scripts.js') }}"></script>
@append

@stop

