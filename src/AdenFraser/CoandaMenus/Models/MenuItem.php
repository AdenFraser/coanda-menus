<?php namespace AdenFraser\CoandaMenus\Models;

use Coanda;
use CoandaCMS\Coanda\Exceptions\ValidationException;
use Eloquent;

class MenuItem extends Eloquent
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'page_id',
        'link',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menuitems';

    public function menu()
    {
        return $this->belongsTo('AdenFraser\CoandaMenus\Models\Menu', 'menu_id');
    }

    /**
     * @return string
     */
    public function link()
    {
        if ($this->page_id) {
            return $this->pageLink($this->page_id);
        } else {
            return $this->link;
        }
    }

    /**
     * @param $page_id
     *
     * @return string
     */
    public static function pageLink($page_id)
    {
        if ($page = Coanda::pages()->getPage($page_id)) {
            return url($page->slug);
        }

        return url();
    }

    /**
     * Updates an individual menu items order in the database,
     * before proceeding to update any children.
     *
     * @param integer $new_order
     * @param integer $parent_id
     * @param object  $item
     */
    public function updateItemOrder($new_order, $parent_id, $item)
    {
        $this->order = $new_order;
        $this->parent_id = $parent_id;
        $this->save();

        if (count($item->children) > 0 && !empty($item->children[0])) {
            Menu::updateOrder($item->children[0], $item->id);
        }
    }

    /**
     * @param $menu_id
     * @param $data
     *
     * @return MenuItem
     */
    public static function validateAndCreate($menu_id, $data)
    {
        $data = MenuItem::validateInput($data);

        $item = new MenuItem();
        $item->name = $data['name'];
        $item->link = isset($data['link']) ? $data['link'] : false;
        $item->page_id = isset($data['page_id']) ? $data['page_id'] : false;

        $max_order = MenuItem::max('order');

        $item->order = $max_order + 1;

        $menu = Menu::find($menu_id);
        $menu->items()->save($item);

        return $item;
    }

    /**
     * @param $data
     */
    public function validateAndUpdate($data)
    {
        $data = MenuItem::validateInput($data);

        $this->name = $data['name'];
        $this->link = isset($data['link']) ? $data['link'] : false;
        $this->page_id = isset($data['page_id']) ? $data['page_id'] : false;

        $this->save();
    }

    /**
     * @param $data
     *
     * @throws ValidationException
     *
     * @return array
     */
    private static function validateInput($data)
    {
        $invalid_fields = [];

        if (!isset($data['name']) || $data['name'] == '') {
            $invalid_fields['name'] = 'Please enter a name';
        }

        if ((!isset($data['link']) || $data['link'] == '') && (!isset($data['page_id']) || $data['page_id'] == '')) {
            $invalid_fields['page_id'] = 'Please select either a page or define a custom link';
        }

        if (count($invalid_fields) > 0) {
            throw new ValidationException($invalid_fields);
        }

        return $data;
    }
}
