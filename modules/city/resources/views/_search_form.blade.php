<?php
   $args=[];
   $args['title']='جستجو';
?>

<x-panel-box :args="$args">

    <?php
        $option=['url' => 'admin/city','method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder($option, 'create',[]);
    ?>

    <?php

        $form->textInput('string','نام شهر',[],$req->get('string',''));

        $form->btn('جستجو', 'edit');

        $form->close();

    ?>


</x-panel-box>
