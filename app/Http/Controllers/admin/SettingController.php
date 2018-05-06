<?php

namespace App\Http\Controllers\admin;
use App\Setting;
use App\SettingGroup;
use App\SettingOption;
use Illuminate\Http\Request;
use Session;
use File;
use Response;
use View;

use App\Http\Controllers\Controller;


class SettingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');

        View::share(['menu' => 'settings', 'mainmenu' => 'Dashboard']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Setting::with(['settingGroup'])
            ->where('is_active', 1)
            ->get();
        $groups = [
            'general_settings' => [
                'title' => 'General Settings',
                'group_key' => 'general_settings',
                'color' => 'purple',
                'settings' => [],
            ],
        ];
        foreach ($items as $item) {
            if (empty($item->group_key)) {
                $groups['general_settings']['settings'][] = $item;
            } elseif (isset($groups[$item->group_key])) {
                $groups[$item->group_key]['settings'][] = $item;
            } else {
                $groups[$item->group_key] = [
                    'title' => $item->settingGroup->title,
                    'group_key' => $item->group_key,
                    'settings' => [$item],
                    'color' => $item->settingGroup->color,
                ];
            }
        }

        return view('admin.settings.index', ['groups' => $groups]);
    }

    public function updateSettings(Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $value) {
            $item = Setting::where('setting_key', $key)->first();
            if ($item) {
                $item->setting_value = $value;
                $item->save();
            }
        }
        Session::flash('success', 'Update settings successfully.');
        return redirect()->to("admin/settings");
    }

    public function create(Request $request)
    {
        $groups = SettingGroup::all();
        $colors = ['purple', 'red', 'green', 'orange', 'blue'];
        return view('admin.settings.create', [
            'groups' => $groups,
            'colors' => $colors
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'title' => 'required',
            'setting_value' => 'required',
            'setting_type',
        ]);

        $settingKey = $request->input('setting_key');
        if(empty($settingKey)){
            $settingKey = str_slug($request->input('title'), '_');
        }
        // check setting if exists
        $checkSetting = Setting::where('setting_key', $settingKey)->first();
        if($checkSetting){
            $request->flash();
            $validator->errors()->add('setting_key', 'Setting is exists');
            $this->throwValidationException($request, $validator);
        }
        $params = [
            'title' => $request->input('title'),
            'setting_value' => $request->input('setting_value'),
            'setting_key' => $settingKey,
            'setting_type' => $request->input('setting_type'),
        ];

        if ($request->input('group_key') == 'new_group') {
            // create new group
            if (!$request->input('group_name')) {
                $request->flash();
                $validator->errors()->add('group_name', 'Group name is requried');
                $this->throwValidationException($request, $validator);
            }
            $groupKey = str_slug($request->input('group_name'), '_');

            $checkGroup = SettingGroup::where('group_key', $groupKey)->first();
            if(!$checkGroup){
                $group = SettingGroup::create([
                    'title' => $request->input('group_name'),
                    'group_key' => $groupKey,
                    'color' => $request->input('group_color') ? $request->input('group_color') : 'purple',
                ]);
                $params['group_key'] = $group->group_key;
            }
            else{
                $params['group_key'] = $groupKey;
            }
            
        }
        else if($request->input('group_key')){
            $params['group_key'] = $request->input('group_key');
        }

        if ($request->input('setting_type') == 'select') {
            if (!empty($request->input('setting_options'))) {
                // create setting options
                $settingOptions = explode(',', $request->input('setting_options'));
                foreach ($settingOptions as $op) {
                    $optionTitle = trim($op);
                    if (!empty($optionTitle)) {
                        $option = SettingOption::create([
                            'setting_key' => $params['setting_key'],
                            'option_title' => $optionTitle,
                            'option_value' => str_slug($optionTitle, '_'),
                        ]);
                    }
                }
            }
        }

        $setting = Setting::create($params);
        Session::flash('message', 'Create setting successfully.');
        return redirect()->to("admin/settings");
    }
}
