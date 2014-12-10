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
		<div class="btn-group">
			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				Add new menu item <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#">Page Link</a></li>
				<li><a href="#">Custom Link</a></li>
			</ul>
		</div>
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

						<div class="menu-order-container">

							<ol class='nested_with_switch sortable-menu vertical'>

								{{ $ordered_items->htmlList() }}
								{{--@foreach ($ordered_items as $menu)
									<li data-id="{{ $menu->id }}">
										<div class="menu-item">
											<i class="fa fa-arrows"></i>
											<input type="checkbox" name="remove_menu_ids[]" value="{{ $menu->id }}">
											<a href="{{ Coanda::adminUrl('menus/view/' . $menu->id) }}">{{ $menu->name }}</a>

											Order : {{ $menu->order }} /
											Parent_id : {{ $menu->parent_id }}

											<span class="pull-right">
												<a href="{{ Coanda::adminUrl('menus/edit/' . $menu->id) }}"><i class="fa fa-pencil-square-o"></i></a>
												<a href="{{ Coanda::adminUrl('menus/remove/' . $menu->id) }}"><i class="fa fa-minus-circle"></i></a>
											</span>
										</div>
										<ol>
											@if (count($menu->children) > 0)
												has children
											@endif
										</ol>
									</li>
								@endforeach--}}
							</ol>
						</div>
					
							{{ Form::hidden('overall_menu_order', '', ['class' => 'overall_menu_order'])}}
						@else
							<p>No menu items have been added to this menu yet.</p>
						@endif
	

						<div class="buttons">
							{{ Form::button('Remove selected', ['name' => 'remove_selected', 'value' => 'true', 'type' => 'submit', 'class' => 'btn btn-default']) }}
							{{ Form::button('Save menu order', ['name' => 'update_order', 'value' => 'true', 'type' => 'submit', 'class' => 'btn btn-default pull-right']) }}
						</div>

					{{ Form::close() }}


				</div>
			</div>
		</div>
	</div>
</div>

@section('custom-js')
	<script src="{{ asset('packages/adenfraser/coanda-menus/js/jquery.sortable.min.js') }}"></script>
	<script src="{{ asset('packages/adenfraser/coanda-menus/js/coanda-menus-scripts.js') }}"></script>

	<style>
body.dragging, body.dragging *
{
	cursor: move !important;
}
.dragged {
	opacity: 0.5;
	position: absolute;
	top: 0;
	z-index: 2000;
}
.menu-order-container {
	border: 1px solid #ccc;
	background: #eee;
	border-radius: 5px;
	padding: 10px;
	margin-bottom: 10px;
}
ol.vertical {
    margin: 0 0 9px;
    padding: 0;
    min-height: 10px;
}
ol.vertical li {
    background: none;
    border: 0;
    color: #0088cc;
    display: block;
    margin: 5px;
    padding:0;
}
ol.vertical li .menu-item {
	background: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    line-height: 23px;
    margin-left: 20px;
    padding: 5px 10px 5px 0;
}
ol.vertical li .menu-item .fa.fa-arrows {
    left: -25px;
    position: relative;
    opacity: 0;
}
ol.vertical li:hover > .menu-item > .fa.fa-arrows {
	opacity: 1;
}
ol.vertical li .menu-item a {
	padding-left: 5px;
}
ol.vertical li.placeholder {
    border: medium none;
    margin: 0;
    padding: 0;
    position: relative;
}
ol.vertical li.placeholder:before {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: transparent -moz-use-text-color transparent red;
    border-image: none;
    border-style: solid none solid solid;
    border-width: 5px medium 5px 5px;
    content: "";
    height: 0;
    left: -5px;
    margin-top: -5px;
    position: absolute;
    top: -4px;
    width: 0;
}
ol {
    list-style-type: none;
}
ol i.icon-move {
    cursor: pointer;
}
ol li.highlight {
    background: none repeat scroll 0 0 #333333;
    color: #999999;
}
ol li.highlight i.icon-move {
    background-image: url("../img/glyphicons-halflings-white.png");
}
ol.nested_with_switch, ol.nested_with_switch ol {
	margin-top: 5px;
    border: 0;
}
ol.nested_with_switch.active, ol.nested_with_switch ol.active {
	margin-top: 5px;
    border: 0;
}
ol.nested_with_switch li, ol.simple_with_animation li, ol.serialization li, ol.default li {
    cursor: pointer;
}
ol.nested_with_switch li ol li, ol.simple_with_animation li ol li, ol.serialization li ol li, ol.default li ol li {
	margin-right: 0;
}
ol.simple_with_animation {
    border: 1px solid #999999;
}
.switch-container {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 80px;
}
.navbar-sort-container {
    height: 200px;
}
ol.nav li, ol.nav li a {
    cursor: pointer;
}
ol.nav .divider-vertical {
    cursor: default;
}
ol.nav li.dragged {
    background-color: #2c2c2c;
}
ol.nav li.placeholder {
    position: relative;
}
ol.nav li.placeholder:before {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: red transparent -moz-use-text-color;
    border-image: none;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-style: solid solid none;
    border-width: 5px 5px medium;
    content: "";
    height: 0;
    margin-left: -5px;
    position: absolute;
    top: -6px;
    width: 0;
}
ol.nav ol.dropdown-menu li.placeholder:before {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: transparent -moz-use-text-color transparent red;
    border-image: none;
    border-style: solid none solid solid;
    border-width: 5px medium 5px 5px;
    left: 10px;
    margin-top: -5px;
    top: 0;
}
	</style>
@append

@stop

