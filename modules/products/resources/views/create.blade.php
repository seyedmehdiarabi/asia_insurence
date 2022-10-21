@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('products')],
            ['title'=>'افزودن محصول جدید','url'=>url('products/create')]
        ]])

        <?php $args['title']='افزودن محصول جدید'; ?>
        <x-panel-box :args="$args">
            @include('products::_form',['type'=>'create'])
        </x-panel-box>

    </div>

@endsection

