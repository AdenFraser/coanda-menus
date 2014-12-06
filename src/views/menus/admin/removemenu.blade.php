@extends('coanda::admin.layout.main')

@section('page_title', 'Remove menu')

@section('content')

<div class="row">
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="{{ Coanda::adminUrl('menus') }}">Menus</a></li>
			<li>Remove menu</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-name col-md-12">
		<h1 class="pull-left">Remove menu</h1>
	</div>
</div>

<div class="row">
	<div class="page-options col-md-12"></div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="page-tabs">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#urls" data-toggle="tab">Menus</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="urls">

					<div class="alert alert-danger">
						Are you sure you want to remove this menu?
					</div>

					<p>Note: This will also remove <span class="badge badge-default">{{ $menu->items->count() }}</span> menu items in this menu.</p>

					<div class="buttons">
						{{ Form::open(['url' => Coanda::adminUrl('menus/remove-menu/' . $menu->id)]) }}
							{{ Form::button('Remove', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
							<a href="{{ Coanda::adminUrl('menus') }}" class="btn btn-default">Cancel</a>
						{{ Form::close() }}
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

@stop
