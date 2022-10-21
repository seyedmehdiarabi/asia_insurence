<?php
$args = ['title' => 'یادداشت های من'];

?>
<x-panel-box :args="$args">

    <?php
    \App\Lib\GridView::showTable([
        'dataProvider' => $notes,
        'columns' => [
            ['label' => ' کارشناس', 'attr' => function($model){
                return getUserNmae($model->user_id);
            }],
            ['label' => ' شرح', 'attr' => 'description'],
            ['label' => 'تاریخ یادآوری', 'attr' => function ($model) {
                return get_calendar($model->date);
            }],
            ['label' => 'عملیات', 'attr' => function ($model) {
                $url = url('note/' . $model->id.'/edit');
                return ' <a href="' . $url . '" class="router-link"> <v-icon color="primary">mdi-apple-finder</v-icon> </a> &nbsp; ';;
            }]
        ]
    ], true, true);
    ?>

</x-panel-box>
