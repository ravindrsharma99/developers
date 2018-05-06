<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name','status', 'show_on_home_app'
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    public function getApps($params = []){
        $length = isset($params['length']) ? (int) $params['length'] : 20;
        $start = isset($params['start']) ? (int) $params['start'] : 0;
        $sort = isset($params['sort']) ?  $params['sort'] : 'id';
        
        $apps = \App\NewApp::where('category', $this->id)
        ->where('status', 'active')
        ->where('app_status', \App\NewApp::STATUS_approved)
        ->orderBy($sort, 'DESC')
        ->skip($start)
        ->take($length)
        ->get();

        return $apps;
    }
}
