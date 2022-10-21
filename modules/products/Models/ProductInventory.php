<?php

namespace Modules\products\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInventory extends CustomModel
{
    use SoftDeletes;

    protected $table = 'products__inventory';

    protected $guarded = [];

}
