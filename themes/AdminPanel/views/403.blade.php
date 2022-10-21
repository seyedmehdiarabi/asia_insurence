@extends('backend-theme::layout')
@section('content')
    <div>
        <?php $args = ['title'=>'شما دسترسی لازم به این صفحه را ندارید!'] ?>
        @include('backend-theme::breadcrumb')
        <x-panel-box :args="$args">
            <v-container>
                <v-row>
                    <v-col>
                        <div class="erorr_box text-center" style=" width: 35%;margin: auto;">
                            <img src="{{asset('files/images/403.svg')}}" alt="">
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </x-panel-box>
    </div>
@endsection
