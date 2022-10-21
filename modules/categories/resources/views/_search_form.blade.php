<?php
  $args=['title'=>'جستجو'];
?>


<x-panel-box :args="$args">

    <?php
       $option=['url'=>'category','method'=>'get','class'=>'search_form'];
       $form=new \App\Lib\FormBuilder($option,'create',[])
    ?>

    <?php

         $form->textInput('string','نام دسته',[],$req->get('string',''));

         $form->btn('جستجو','edit');

         $form->close();

    ?>

</x-panel-box>
