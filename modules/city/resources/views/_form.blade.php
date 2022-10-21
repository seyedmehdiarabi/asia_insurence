<?php
$option=['url' => 'admin/city'];
$data=isset($city) ? $city : [];
$form=new \App\Lib\FormBuilder($option, $type,$data);
?>

<?php $form->textInput('name','نام شهر',['validate'=>'required']); ?>

<?php $form->select($province,'province_id','انتخاب استان',['validate'=>'required']); ?>

<?php $form->btn( $type=='create' ? 'ثبت' : 'ویرایش ', $type); ?>

<?php $form->close(); ?>
