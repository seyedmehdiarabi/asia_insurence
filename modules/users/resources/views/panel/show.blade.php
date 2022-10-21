@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت کاربران','url'=>url('users')],
             ['title'=>'جزییات اطلاعات کاربر','url'=>url('users/'.$user->id)],
        ]])

        <?php
        $ceremonial = CeremonialTitle() [0];
        $info = personal_user_detail($additionalInfo);
        $result = $user->attributesToArray();
        ?>

        <user-info
            user_info="{{json_encode($result)}}"
            additional_info="{{json_encode($info)}}"
            count="{{sizeof($info)}}"
            ceremonial="{{$ceremonial}}"
        >
        </user-info>

    </div>

@endsection


