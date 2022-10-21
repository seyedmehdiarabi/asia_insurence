@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'تنظیمات کارگاه','url'=>url('setting/workshop')],]])

        <?php $args = ['title' => 'تنظیمات کارگاه']; ?>
        <x-panel-box :args="$args">

            <?php
            $option = ['url' => 'setting/workshop'];
            $form = new \App\Lib\FormBuilder($option);
            ?>

            <?php $form->textInput('name', 'نام کارگاه', ['append_icon'=>'mdi-domain'], config('workshop-info.name')); ?>

            <?php $form->textInput('employer', 'نام کارفرما', ['append_icon'=>'mdi-account-tie'], config('workshop-info.employer')); ?>

            <?php $form->numberInput('id_insurance', 'شماره کارگاه بیمه', ['min' => 0,'append_icon'=>'mdi-numeric'], config('workshop-info.id_insurance')); ?>

            <?php $form->numberInput('percent_insurance', 'درصد حق بیمه سهم کارفرما', ['min' => 0, 'append_icon' => 'mdi-percent-outline'], config('workshop-info.percent_insurance')); ?>

            <?php $form->btn('ثبت اطلاعات', 'create'); ?>

            <?php $form->close(); ?>
        </x-panel-box>


    </div>
@endsection
