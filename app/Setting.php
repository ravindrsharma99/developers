<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // developer_commission_rate: rate will be used to divide money for admin and developer for each total paid download

    // total_site_earned: total money site earned after pay for developer
    // total_developers_earned: total money developers earn after pay for site
    // total_money_earned = total_site_earned + total_developers_earned. total money get from paid download app include both developer and site money

    // current_balance: total_site_earned + (developer_need_to_pay) current money site without pay for developer
    // total_paid_for_developer: total money paid for developer

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'setting_key',
        'setting_value',
        'group_key',
        'setting_type' 
    ];

    private static $cacheSettings = [];

    public static function getSetting($key, $defaultValue = ''){
        // check if this setting is in cache
        if(isset(static::$cacheSettings[$key])){
            return static::$cacheSettings[$key];
        }
        $item = Setting::where('setting_key', $key)->first();
        if(!$item) return $defaultValue;
        // save this setting to cache
        static::$cacheSettings[$key] = $item->setting_value;
        return $item->setting_value;
    }

    /**
     * 
     */
    public static function saveSetting($key, $value){
        $item = Setting::where('setting_key', $key)->first();
        if(!$item){
            $item = Setting::create([
                'title' => $key,
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_type' => 'text'
            ]);
        }
        else{
            $item->setting_value = $value;
            $item->save();
        }
        
        return $item;
    }

    /**
     * increase for a setting, only apply for number
     */
    public static function increaseSetting($key, $value){
        $item = Setting::where('setting_key', $key)->first();
        if(!$item){
            $item = Setting::create([
                'title' => $key,
                'setting_key' => $key,
                'setting_value' => 0,
                'setting_type' => 'text'
            ]);
        }

        $v = floatval($item->setting_value);
        $value = floatval($value);
        $v+= $value;
        $item->setting_value = round($v, 2);
        $item->save();
    }

    public function settingGroup()
    {
        return $this->belongsTo('App\SettingGroup', 'group_key', 'group_key');
    }

    public function options(){
        return $this->hasMany('App\SettingOption', 'setting_key', 'setting_key');
    }

    public static function createSetting($params = []){
        $setting = Setting::where('setting_key', $params['setting_key'])->first();
        if($setting) return $setting;
        $setting = Setting::create($params);
        return $setting;
    }

    public static function getSettingArray($key, $delimiter = ','){
        $str = self::getSetting($key);
        if(empty($str)) return [];
        $ars = explode($delimiter, $str);
        if(empty($ars)) return [];
        $result = [];
        foreach($ars as $ar){
            $s = trim($ar);
            if(!empty($s)){
                $result[] = $s;
            }
        }
        return $result;
    }

    public static function getSettingNumberArray($key, $delimiter = ','){
        $str = self::getSetting($key);
        if(empty($str)) return [];
        $ars = explode($delimiter, $str);
        if(empty($ars)) return [];
        $result = [];
        foreach($ars as $ar){
            $s = trim($ar);
            if(!empty($s)){
                $result[] = (int) $s;
            }
        }
        return $result;
    }

    public static function increaseEarnStatistic($data){
        if(empty($data)) return;
        if(isset($data['total_amount'])){
            Setting::increaseSetting('total_money_earned', $data['total_amount']);
            Setting::increaseSetting('current_balance', $data['total_amount']);
        }

        if(isset($data['admin_amount'])){
            Setting::increaseSetting('total_site_earned', $data['admin_amount']);
        }

        if(isset($data['developer_amount'])){
            Setting::increaseSetting('total_developers_earned', $data['developer_amount']);
        }
    }

    public static function getBraintreeConfig(){
        $mode = Setting::getSetting('braintree_environment');
        $braintreeMerchantId = Setting::getSetting("braintree_{$mode}_merchantid");
        $braintreePublicKey = Setting::getSetting("braintree_{$mode}_public_key");
        $braintreePrivateKey = Setting::getSetting("braintree_{$mode}_private_key");
        return [
            'mode' => $mode,
            'marchant_id' => $braintreeMerchantId,
            'public_key' => $braintreePublicKey,
            'private_key' => $braintreePrivateKey
        ];
    }

    public static function updateStatistic(){
        $statistic = [];
        // total_money_earned
        $totalEarned = \App\Payment::where('status', Payment::SUCCESS)->sum('amount');
        $statistic['total_money_earned'] = $totalEarned;
        // total_paid_for_developer
        $totalPaidForDevelopers = \App\WithdrawRequest::where('status', WithdrawRequest::SUCCESS)->sum('amount');
        $statistic['total_paid_for_developer'] = $totalPaidForDevelopers;
        // current_balance = total_earned - total_paid_for_developer
        $balance = $totalEarned - $totalPaidForDevelopers;
        $statistic['current_balance'] = $balance;

        // total_developers_earned
        $totalDevelopersEarned = \App\Payment::where('status', Payment::SUCCESS)->sum('developer_amount');
        $statistic['total_developers_earned'] = $totalDevelopersEarned;
        
        // total_site_earned = total_earned - total_developers_earned
        $totalSiteEarned = $totalEarned - $totalDevelopersEarned;
        $statistic['total_site_earned'] = $totalSiteEarned;

        $oldStatistic = [];
        foreach($statistic as $k => $v){
            $oldStatistic[$k] = Setting::getSetting($k);
            Setting::saveSetting($k, $v);
        }

        return [
            'current_statistic' => $oldStatistic,
            'updated_statistic' => $statistic
        ];
    }
}
