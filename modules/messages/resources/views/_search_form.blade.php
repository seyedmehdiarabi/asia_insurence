<?php
$args=[];
$args['title']='جستجو';
?>

<x-panel-box :args="$args">

    <?php
    $u=isset($url) ? $url : "messages";
    $option=['url' => $u,'method'=>'get','class'=>'search_form'];
    $form=new \App\Lib\FormBuilder($option, 'create',[]);
    ?>

    <?php

    $form->textInput('title','عنوان پیام',[],$req->get('title',''));

    $form->btn('جستجو', 'edit');

    $form->close();

    ?>


</x-panel-box>
