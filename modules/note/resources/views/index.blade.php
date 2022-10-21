@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت یادداشت‌ها','url'=>url('note')]]])

        @include('note::_search_form')

        <?php
        $args = [];
        $args['title'] = 'مدیریت یادداشت‌ها';
        $args['route'] = 'note';
        $args['trashCount'] = $trash_note_count;
        $args['routeParam'] = 'یادداشت';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider' => $note,
                'columns' => [
                    ['label' => 'عنوان', 'attr' => function ($model) {
                        return $model->title;
                    }],
                    ['label' => 'تاریخ یادآوری', 'attr' => function ($model) {
                        return get_calendar($model->date,true);
                    }],
                ],
                'route_param' => 'note',
                'tableLabel' => 'یادداشت',
                'actions' => [
                    function ($model) {
                        $url = url('note/' . $model->id);
                        return ' <a href="' . $url . '" class="router-link"> <v-icon>mdi-eye</v-icon> </a> &nbsp; ';
                    }
                ],
            ]);
            ?>

            {{ $note->links() }}

        </x-panel-box>

    </div>

@endsection
