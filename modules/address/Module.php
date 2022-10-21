<?php


namespace Modules\address;

use Auth;
use Modules\address\Models\Address;
use Modules\address\Repository\AddressRepositoryInterface;
use Request;
use Session;

class Module
{
    public function before_show_view($data)
    {
        $routeName = getRouteName();
        if ($routeName == 'shipping_set_data'){
            $repository = app(AddressRepositoryInterface::class);
            $user_id = Auth::user()->id;
            $address = $repository->all($user_id);
            $data['address'] = $address;
            return $data;
        }
    }

    public function user_panel_menu($data)
    {
        $data[] = [
            'label' => 'نشانی ها',
            'icon' => 'mdi-map-marker',
            'url' => url('user/profile/address'),
        ];
        return $data;
    }

    public function registerComponent()
    {
        return veu_component_detail('address');
    }

    public function set_user_access_list($access)
    {
        $access['address'] = [
            'label' => 'آدرس‌ها',
            'access' => [
                'address_edit' => ['label' => 'ثبت و ویرایش آدرس', 'routes' => [
                    'address.get', 'address.create', 'address.update'
                ]],
                'remove_address' => ['label' => 'حذف آدرس', 'routes' => ['address.destroy']],
            ]
        ];
        return $access;
    }
}
