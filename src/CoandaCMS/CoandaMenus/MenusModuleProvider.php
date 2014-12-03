<?php namespace CoandaCMS\CoandaMenus;

use Illuminate\Support\Collection;
use Route;
use CoandaCMS\CoandaMenus\Models\Menu;

class MenusModuleProvider implements \CoandaCMS\Coanda\CoandaModuleProvider {

    /**
     * @var string
     */
    public $name = 'menus';

    public function boot(\CoandaCMS\Coanda\Coanda $coanda)
    {
        // Add the permissions
        $permissions = [
            'manage' => [
                'name' => 'Manage',
                'options' => []
            ],
        ];

        $coanda->addModulePermissions('menus', 'Menus', $permissions);
    }

    /**
     *
     */
    public function adminRoutes()
    {
        // Load the media controller
        Route::controller('menus', 'CoandaCMS\CoandaMenus\Controllers\AdminController');
    }

    /**
     *
     */
    public function userRoutes()
    {
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return mixed
     */
    public function bindings(\Illuminate\Foundation\Application $app)
    {
    }

    /**
     * @param $permission
     * @param $parameters
     * @param $user_permissions
     * @return bool
     * @throws PermissionDenied
     */
    public function checkAccess($permission, $parameters, $user_permissions)
    {
    }

    /**
     * @param $coanda
     */
    public function buildAdminMenu($coanda)
    {
        if ($coanda->canViewModule('menus'))
        {
            $coanda->addMenuItem('menus', 'Menus');
        }
    }

    /**
     * @param $identifier
     * @return object Collection of Menu items
     */
    public function get($identifier)
    {
        $menu = Menu::whereIdentifier($identifier)->first();

        if ($menu)
        {
            return $menu->items;
        }

        return Collection::make([]);
    }
}