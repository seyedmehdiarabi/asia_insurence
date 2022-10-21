<?php

namespace Modules\products\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Mail;
use App\Mail\ProductStatus;
use Modules\categories\Models\Category;
use Modules\units\Models\Units;

class Product extends CustomModel
{
    use SoftDeletes;

    protected $table = 'products';

    protected $guarded = ['pic'];

    public static function ProductStatus()
    {
        $array = array();
        $array[0] = 'توقف تولید';
        $array[1] = 'ناموجود';
        $array[2] = 'موجود';
        $array[3] = 'ضایعات';
        $array[4] = 'تاریخ گذشته';

        return $array;
    }

    public static function getData($request)
    {
        $string = '?';
        $relation = CompleteData('product_list_relation', []);
        $products = self::with($relation);
        if (inTrashed($request)) {
            $products = $products->onlyTrashed();
            $string = create_paginate_url($string, 'trashed=true');
        } else {
            $products = $products->whereNull('deleted_at');
        }

        if (array_key_exists('order_by', $request)) {
            if ($request['order_by'] == 'new') {
                $products = $products->orderBy('id', 'DESC');
            }
        } else {
            $products = $products->orderBy('id', 'DESC');
        }

        if (array_key_exists('string', $request) && !empty($request['string'])) {
            $products = $products->where('title', 'like', '%' . $request['string'] . '%');
            $products = $products->orWhere('ename', 'like', '%' . $request['string'] . '%');
            $string = create_paginate_url($string, 'string=' . $request['string']);
        }

        if (array_key_exists('status', $request) && !empty($request['status'])) {
            $products = $products->where('status', $request['status']);
            $string = create_paginate_url($string, 'status=' . $request['status']);
        }

        $data = CompleteData('select_product_list', [$products, $string]);
        $products = $data[0];
        $string = $data[1];

        $products = $products->paginate(10);
        $products->withPath($string);
        return $products;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($product) {
            if ($product->isForceDeleting()) {
                remove_file($product->image_url, 'products');
                remove_file($product->image_url, 'thumbnails');
            }
        });
    }

    public function getCat()
    {
        return $this->hasOne(Category::class, 'id', 'cat_id')->withDefault(['name' => '']);
    }

    public function getUnit()
    {
        return $this->hasOne(Units::class, 'id', 'unit_id')->withDefault(['name' => '']);

    }

    public function getInventory()
    {
        return $this->belongsTo(ProductInventory::class, 'id', 'product_id');

    }
}
