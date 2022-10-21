@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت یادداشت‌ها','url'=>url('note')],
            ['title'=>'افزودن یادداشت جدید','url'=>'note/create']
        ]])

        <?php
        $args=['title'=>'افزودن یادداشت جدید'];
        ?>

        <x-panel-box :args="$args">
            @include('note::_form',['type'=>'create'])
        </x-panel-box>

    </div>

@endsection

