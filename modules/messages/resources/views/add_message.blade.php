@extends('backend-theme::layout')

@section('content')

    <div>


        <?php
            $array['users']= 'مدیریت کاربران';
            $array['sellers']= 'مدیریت فروشندگان';
        ?>
        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>$array[$url_param],'url'=>url($url_param)],
             ['title'=>'مدیریت پیام ها','url'=>url($url_param.'/'.$user->id.'/messages')],
             ['title'=>'ارسال پیام جدید','url'=>url($url_param.'/'.$user->id.'/messages/create')],
        ]])

        <?php
            $attr=$types[$type]['attr'];
            $args=[];
            $name=$user->$attr!='' ? $user->$attr : $user->mobile;
        ?>

        <x-panel-box :args="$args">

            <x-slot name="header">
                ارسال پیام به
                {{ $name }}
            </x-slot>

            <?php
                 $option=['url'=>$url_param.'/'.$user->id.'/messages'];
                 $form=new \App\Lib\FormBuilder($option,'create',[]);
            ?>

            <?php $form->textInput('title','عنوان پیام ',['class'=>'total-width','validate'=>'required']); ?>

            <?php $form->textarea('content','محتوای پیام ',['class'=>'total-width','validate'=>'required']); ?>

            <?php $form->fileInput('pic','انتخاب فایل ',['style'=>"direction:ltr"]); ?>

            <?php $form->btn('ارسال پیام', 'create'); ?>

            <?php $form->close(); ?>

        </x-panel-box>
    </div>

@endsection
