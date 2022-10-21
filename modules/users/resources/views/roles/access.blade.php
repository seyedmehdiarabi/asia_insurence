@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
     ['title'=>'مدیریت نقش های کاربری','url'=>url('userRole')],
     ['title'=>'تعیین دسترسی های نقش : '.$role->name,'url'=>url('userRole/access/'.$role->id)]
]])
    <?php
        $AccessList = \Modules\users\Models\User::AccessList();
        $args = ['title' => 'تعیین دسترسی های نقش : ' . $role->name];
        ?>

        <x-panel-box :args="$args">
            @include('users::roles._formAccess',['type'=>'create'])
        </x-panel-box>

    </div>

@endsection
