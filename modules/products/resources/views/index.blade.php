@extends('backend-theme::layout')

@section('content')

    <div>
        <?php  $status = \Modules\products\Models\Product::ProductStatus(); define('status', $status); ?>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت محصولات','url'=>url('products')]]])

        @includeIf('products::_search_form')

        <?php
        $args = ['title' => 'مدیریت محصولات'];
        $args['route'] = 'products';
        $args['trashCount'] = $trash_product_count;
        $args['routeParam'] = 'محصول';
        ?>


        <x-panel-box :args="$args">


            <?php
            \App\Lib\GridView::showTable([
                'dataProvider' => $product,
                'columns' => [
                    ['label' => 'تصویر محصول', 'attr' => function ($model) {
                        $src = url('files/thumbnails/' . $model->image_url);
                        return '<img src="' . $src . '" class="product_pic"  style="margin:20px;width:50px">';
                    }, 'html' => true],
                    ['label' => 'عنوان', 'attr' => 'title'],
                    ['label' => 'موجودی', 'attr' => function ($model) {
                        return replace_number($model->getInventory->healthyNow);
                    }],
                    ['label' => 'واحد کالا', 'attr' => function ($model) {
                        return $model->getUnit->unit_title;
                    }],
                    ['label' => 'قیمت فروش', 'attr' => function ($model) {
                        return getPrice($model->price);
                    }],
                    ['label' => 'وضعیت محصول', 'attr' => function ($model) {
                        if (array_key_exists($model->status, status)) {
                            $class = ($model->status == 1) ? "alert-success" : 'alert-warning';
                            return '<span class="' . $class . '" style="font-size:13px;padding:5px 7px">' . status[$model->status] . '</span>';
                        }
                    }, 'html' => true],
                ],
                'route_param' => 'products',
                'tableLabel' => 'محصول'
            ]);
            ?>

            {{ $product->links() }}

        </x-panel-box>

    </div>

@endsection
