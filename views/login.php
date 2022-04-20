<?php

use app\core\forms\Button;
use app\core\forms\Form;
use app\core\forms\InputField;

/**
 * @var $model \app\core\forms\User
 */

$this->title = 'Login';

?>
    <h1>Log in</h1>
<?php
$form = Form::begin('', 'post');
echo new InputField($model, 'email', InputField::TYPE_EMAIL);
echo new InputField($model, 'password', InputField::TYPE_PASSWORD);
echo new Button($model, 'submit', 'Log in');
Form::end();
?>