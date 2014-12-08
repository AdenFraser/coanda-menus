@extends('coanda::admin.layout.main')

@section('page_title', 'Edit menu item')

@section('content')

<div class="row">
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="{{ Coanda::adminUrl('menus') }}">Menus</a></li>
			<li><a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu_item->menu->id) }}">{{ $menu_item->menu->name }}</a></li>
			<li>Edit: {{ $menu_item->name }}</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-name col-md-12">
		<h1 class="pull-left">Edit: {{ $menu_item->name }}</h1>
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

			{{ Form::open(['url' => Coanda::adminUrl('menus/edit/' . $menu_item->id), 'files' => true]) }}

				<div class="form-group @if (isset($invalid_fields['name'])) has-error @endif">
					<label class="control-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Input::old('name', $menu_item->name) }}">

				    @if (isset($invalid_fields['name']))
				    	<span class="help-menu">{{ $invalid_fields['name'] }}</span>
				    @endif
				</div>	

				<div class="row">
					<div class="col-md-6">
						<div class="form-group @if (isset($invalid_fields['page_id'])) has-error @endif">
							<label class="control-label" for="page_id">Page</label>
							<select id="page_id" name="page_id" class="form-control">
								<option value=""></option>
								@foreach (Coanda::pages()->query()->get() as $page)
									<option @if (Input::old('page_id', $menu_item->page_id) == $page->id) selected="selected" @endif value="{{ $page->id }}">{{ $page->name }}</option>
									@foreach (Coanda::pages()->query()->in($page->id)->get() as $sub_page)
										<option @if (Input::old('page_id') == $sub_page->id) selected="selected" @endif value="{{ $sub_page->id }}">&nbsp;&nbsp;{{ $sub_page->name }}</option>
									@endforeach
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
		                    <input type="text" class="form-control" id="link" name="link" value="{{ Input::old('link', $menu_item->link) }}">

						    @if (isset($invalid_fields['link']))
						    	<span class="help-menu">{{ $invalid_fields['link'] }}</span>
						    @endif
						</div>
					</div>
				</div>

				{{ Form::button('Update', ['name' => 'save', 'value' => 'true', 'type' => 'submit', 'class' => 'btn btn-primary']) }}
				<a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu_item->menu->id) }}" class="btn btn-default">Cancel</a>

			{{ Form::close() }}

		</div>

	</div>
</div>

@stop
