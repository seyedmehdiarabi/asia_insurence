<?php
   $args=['title'=>'جستجو'];
?>
<x-panel-box :args="$args">
    <?php
        $option=['url' => 'note','method'=>'get','class'=>'search_form'];
        $form=new \App\Lib\FormBuilder($option, 'create',[]);
    ?>
    <?php
        $form->textInput('title','عنوان یادداشت',[]);
        $form->btn('جستجو', 'edit');
        $form->close();
    ?>
</x-panel-box>
