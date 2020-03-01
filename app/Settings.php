<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{   
    protected $table = 'tbl_settings';

    public static function set($key, $value = '')
    {
        if (is_array($key)) {
            foreach ($key as $array_key => $array_value) {
                $setting = self::firstOrNew(['key' => $array_key]);
                $setting->value = $array_value;
                $setting->save();
            }
        } else {
            $setting = self::firstOrNew(['key' => $key]);
            $setting->value = $value;
            $setting->save();
        }

        return true;
    }
     
}