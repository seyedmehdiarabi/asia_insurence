<?php

namespace Modules\users\Models;

use App\CustomModel;
use Modules\city\Models\City;
use Modules\province\Models\Province;
use Modules\region\Models\Region;
use Modules\zone\Models\Zone;

class AdditionalInfo extends CustomModel
{
    protected $table='users__additional_info';

    protected $guarded=[];

    public function province()
    {
        return $this->belongsTo(Province::class,'province_id','id')
            ->withDefault(['name'=>'']);
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_id','id')
            ->withDefault(['name'=>'']);
    }

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id','id')
            ->withDefault(['name'=>'']);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class,'zone_id','id')
            ->withDefault(['name'=>'']);
    }
}
