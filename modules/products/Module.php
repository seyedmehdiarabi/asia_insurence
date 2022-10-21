<?php


namespace Modules\products;


use Modules\products\Repository\ProductRepositoryInterface;

class Module
{
    public function set_user_access_list($access)
    {
        $access['products'] = [
            'label' => 'محصولات',
            'access' => [
                'product_edit' => ['label' => 'ثبت و ویرایش محصولات', 'routes' => [
                    'products.index', 'products.create', 'products.store', 'products.edit', 'products.update'
                ]],
                'remove_product' => ['label' => 'حذف محصولات', 'routes' => ['products.index', 'products.destroy']],
                'restore_product' => ['label' => 'بازیابی محصولات', 'routes' => ['products.index', 'products.restore']]
            ]
        ];

        return $access;
    }

    public function before_show_view($data)
    {
        $routeName = getRouteName();
        if ($routeName == 'check_inventory') {
            $productRepository = app(ProductRepositoryInterface::class);
            $data['product'] = $productRepository->getProductListWithInventory()->toArray();
            return $data;
        }
    }
}
