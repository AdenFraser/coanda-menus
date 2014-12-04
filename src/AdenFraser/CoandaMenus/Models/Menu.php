<?php namespace AdenFraser\CoandaMenus\Models;

use Eloquent;
use CoandaCMS\Coanda\Exceptions\ValidationException;
use CoandaCMS\Coanda\Urls\Slugifier;

class Menu extends Eloquent {

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'identifier',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

    public function delete()
    {
        $this->items()->delete();

        parent::delete();
    }

    public function items()
    {
        return $this->hasMany('AdenFraser\CoandaMenus\Models\MenuItem')->orderBy('order', 'asc');
    }

    /**
     * @param $data
     * @return object
     */
    public static function validateAndCreate($data)
    {
        $data = Menu::validateInput($data);
        $menu = Menu::create($data);

        return $menu;
    }

    /**
     * @param $data
     */
    public function validateAndUpdate($data)
    {
        Menu::validateInput($data);

        $this->name = $data['name'];
        $this->identifier = $this->createIdentifier($data);
        $this->save();
    }

    /**
     * @param $data
     * @throws ValidationException
     */
    private static function validateInput($data)
    {
        $invalid_fields = [];

        if (!isset($data['name']) || $data['name'] == '')
        {
            $invalid_fields['name'] = 'Please enter a name';
        }

        if (!isset($data['identifier']) || $data['identifier'] == '')
        {
            $data['identifier'] = Slugifier::convert($data['name']);
        }

        if (count($invalid_fields) > 0)
        {
            throw new ValidationException($invalid_fields);
        }

        return $data;
    }

}