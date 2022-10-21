<?php


namespace Modules\products\Repository;


use App\Repositories\BaseInterface;

interface ProductRepositoryInterface extends BaseInterface
{
    public function where($where);

    public function ProductList();

    public function searchProducts($request);

    public function getProductListWithInventory();
}
