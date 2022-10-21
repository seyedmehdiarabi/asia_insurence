<?php $args=['title'=>'جستجو']; ?>

<x-panel-box :args="$args">

    <?php

        $option=['url' => 'products','method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder($option, 'create',[]);

    ?>

    <?php

        $form->textInput('string','عنوان محصول',[],$req->get('string',''));

        $form->select($status,'status','وضعیت محصول',['dense'=>true],$req->get('status'));

        $form->btn('جستجو', 'edit');

        $form->close();

    ?>


</x-panel-box>
