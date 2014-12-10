@extends('coanda::admin.layout.main')

@section('page_title', 'Add new menu item')

@section('content')

<div class="row">
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="{{ Coanda::adminUrl('menus') }}">Menus</a></li>
			<li><a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu->id) }}">{{ $menu->name }}</a></li>
			<li>Add new page menu item</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-name col-md-12">
		<h1 class="pull-left">Add new page menu item</h1>
	</div>
</div>

<div class="row">
	<div class="page-options col-md-12"></div>
</div>

<div class="row">
	<div class="col-md-12">

		<div class="edit-container">

			@if (Session::has('error'))
				<div class="alert alert-danger">
					Error
				</div>
			@endif

			{{ Form::open(['url' => Coanda::adminUrl('menus/add/' . $menu->id), 'files' => true]) }}

				





				{{ Form::button('Add', ['name' => 'save', 'value' => 'true', 'type' => 'submit', 'class' => 'btn btn-primary']) }}
				<a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu->id) }}" class="btn btn-default">Cancel</a>

			{{ Form::close() }}

		</div>

	</div>
</div>

@stop