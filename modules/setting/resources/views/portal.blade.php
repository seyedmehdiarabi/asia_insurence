@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'تنظیمات سامانه','url'=>url('setting/portal')],]])

        <?php $args = ['title' => 'تنظیمات سامانه']; ?>

        <x-panel-box :args="$args">

            <?php
            $option = ['url' => 'setting/portal'];
            $form = new \App\Lib\FormBuilder($option);
            ?>

            <?php $form->textInput('shop_name', 'نام شرکت', ['append_icon'=>'mdi-domain'], config('shop-info.shop_name')); ?>

            <?php $form->textInput('boss', 'مدیرعامل شرکت', ['append_icon'=>'mdi-account-tie'], config('shop-info.boss')); ?>

            <?php $form->textInput('login_url', 'آدرس ورود به پنل مدیریت', ['append_icon'=>'mdi-link-variant'], config('shop-info.login_url')); ?>

            <?php $form->textarea('address', 'آدرس شرکت', [], config('shop-info.address')); ?>

            <?php $form->numberInput('postalCode', 'کد پستی شرکت', ['min' => 0,'append_icon'=>'mdi-qrcode-scan'], config('shop-info.postalCode')); ?>

            <?php $form->fileInput('shop_icon', 'لوگو شرکت', []); ?>

            <p class="message_text">برچسب ها با استفاده از (،) از هم جدا شود</p>

            <div style="padding-bottom: 15px">
                <?php $form->tagBox('keywords', 'برچسب ها', [], config('shop-info.keywords')); ?>
            </div>

            <?php $form->textarea(
                'description',
                'توضیحات مختصر در مورد شرکت (حداکثر 150 کاراکتر)',
                ['class' => 'total-width'],
                config('shop-info.description')
            ); ?>

            <?php $form->btn('ثبت اطلاعات', 'create'); ?>

            <?php $form->close(); ?>
        </x-panel-box>


    </div>
@endsection
