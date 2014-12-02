@extends('coanda::admin.layout.main')

@section('page_title', 'Remove menu item')

@section('content')

<div class="row">
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="{{ Coanda::adminUrl('menus') }}">Menus</a></li>
			<li><a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu_item->menu->id) }}">{{ $menu_item->menu->name }}</a></li>
			<li>Remove menu item</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="page-name col-md-12">
		<h1 class="pull-left">Remove menu item</h1>
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

                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <td>{{ $menu_item->name }}</td>
                        </tr>

                        @if ($menu_item->link)

	                        <tr>
	                            <th>Custom Link</th>
	                            <td>
	                            	<div class="form-group">
										<div class="input-group">
											<input type="text" class="form-control select-all" id="preview" name="preview" value="{{ $menu_item->link }}" readonly>
											<span class="input-group-addon"><a class="new-window" href="{{ $menu_item->link }}"><i class="fa fa-share-square-o"></i></a></span>
										</div>
									</div>
								</td>
	                        </tr>

                        @else

                        	@set('page', Coanda::pages()->getPage($menu_item->page_id))
	                        <tr>
	                            <th>Page</th>
	                            <td>
									<div class="form-group">
										<label class="control-label" for="preview">{{ $page->name }}</label>
										<div class="input-group">
											<input type="text" class="form-control select-all" id="preview" name="preview" value="{{ url($page->slug) }}" readonly>
											<span class="input-group-addon"><a class="new-window" href="{{ url($page->slug) }}"><i class="fa fa-share-square-o"></i></a></span>
										</div>
									</div>
								</td>
	                        </tr>

                        @endif

                    </table>
                    
					<div class="alert alert-danger">
						Are you sure you want to remove this menu item?
					</div>

					<div class="buttons">
						{{ Form::open(['url' => Coanda::adminUrl('menus/remove/' . $menu_item->id)]) }}
							{{ Form::button('Remove', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
							<a href="{{ Coanda::adminUrl('menus/view-menu/' . $menu_item->menu->id) }}" class="btn btn-default">Cancel</a>
						{{ Form::close() }}
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

@stop
