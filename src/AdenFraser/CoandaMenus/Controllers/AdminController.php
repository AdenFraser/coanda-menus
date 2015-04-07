<?php namespace AdenFraser\CoandaMenus\Controllers;

use AdenFraser\CoandaMenus\Models\MenuItemsHelper;
use App;
use Coanda;
use CoandaCMS\Coanda\Exceptions\ValidationException;
use Input;
use Redirect;
use Session;
use View;

class AdminController extends \CoandaCMS\Coanda\Controllers\BaseController
{
    private $menu;
    private $menuitem;

    public function __construct(\AdenFraser\CoandaMenus\Models\Menu $menu, \AdenFraser\CoandaMenus\Models\MenuItem $menuitem)
    {
        Coanda::checkAccess('menus', 'manage');

        $this->menu = $menu;
        $this->menuitem = $menuitem;
    }

    /**
     * @param $menu_id
     *
     * @return object
     */
    private function __getMenu($menu_id)
    {
        $menu = $this->menu->find($menu_id);

        if (!$menu) {
            App::abort('404');
        }

        return $menu;
    }

    /**
     * @param $menu_id
     *
     * @return object
     */
    private function __getMenuItem($menu_id)
    {
        $menu = $this->menuitem->find($menu_id);

        if (!$menu) {
            App::abort('404');
        }

        return $menu;
    }

    public function getIndex()
    {
        return View::make('coanda-menus::menus.admin.index', ['menus' => $this->menu->paginate(20) ]);
    }

    public function getAddMenu()
    {
        return View::make('coanda-menus::menus.admin.addmenu', [ 'invalid_fields' => Session::get('invalid_fields', []) ]);
    }

    /**
     * @throws ValidationException
     */
    public function postAddMenu()
    {
        try {
            $this->menu->validateAndCreate(Input::all());

            return Redirect::to(Coanda::adminUrl('menus'))->with('added', true);
        } catch (ValidationException $exception) {
            return Redirect::to(Coanda::adminUrl('menus/add-menu'))->with('error', true)->with('invalid_fields', $exception->getInvalidFields())->withInput();
        }
    }

    /**
     * @param $menu_id
     */
    public function getEditMenu($menu_id)
    {
        $menu = $this->__getMenu($menu_id);

        return View::make('coanda-menus::menus.admin.editmenu', [ 'menu' => $menu, 'invalid_fields' => Session::get('invalid_fields', []) ]);
    }

    /**
     * @param $menu_id
     *
     * @throws ValidationException
     */
    public function postEditMenu($menu_id)
    {
        $menu = $this->__getMenu($menu_id);

        try {
            $menu->validateAndUpdate(Input::all());

            return Redirect::to(Coanda::adminUrl('menus'))->with('updated', true);
        } catch (ValidationException $exception) {
            return Redirect::to(Coanda::adminUrl('menus/edit-menu/'.$menu_id))->with('error', true)->with('invalid_fields', $exception->getInvalidFields())->withInput();
        }
    }

    /**
     * @param $menu_id
     */
    public function getRemoveMenu($menu_id)
    {
        $menu = $this->__getMenu($menu_id);

        return View::make('coanda-menus::menus.admin.removemenu', ['menu' => $menu ]);
    }

    /**
     * @param $menu_id
     */
    public function postRemoveMenu($menu_id)
    {
        $menu = $this->__getMenu($menu_id);
        $menu->delete();

        return Redirect::to(Coanda::adminUrl('menus'))->with('removed', true);
    }

    /**
     * @param $menu_id
     */
    public function getViewMenu($menu_id)
    {
        $menu = $this->__getMenu($menu_id);

        $menu_items = $menu->items()->paginate(100);

        $ordered_items = new MenuItemsHelper($menu_items);

        return View::make('coanda-menus::menus.admin.viewmenu', ['menu' => $menu, 'menus' => $menu_items, 'ordered_items' => $ordered_items]);
    }

