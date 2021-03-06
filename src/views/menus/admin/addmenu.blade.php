@extends('coanda::admin.layout.main')

@section('page_title', 'Add new menu')

@section('content')

<div class="row">
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="{{ Coanda::adminUrl('menus') }}">Menus</a></li>
			<li>Add new menu</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-name col-md-12">
		<h1 class="pull-left">Add new menu</h1>
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

			{{ Form::open(['url' => Coanda::adminUrl('menus/add-menu')]) }}

				<div class="form-group @if (isset($invalid_fields['name'])) has-error @endif">
					<label class="control-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Input::old('name') }}">

				    @if (isset($invalid_fields['name']))
				    	<span class="help-menu">{{ $invalid_fields['name'] }}</span>
				    @endif
				</div>

				<div class="form-group @if (isset($invalid_fields['identifier'])) has-error @endif">
					<label class="control-label" for="identifier">Identifier</label>
                    <input type="text" class="form-control" id="identifier" name="identifier" value="{{ Input::old('identifier') }}">

				    @if (isset($invalid_fields['identifier']))
				    	<span class="help-menu">{{ $invalid_fields['identifier'] }}</span>
				    @endif
				</div>

				{{ Form::button('Add', ['add' => 'save', 'value' => 'true', 'type' => 'submit', 'class' => 'btn btn-primary']) }}
				<a href="{{ Coanda::adminUrl('menus') }}" class="btn btn-default">Cancel</a>

			{{ Form::close() }}

		</div>

	</div>
</div>

@stop
