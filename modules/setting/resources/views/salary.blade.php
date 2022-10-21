@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'تنظیمات جدول حقوق و دستمزد','url'=>url('setting/salary')],]])

        <?php $args = ['title' => ' جدول حقوق و دستمزد']; ?>

        <x-panel-box :args="$args">

            <?php
            $option = ['url' => 'setting/salary'];
            $form = new \App\Lib\FormBuilder($option);
            ?>

            <?php $form->numberInput('min_salary', 'حداقل دستمزد روزانه', ['min' => 0, 'append_icon' => 'mdi-currency-rial'], config('salary-info.min_salary')); ?>

            <?php $form->numberInput('food_coupon', 'بن خواروبار', ['min' => 0, 'append_icon' => 'mdi-currency-rial'], config('salary-info.food_coupon')); ?>

            <?php $form->numberInput('house_coupon', 'بن مسکن', ['min' => 0, 'append_icon' => 'mdi-currency-rial'], config('salary-info.house_coupon')); ?>

            <?php $form->numberInput('years', 'سنوات (روزانه)', ['min' => 0, 'append_icon' => 'mdi-currency-rial'], config('salary-info.years')); ?>

            <?php $form->numberInput('child', 'حق اولاد ', ['min' => 0, 'append_icon' => 'mdi-currency-rial'], config('salary-info.child')); ?>

            <?php $form->numberInput('min_reward', 'عیدی', ['min' => 0, 'append_icon' => 'mdi-currency-rial'], config('salary-info.min_reward')); ?>

            <?php $form->numberInput('bonuses', 'پاداش', ['min' => 0, 'append_icon' => 'mdi-currency-rial'], config('salary-info.bonuses')); ?>

            <?php $form->btn('ثبت اطلاعات', 'create'); ?>

            <?php $form->close(); ?>
        </x-panel-box>


    </div>
@endsection
