<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'color',
        'group_key'
    ];

    public static function createGroup($params = []){
        $group = SettingGroup::where('group_key', $params['group_key'])->first();
        if($group){
            return $group;
        }
        $group = SettingGroup::create($params);
        return $group;
    }

    public function settings(){
        return $this->hasMany('App\Setting', 'group_key', 'group_key');
    }
}
