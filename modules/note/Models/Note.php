<?php

namespace Modules\note\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\farmer\Models\Land;
use Modules\users\Models\User;
class Note extends CustomModel
{
    use SoftDeletes;
    protected $table='note';
    protected $guarded=[];

    public static function getData($request)
    {
        $string = '?';
        $where=where_user_role('user_id');
        $note = self::where($where)->orderBy('id', 'DESC');
        if (inTrashed($request)) {
            $note = $note->onlyTrashed();
            $string = create_paginate_url($string, 'trashed=true');
        }
        if (array_key_exists('name', $request) && !empty($request['name'])) {
            $note = $note->where('name', 'like', '%' . $request['name'] . '%');
            $string = create_paginate_url($string, 'name=' . $request['name']);
        }
        $note = $note->paginate(10);
        $note->withPath($string);
        return $note;
    }
    public function getUsersName()
    {
        return $this->hasOne(User::class,'id','user_id')->withDefault(['name'=>''])->select(['id','name']);
    }

}
