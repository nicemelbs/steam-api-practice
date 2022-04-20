<h1>Create an account</h1>

<?php

use app\core\forms\Button;
use app\core\forms\Form;
use app\core\forms\InputField;

?>

<?php $form = Form::begin('', 'post'); ?>
<div class="row">
    <div class="col">
        <?php echo new InputField($model, 'firstname'); ?>
    </div>
    <div class="col">
        <?php echo new InputField($model, 'lastname'); ?>
    </div>
</div>
<?php
echo new InputField($model, 'email', InputField::TYPE_EMAIL);
echo new InputField($model, 'password', InputField::TYPE_PASSWORD);
echo new InputField($model, 'passwordConfirm', InputField::TYPE_PASSWORD);
echo new Button($model, 'submit', 'Register');
Form::end();
?>
