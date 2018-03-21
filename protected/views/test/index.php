<?php

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true,),
    //'action'=>array('test/index'),
    'htmlOptions'=>array( 'enctype'=>'multipart/form-data'),
));

?>


<div>
    <span><?php echo $form->label($userAdmin, 'account') ?>:</span>
    <?php
       echo $form->textField($userAdmin,'account');
       echo $form->error($userAdmin, 'account');
    ?>
</div>

<div>
    <span><?php echo $form->label($userAdmin, 'password') ?>:</span>
    <?php
       echo $form->passwordField($userAdmin,'password');
       echo $form->error($userAdmin, 'password');
    ?>
</div>

<div>
    <input type="submit" value="提交">
</div>
<?php
$this->endWidget();
?>