    /**
     * @param $menu_id
     */
    public function postViewMenu($menu_id)
    {
        $menu = $this->__getMenu($menu_id);

        if (Input::has('update_order') && Input::get('update_order') == 'true') {
            $ordering = Input::get('overall_menu_order', []);

            if ($ordering != '') {
                $this->menu->updateOrder(json_decode($ordering), $parent_id = false);

                return Redirect::to(Coanda::adminUrl('menus/view-menu/'.$menu->id))->with('orders_updated', true);
            }
        }

        if (Input::has('remove_selected') && Input::get('remove_selected') == 'true') {
            $remove_ids = Input::get('remove_menu_ids', []);

            if (count($remove_ids) > 0) {
                return Redirect::to(Coanda::adminUrl('menus/remove-multiple/'.$menu->id))->with('remove_menu_ids', $remove_ids);
            }
        }

        return Redirect::to(Coanda::adminUrl('menus/view-menu/'.$menu->id));
    }

    /**
     * @param $menu_id
     */
    public function getAdd($menu_id)
    {
        $menu = $this->__getMenu($menu_id);

        return View::make('coanda-menus::menus.admin.add', [ 'menu' => $menu, 'invalid_fields' => Session::get('invalid_fields', []) ]);
    }

    /**
     * @param $menu_id
     */
    public function getRemoveMultiple($menu_id)
    {
        $menu = $this->__getMenu($menu_id);
        $remove_menu_ids = Session::get('remove_menu_ids', []);
        $remove_menus = [];

        if (count($remove_menu_ids) == 0) {
            return Redirect::to(Coanda::adminUrl('menus/view-menu/'.$menu->id));
        }

        foreach ($remove_menu_ids as $remove_menu_id) {
            $remove_menus[] = $this->menuitem->find($remove_menu_id);
        }

        return View::make('coanda-menus::menus.admin.removemultiple', [ 'menu' => $menu, 'remove_menus' => $remove_menus ]);
    }

    /**
     * @param $menu_id
     */
    public function postRemoveMultiple($menu_id)
    {
        $menu = $this->__getMenu($menu_id);

        $remove_menu_ids = Input::get('remove_menu_ids', []);

        foreach ($remove_menu_ids as $remove_menu_id) {
            $remove_menu = $this->menuitem->find($remove_menu_id);

            if ($remove_menu) {
                $remove_menu->delete();
            }
        }

        return Redirect::to(Coanda::adminUrl('menus/view-menu/'.$menu->id))->with('menus_removed', true);
    }

    /**
     * @param $menu
     *
     * @throws ValidationException
     */
    public function postAdd($menu_id)
    {
        $menu = $this->__getMenu($menu_id);

        try {
            $this->menuitem->validateAndCreate($menu->id, Input::all());

            return Redirect::to(Coanda::adminUrl('menus/view-menu/'.$menu->id))->with('added', true);
        } catch (ValidationException $exception) {
            return Redirect::to(Coanda::adminUrl('menus/add/'.$menu->id))->with('error', true)->with('invalid_fields', $exception->getInvalidFields())->withInput();
        }
    }

    /**
     * @param $menu
     */
    public function getEdit($menu_id)
    {
        $menu_item = $this->__getMenuItem($menu_id);

        return View::make('coanda-menus::menus.admin.edit', [ 'menu_item' => $menu_item, 'invalid_fields' => Session::get('invalid_fields', []) ]);
    }

    /**
     * @param $menu_id
     *
     * @throws ValidationException
     */
    public function postEdit($menu_id)
    {
        $menu = $this->__getMenuItem($menu_id);

        try {
            $menu->validateAndUpdate(Input::all());

            return Redirect::to(Coanda::adminUrl('menus/view-menu/'.$menu->menu->id))->with('updated', true);
        } catch (ValidationException $exception) {
            return Redirect::to(Coanda::adminUrl('menus/edit/'.$menu->id))->with('error', true)->with('invalid_fields', $exception->getInvalidFields())->withInput();
        }
    }

    /**
     * @param $menu_id
     */
    public function getRemove($menu_id)
    {
        $menu_item = $this->__getMenuItem($menu_id);

        return View::make('coanda-menus::menus.admin.remove', [ 'menu_item' => $menu_item ]);
    }

    /**
     * @param $menu_id
     */
    public function postRemove($menu_id)
    {
        $menu = $this->__getMenuItem($menu_id);
        $menu_id = $menu->menu->id;

        $menu->delete();

        return Redirect::to(Coanda::adminUrl('menus/view-menu/'.$menu_id))->with('removed', true);
    }

    /**
     * @param $menu_id
     */
    public function getView($menu_id)
    {
        $menu_item = $this->__getMenuItem($menu_id);

        return View::make('coanda-menus::menus.admin.view', [ 'menu_item' => $menu_item ]);
    }
}
