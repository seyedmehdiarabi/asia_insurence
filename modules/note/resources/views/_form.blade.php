<?php
$option=['url' => 'note'];
$data= $note ?? [];
$form=new \App\Lib\FormBuilder($option, $type,$data);
?>

<?php $form->textInput('title','عنوان یادداشت',['validate'=>'required']); ?>

<?php $form->dateInput('date','تاریخ یادآوری',['validate'=>'required']);?>

<?php $form->textarea('description','توضیحات',[]); ?>

<?php $form->checkbox('status', 'دیگر یادآوری نشود!'); ?>

<?php $form->btn( $type=='create' ? 'ثبت' : 'ویرایش ', $type); ?>

<?php $form->close(); ?>
