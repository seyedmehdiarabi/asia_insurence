<?php

namespace Modules\users\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function changeMobileNumber($request)
    {

        $user_id = $request->user()->id;
        $AdditionalInfo = AdditionalInfo::where(['user_id' => $user_id, 'mobile_phone' => $mobile])->first();
        if ($AdditionalInfo) {
            $user = User::find($user_id);
            if ($active_code == $user->active_code) {
                $user->mobile = $AdditionalInfo->mobile_phone;
                $user->update();
                return redirect('user/profile/additional-info')->with('status', 'ثبت اطلاعات با موفقیت انجام شد');
            } else {
                return redirect()->back()->with('mobile_number', $mobile)->with(['validate_error' => 'کد فعال سازی وارد شد اشتباه می باشد']);
            }
        } else {
            return redirect('/');
        }
    }

    public static function resend($request)
    {
        $active_code = rand(99999, 1000000);
        $mobile = $request->get('mobile');
        $forget_password = $request->get('forget_password', 'no');
        $user = null;
        $result = 'error';
        $forget = false;
        if ($request->ajax()) {
            if (Auth::check()) {
                $user_id = $request->user()->id;
                $row = AdditionalInfo::where('user_id', $user_id)->first();
                $user = User::where(['id' => $user_id])->first();
                if ($row && $row->mobile_phone != $user->mobile) {
                    $user->active_code = $active_code;
                    $result = 'ok';
                }
            } else {
                if ($forget_password == 'ok') {
                    $user = User::where(['mobile' => $mobile, 'account_status' => 'active'])->first();
                    if ($user) {
                        $forget = true;
                        $user->forget_password_code = $active_code;
                        $result = 'ok';
                    }
                } else {
                    $user = User::where(['mobile' => $mobile, 'account_status' => 'InActive'])->first();
                    if ($user) {
                        $user->active_code = $active_code;
                        $result = 'ok';
                    }
                }
            }

            if ($result == 'ok' && $user) {
                $user->update();
                $c = $forget ? $user->forget_password_code : $user->active_code;
                $message = env("SHOP_NAME", '') . "\n";
                $message .= 'کد تایید';
                $message .= " : " . $c;

                $user->notify(new \App\Notifications\SendSms($user->mobile, $message));
            }
        } else {
            return 'error';
        }
    }

    public static function getData($request, $where = [])
    {
        $string = '?';
        $users = self::where($where)->with('getRole')->orderBy('id', 'DESC');
        if (inTrashed($request)) {
            $users = $users->onlyTrashed();
            $string = create_paginate_url($string, 'trashed=true');
        }
        if (array_key_exists('name', $request) && !empty($request['name'])) {
            $users = $users->where('name', 'like', '%' . $request['name'] . '%');
            $string = create_paginate_url($string, 'name=' . $request['name']);
        }
        if (array_key_exists('mobile', $request) && !empty($request['mobile'])) {
            $mobile = \replace_number2($request['mobile']);
            $users = $users->where('mobile', 'like', '%' . $mobile . '%');
            $string = create_paginate_url($string, 'mobile=' . $request['mobile']);
        }
        if (array_key_exists('role', $request) && !empty($request['role'])) {
            if ($request['role'] == 'admin' || $request['role'] == 'user') {
                $users = $users->where('role', $request['role']);
            } else {
                $users = $users->where(['role' => 'user', 'role_id' => $request['role']]);
            }
            $string = create_paginate_url($string, 'role=' . $request['role']);
        }
        $users = $users->paginate(10);
        $users->withPath($string);
        return $users;
    }

    public function getRole()
    {
        return $this->hasone(UserRole::class, 'id', 'role_id')->withTrashed();
    }

    public function getAdditionalInfo()
    {
        return $this->hasone(AdditionalInfo::class, 'user_id', 'id')->with('city')->with('province');
    }

    public static function AccessList()
    {
        $array = array();
        $array = CompleteData('set_user_access_list', $array);
        $array = CompleteData('set_user_child_access', $array);
        return $array;
    }

    public function getEmailForPasswordReset()
    {
        return $this->mobile;
    }

    public function findForPassport($mobile)
    {
        return $this->where(['mobile' => $mobile, 'account_status' => 'active'])->first();
    }

}
