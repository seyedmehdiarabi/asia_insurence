@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb')

{{--        <div class="statistics-admin panel">--}}
{{--            <v-row>--}}
{{--                @include('position_view',['name'=>'admin_banner_index'])--}}
{{--            </v-row>--}}
{{--        </div>--}}


        <v-row style="margin: 0">
            @include('position_view',['name'=>'admin_chart_index'])
        </v-row>

        @include('position_view',['name'=>'admin_panel_index'])

    </div>

@endsection


