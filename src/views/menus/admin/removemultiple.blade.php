@extends('coanda::admin.layout.main')

@section('page_title', 'Remove menus')

@section('content')

<div class="row">
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="{{ Coanda::adminUrl('menus') }}">Menus</a></li>
			<li><a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu->id) }}">Content menus</a></li>
			<li>Remove menu items</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-name col-md-12">
		<h1 class="pull-left">Remove menu items</h1>
	</div>
</div>

<div class="row">
	<div class="page-options col-md-12"></div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="page-tabs">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#urls" data-toggle="tab">Menu Item</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="urls">

                    {{ Form::open(['url' => Coanda::adminUrl('menus/remove-multiple/' . $menu->id) ]) }}

                        <div class="alert alert-danger">
                            Are you sure you want to remove this set of menu items?
                        </div>

                        <table class="table table-striped">
                            @foreach ($remove_menus as $remove_menu)
                                <tr>
                                    <td>
                                        <input type="hidden" name="remove_menu_ids[]" value="{{ $remove_menu->id }}">
                                        {{ $remove_menu->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <div class="buttons">
                            {{ Form::button('Remove', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                            <a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu->id) }}" class="btn btn-default">Cancel</a>
                        </div>

                    {{ Form::close() }}

				</div>
			</div>
		</div>
	</div>
</div>

@stop
