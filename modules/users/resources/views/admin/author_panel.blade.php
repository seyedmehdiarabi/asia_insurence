@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb')
        <?php $args = ['title' => 'اعلانات'] ?>
        <x-panel-box :args="$args">
            <v-alert border="bottom" color="pink darken-1" type="error">
                <p>
                    <span>{{ Auth::user()->name }} عزیز </span>
                    <span>تمامی وظایفی که توسط شما در این سامانه تعریف می شوند، باید توسط خود شما پیگیری شود، مگر اینکه آن وظیفه را به کارشناس دیگری ارجاع دهید!</span>
                </p>
            </v-alert>

        </x-panel-box>

        @include('position_view',['name'=>'admin_author_panel'])

    </div>
@endsection
