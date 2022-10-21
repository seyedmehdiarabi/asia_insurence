<?php
$option=['url' => 'category','files'=>true];
$data=isset($category) ? $category : [];
$form=new \App\Lib\FormBuilder($option, $type,$data);
?>

<?php $form->textInput('name','نام دسته',['validate'=>'required']); ?>

<?php $form->textInput('ename','نام انگلیسی دسته ',[]); ?>

<?php $form->select($catList,'parent_id','انتخاب سردسته',[]); ?>

<?php $form->btn( $type=='create' ? 'ثبت دسته' : 'ویرایش دسته', $type); ?>

<?php $form->close() ?>
