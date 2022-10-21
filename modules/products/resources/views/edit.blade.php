@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('products')],
             ['title'=>'ویرایش محصول','url'=>url('products/'.$product->id.'/edit')]
        ]])

        <?php $args['title']='ویرایش محصول - '.e($product->title); ?>
        <x-panel-box :args="$args">
            @include('products::_form',['type'=>'edit'])
        </x-panel-box>


    </div>



@endsection

