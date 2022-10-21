<?php


namespace Modules\products\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\products\Models\Product;
use Modules\products\Models\ProductInventory;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepositoryInterface
{

    protected $model = 'Modules\products\Models\Product';

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function create($request)
    {
        $product = new Product($request->all());
        $image_url = upload_file($request, 'pic', 'products');
        $product->image_url = $image_url;
        create_fit_pic('files/products/' . $image_url, $image_url);
        $product->saveOrFail();
    }

    public function trashCount()
    {
        return Product::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Product::getData($request->all());
    }

    public function update($id, $request)
    {
        $data = $request->all();
        $product = Product::findOrFail($id);
        $image_url = upload_file($request, 'pic', 'products');
        if (!empty($image_url)) {
            remove_file($product->image_url, 'products');
            remove_file($product->image_url, 'thumbnails');
            create_fit_pic('files/products/' . $image_url, $image_url);
            $product->image_url = $image_url;
        }
        $product->update($data);
    }

    public function where($where)
    {
        return Product::where($where)->get();
    }

    public function ProductList()
    {
        return Product::get()->toArray();
    }

    public function searchProducts($request)
    {
        return Product::where('title', 'like', '%' . $request['title'] . '%')->get();
    }

    public function getProductListWithInventory()
    {
        return Product::join('products__inventory', 'products.id', '=', 'products__inventory.product_id')->get();
    }
}
