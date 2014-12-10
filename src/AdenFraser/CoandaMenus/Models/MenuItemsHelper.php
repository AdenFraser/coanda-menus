<?php namespace AdenFraser\CoandaMenus\Models;

use Coanda;

class MenuItemsHelper {

	private $items;

	public function __construct($items)
	{
	  	$this->items = $items;
	}

	/**
	 * @return string Returns the HTML string of our Sortable Menu
	 */
	public function htmlList() {
	 	return $this->htmlFromArray($this->itemArray());
	}

	/**
	 * @return array
	 */
	public function itemArray()
	{
		$result = [];
		foreach($this->items as $item) {
			if ($item->parent_id == 0) {
				$result[$item->id] = $item;
				$result[$item->id]['children'] = $this->itemWithChildren($item);
			}
		}
		return $result;
	}

	/**
	 * @param  object $item
	 * @return array
	 */
	private function childrenOf($item)
	{
	  $result = array();
		foreach($this->items as $i) {
			if ($i->parent_id == $item->id) {
				$result[] = $i;
			}
		}
	  return $result;
	}

	/**
	 * @param  object $item
	 * @return array
	 */
	private function itemWithChildren($item)
	{
		$result = array();
		$children = $this->childrenOf($item);
		foreach ($children as $child) {
			$result[$child->id] = $child;
			$result[$child->id]['children'] = $this->itemWithChildren($child);
		}
		return $result;
	}

	/**
	 * Returns the HTML of our Sortable Menus
	 * @param  array $array
	 * @return string
	 */
	private function htmlFromArray($array)
	{
		$html = '';

		foreach($array as $v) {

			$html .= '<li data-id="'.$v->id.'">
				<div class="menu-item">
					<i class="fa fa-arrows"></i>
					<input type="checkbox" name="remove_menu_ids[]" value="'.$v->id.'">
					<a href="'.Coanda::adminUrl('menus/view/' . $v->id).'" data-toggle="modal" data-target=".modal-view-custom" data-remote="false">'.$v->name.'</a>
					<span class="pull-right">
						<a href="'.Coanda::adminUrl('menus/edit/' . $v->id).'" data-toggle="modal" data-target=".modal-edit-custom" data-remote="false"><i class="fa fa-pencil-square-o"></i></a>
						<a href="'.Coanda::adminUrl('menus/remove/' . $v->id).'" data-toggle="modal" data-target=".modal-remove" data-remote="false"><i class="fa fa-minus-circle"></i></a>
					</span>
				</div>
				<ol>';

			if(count($v->children) > 0) {

				$html .= $this->htmlFromArray($v->children);
			}


			$html .= '</ol>
					</li>';
		}

		return $html;
	}

}