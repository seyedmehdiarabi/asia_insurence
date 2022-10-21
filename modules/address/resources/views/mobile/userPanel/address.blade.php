@extends('front-theme::layouts.mobile.user-panel')

@section('panel-content')

    <?php $args=['title'=>'آدرس ها'] ?>

    <x-user-panel-box :args="$args">
        <profile-address :layout="'mobile'"></profile-address>
    </x-user-panel-box>

@endsection

