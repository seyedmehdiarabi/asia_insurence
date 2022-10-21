<?php

function has_access_author_admin($property, $accessValue = null)
{

    $result = false;
    $accessList = getAccess();
    if ($accessList) {
        try {
            $accessList = json_decode($accessList);
            if (is_object($accessList)) {
                if (property_exists($accessList, $property)) {
                    if (is_array($accessList->$property)) {
                        if ($accessValue == null) {
                            $result = true;
                        } else {
                            foreach ($accessList->$property as $key => $value) {
                                if ($value == $accessValue) {
                                    $result = true;
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {

        }
    }
    return $result;
}

function getAllAccess()
{
    $role_id = Auth::user()->role_id;
    $repository = app(\Modules\users\Repository\UserRoleRepositoryInterface::class);
    return $repository->allAccess($role_id);
}

function checkUserAccess($route, $AccessList)
{
    $access = getAccess();
    $result = true;
    if ($access) {
        $access = json_decode($access);
        if (is_object($access)) {
            foreach ($access as $key => $value) {
                if (array_key_exists($key, $AccessList)) {
                    $userAccess = $AccessList[$key]['access'];
                    foreach ($value as $key2 => $value2) {
                        if (array_key_exists($value2, $userAccess)) {
                            if (array_key_exists('routes', $userAccess[$value2])) {
                                foreach ($userAccess[$value2]['routes'] as $accessRoute) {
                                    if ($accessRoute == $route) {
                                        $result = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $result;
}

function getAccess()
{
    $result = null;
    $modulesMainClass = Config::get('app.modulesMainClass');
    if (array_key_exists('users', $modulesMainClass)) {
        if (method_exists($modulesMainClass['users'], 'getUserAccess')) {
            $result = $modulesMainClass['users']->getUserAccess();
        }
        return $result;
    }
    return $result;
}

function personal_user_detail($detail)
{
    $array = [];
    $array[] = ['title' => ' نام پدر :', 'attr' => 'father_name', 'value' => getUserPersonalData($detail, 'father_name'),'icon' => 'mdi-human-male-boy'];
    $array[] = ['title' => 'شماره شناسنامه : ', 'value' => replace_number(getUserPersonalData($detail, 'id_number')), 'attr' => 'id_number','icon' => 'mdi-numeric'];
    $array[] = ['title' => 'کد ملی : ', 'value' => replace_number(getUserPersonalData($detail, 'national_identity_number')), 'attr' => 'national_identity_number','icon' => 'mdi-credit-card'];
    $array[] = ['title' => ' تاریخ تولد', 'value' => replace_number(getUserPersonalData($detail, 'date_of_birth')), 'attr' => 'date_of_birth','icon' => 'mdi-cake'];
    $array[] = ['title' => 'شماره کارت بانکی : ', 'value' => replace_number(getUserPersonalData($detail, 'card_number')), 'attr' => 'bank_card','icon' => 'mdi-bank'];
    $array[] = ['title' => 'معرف :', 'value' => getUserPersonalData($detail, 'reagent'), 'attr' => 'reagent','icon' => 'mdi-shield-account'];
    $array[] = ['title' => 'نحوه آشنایی :', 'value' => getUserPersonalData($detail, 'introduction'), 'attr' => 'introduction','icon' => 'mdi-clock-start'];
    $array[] = ['title' => 'ایمیل :', 'value' => getUserPersonalData($detail, 'email'), 'attr' => 'email','icon' => 'mdi-email-open-outline'];
    $array[] = ['title' => 'توضیحات :', 'value' => getUserPersonalData($detail, 'description'), 'attr' => 'description','icon' => 'mdi-calendar-text-outline'];
    $array = CompleteData('personal_user_detail', $array);
    return $array;
}

function getUserPersonalData($additionalInfo, $att1, $attr2 = null)
{
    $result = '-';
    if ($additionalInfo && !empty($additionalInfo->$att1)) {
        $result = $additionalInfo->$att1;
        if ($attr2) {
            $result .= ' ' . $additionalInfo->$attr2;
        }
    }
    return $result;
}

function send_auth_sms($user, $active_code, $mobile = null)
{

    $repository = app(\Modules\setting\Repository\SettingRepositoryInterface::class);
    $setting = $repository->getValues([
        'users-channel',
        'users-api-key',
        'users-line_number',
        'users-active_template'
    ]);
    $message = '';
    if ($setting['users-active_template'] == '' && !empty($setting['users-line_number'])) {
        $message = config('shop-info.shop_name') . "\n";
        $message .= 'کد تایید';
        $message .= ' : ' . $code;
    } else {
        $message = $active_code;
    }

    $user->notify(new \Modules\setting\Notifications\SendSms(
        [
            'channel' => $setting['users-channel'],
            'line_number' => $setting['users-line_number'],
            'api-key' => $setting['users-api-key'],
            'template' => $setting['users-active_template'],
            'mobile_number' => $mobile !== null ? $mobile : $user->mobile,
            'message' => $message
        ]
    ));
}

function getAccessMenu($sideBarMenu, $access)
{
    foreach ($sideBarMenu as $key => $value) {
        if (checkParentMenuAccess($access, $value['access'])) {
            if (array_key_exists('child', $value)) {
                foreach ($value['child'] as $key2 => $value2) {
                    if (!checkAddChildMuenAccess($access, $value2)) {
                        unset($sideBarMenu[$key][$key2]);
                    }
                }
            }
        } else {
            unset($sideBarMenu[$key]);
        }
    }
    return $sideBarMenu;
}

function validateBankCard($value)
{
    if (strlen($value) == 16) {
        $sum = 0;
        for ($i = 0; $i < strlen($value); $i++) {
            $n = intval($value[$i]);
            if (checkEven($i)) {
                $n = $n * 2;
                if ($n > 9) {
                    $n = $n - 9;
                }
            }
            $sum = $sum + $n;
        }

        if ($sum % 2 == 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function validateNationalIdentityNumber($code)
{
    $code = replace_number2($code);
    if(!preg_match('/^[0-9]{10}$/',$code))
        return false;
    for($i=0;$i<10;$i++)
        if(preg_match('/^'.$i.'{10}$/',$code))
            return false;
    for($i=0,$sum=0;$i<9;$i++)
        $sum+=((10-$i)*intval(substr($code, $i,1)));
    $ret=$sum%11;
    $parity=intval(substr($code, 9,1));
    if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
        return true;
    return false;
}

function validateData($data)
{
    $result = false;
    $e = explode('/', $data);
    if (sizeof($e) == 3) {
        $y = $e[0];
        $m = $e[1];
        $d = $e[2];
        settype($y, 'integer');
        settype($m, 'integer');
        settype($d, 'integer');
        if (strlen($y) == 4 && (strlen($m) == 1 || strlen($m) == 2) && (strlen($d) == 1 || strlen($d) == 2)) {
            $result = true;
        }
    }
    return $result;
}

function getUserNmae($id)
{
    $repository = app(\Modules\users\Repository\UsersRepositoryInterface::class);
    $user = $repository->find($id);
    return $user->name;
}

function CeremonialTitle(): array
{
    $array = [
        0 => 'جناب آقای',
        1 => 'سرکار خانم',
        2 => 'جناب آقای مهندس',
        3 => 'سرکار خانم مهندس',
        4 => 'جناب آقای دکتر',
        5 => 'سرکار خانم دکتر',
    ];
    return $array;
}

function generateUniqueCode($length)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

