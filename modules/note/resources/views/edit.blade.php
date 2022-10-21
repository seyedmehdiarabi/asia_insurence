@extends('backend-theme::layout')

@section('content')
    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت یادداشت‌ها','url'=>url('note')],
            ['title'=>'ویرایش یادداشت','url'=>'note'.$note->id]
        ]])
        <?php
        $args=['title'=>'ویرایش یادداشت'];
        ?>
        <x-panel-box :args="$args">
            @include('note::_form',['type'=>'edit'])
        </x-panel-box>
    </div>
@endsection
