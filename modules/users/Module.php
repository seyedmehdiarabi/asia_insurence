<?php


namespace Modules\users;

use Modules\users\Repository\AdditionalInfoRepositoryInterface;
use Modules\users\Repository\UsersRepositoryInterface;
use View;

class Module
{
    protected $user_access = null;

    public function registerComponent()
    {
        return veu_component_detail('users');
    }

    public function users_index_action()
    {
        return function ($model) {
            $url = url('users/' . $model->id . '/additional_info');
            return view('users::additionalInfo.additional_info_icon', ['url' => $url]);
        };
    }

    public function getUserAccess()
    {
        if ($this->user_access == null) {
            $this->user_access = getAllAccess();
            return $this->user_access;
        } else {
            View::share('access', $this->user_access);
            return $this->user_access;
        }
    }

    public function set_user_access_list($access)
    {
        $access['users'] = [
            'label' => 'کاربران',
            'access' => [
                'users_edit' => ['label' => 'ثبت و ویرایش کاربر', 'routes' => [
                    'users.index', 'users.create', 'users.store', 'users.edit', 'users.update'
                ]],
                'remove_users' => ['label' => 'حذف کاربر', 'routes' => ['users.index', 'users.destroy']],
                'additional_users' => ['label' => 'اطلاعات تکمیلی کاربر', 'routes' => ['users.profile']],
                'restore_users' => ['label' => 'بازیابی کاربر', 'routes' => ['users.index', 'users.restore']]
            ]
        ];
        $access['admin'] = [
            'label' => 'پیشخوان',
            'access' => [
                'admin_index' =>
                    ['label' => 'میزکار', 'routes' => ['admin.index']],
            ]
        ];
        return $access;
    }

    public function before_show_view($args)
    {
        $routeName = getRouteName();
        if ($routeName == 'users_profile' || $routeName == 'users_show') {
            $repository = app(AdditionalInfoRepositoryInterface::class);
            if (array_key_exists('id', $args)) {
                $user_id = $args['id'];
            } elseif (array_key_exists('user', $args)) {
                $user_id = $args['user']->id;
            }
            $additionalInfo = $repository->find(['user_id' => $user_id]);
            $args['additionalInfo'] = $additionalInfo;
            $args['personal_user_detail'] = personal_user_detail($additionalInfo);
        }
        if ($routeName == 'land_index' ||
            $routeName == 'land_create' ||
            $routeName == 'land_edit' ||
            $routeName == 'pests_index' ||
            $routeName == 'planVisit_index'
        ) {
            $repository = app(UsersRepositoryInterface::class);
            $expert = $repository->getExpert();
            View::share(['expert' => $expert]);
        }
        return $args;
    }

    public function registered($user)
    {
        $code = $user->active_code;
        send_auth_sms($user, $code);
    }

    public function user_panel_index()
    {
        if (view_type == '') {
            return [
                [
                    'index' => 0,
                    'view' => 'users::additionalInfo.register-detail'
                ]
            ];
        }
    }

    public function admin_banner_index()
    {
        return [
            [
                'view' => 'users::banner.index',
                'index' => 1
            ],
        ];
    }

}
