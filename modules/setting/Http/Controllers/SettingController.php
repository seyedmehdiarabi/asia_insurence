<?php


namespace Modules\setting\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\setting\Models\Setting;
use Modules\setting\Repository\SettingRepositoryInterface;

class SettingController extends Controller
{
    public function portal(Request $request)
    {
        if($request->isMethod('post'))
        {
            $setting=new Setting();
            $setting->addConfig($request);
            return  [
                'redirect_url'=>url('setting/portal'),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        return CView('setting::portal');
    }

    public function workshop(Request $request)
    {
        if($request->isMethod('post'))
        {
            $setting=new Setting();
            $name = 'workshop';
            $setting->addConfig($request,$name);
            return  [
                'redirect_url'=>url('setting/'.$name),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        return CView('setting::workshop');
    }

    public function salary(Request $request)
    {
        if($request->isMethod('post'))
        {
            $setting=new Setting();
            $name = 'salary';
            $setting->addConfig($request,$name);
            return  [
                'redirect_url'=>url('setting/'.$name),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        return CView('setting::salary');
    }


}
