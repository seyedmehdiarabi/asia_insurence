<?php
$status = \Modules\products\Models\Product::ProductStatus();
$url = isset($url) ? $url : 'products';
$hide_fields = isset($filters) ? $filters : [];
?>

<?php
$option = ['url' => $url];
$data = isset($product) ? $product : [];
$form = new \App\Lib\FormBuilder($option, $type, $data);
?>

<?php $form->textInput('title', 'عنوان محصول', ['validate' => 'required', 'class' => 'total-width', 'append_icon' => 'mdi-format-title']); ?>


<div class="row">

    <div class="col-md-6">

        <?php $form->textInput('ename', 'عنوان لاتین محصول', ['class' => 'total-width', 'append_icon' => 'mdi-translate']); ?>

        <?php $form->fieldLocation('product_form_right_box') ?>

        <?php $form->numberInput('price', 'قیمت فروش (تومان)', ['class' => 'total-width', 'validate' => 'required', 'append_icon' => 'mdi-currency-usd', 'min' => 0]); ?>

        <?php $form->numberInput('weight', 'وزن', ['class' => 'total-width', 'validate' => 'required', 'append_icon' => 'mdi-weight-kilogram', 'min' => 0]); ?>

    </div>

    <div class="col-md-6">

        <div class="choice_pic_box" style="padding:20px 10px 0px 20px">
            <?php $url = '' ?>
            @if(isset($product))
                @php $url=url('files/thumbnails/'.$product->image_url) @endphp
            @endif
            <?php $form->imageInput('pic', 'تصویر محصول', ['class' => 'total-width'], $url); ?>
        </div>


        <?php $form->fieldLocation('product_form_left_box') ?>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <?php $form->numberInput('inventory', 'موجودی', ['class' => 'total-width', 'validate' => 'required', 'append_icon' => 'mdi-numeric', 'min' => 0]); ?>
    </div>

    <div class="col-md-6">
        @if(array_search('status',$hide_fields)===false)
            <?php $form->select($status, 'status', 'وضعیت محصول', ['class' => 'total-width', 'validate' => 'required', 'append_icon' => 'mdi-image-broken-variant'], 0); ?>
        @endif
    </div>
</div>

<?php $form->textarea('description', 'توضیحات', ['class' => 'total-width']); ?>


<?php $form->btn($type == 'create' ? 'ثبت محصول' : 'ویرایش محصول', $type); ?>

<?php $form->close(); ?>
