<?php
$option=['url' => 'admin/province'];

$data=isset($province) ? $province : [];
$form=new \App\Lib\FormBuilder($option, $type,$data);
?>

<?php $form->textInput('name','نام استان ',['validate'=>'required']); ?>


<?php $form->btn( $type=='create' ? 'ثبت استان' : 'ویرایش استان', $type); ?>

<?php $form->close(); ?>
