@extends('coanda::admin.layout.main')

@section('page_title', 'Add new menu item')

@section('content')

<div class="row">
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="{{ Coanda::adminUrl('menus') }}">Menus</a></li>
			<li><a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu->id) }}">{{ $menu->name }}</a></li>
			<li>Add new menu item</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-name col-md-12">
		<h1 class="pull-left">Add new menu item</h1>
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

				<div class="form-group @if (isset($invalid_fields['name'])) has-error @endif">
					<label class="control-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Input::old('name') }}">

				    @if (isset($invalid_fields['name']))
				    	<span class="help-menu">{{ $invalid_fields['name'] }}</span>
				    @endif
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group @if (isset($invalid_fields['page_id'])) has-error @endif">
							<label class="control-label" for="page_id">Page ID</label>
							<select id="page_id" name="page_id" class="form-control">
								<option value=""></option>
								@foreach (Coanda::pages()->query()->get() as $page)
									<option @if (Input::old('page_id') == $page->id) selected="selected" @endif value="{{ $page->id }}">{{ $page->name }}</option>
								@endforeach
							</select>

						    @if (isset($invalid_fields['page_id']))
						    	<span class="help-menu">{{ $invalid_fields['page_id'] }}</span>
						    @endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group @if (isset($invalid_fields['link'])) has-error @endif">
							<label class="control-label" for="link">Custom Link</label>
		                    <input type="text" class="form-control" id="link" name="link" value="{{ Input::old('link') }}">

						    @if (isset($invalid_fields['link']))
						    	<span class="help-menu">{{ $invalid_fields['link'] }}</span>
						    @endif
						</div>
					</div>
				</div>

				{{ Form::button('Add', ['name' => 'save', 'value' => 'true', 'type' => 'submit', 'class' => 'btn btn-primary']) }}
				<a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu->id) }}" class="btn btn-default">Cancel</a>

			{{ Form::close() }}

		</div>

	</div>
</div>

@stop