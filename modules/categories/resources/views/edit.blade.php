@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت دسته ها','url'=>url('category')],
           ['title'=>'ویرایش دسته','url'=>url('category/'.$category->id.'/edit')]
      ]])

        <?php
        $args=[];
        $args['title']='ویرایش دسته بندی - '.e($category->name);
        ?>

        <x-panel-box :args="$args">
            @include('categories::_form',['type'=>'edit'])
        </x-panel-box>

    </div>
@endsection
