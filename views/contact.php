<?php

use app\core\forms\Button;
use app\core\forms\Form;
use app\core\forms\InputField;
use app\core\forms\TextAreaField;
use app\core\Model;

/**
 * @var $model Model
 */

$this->title = 'Contact Us';
?>
    <h1>Contact us page</h1>

<?php
$form = Form::begin('', 'post');
echo new InputField($model, 'subject');
echo new InputField($model, 'email', InputField::TYPE_EMAIL);
echo new TextAreaField($model, 'body');
echo new InputField($model, 'date', InputField::TYPE_DATE,);
echo new InputField($model, 'time', InputField::TYPE_TIME);
echo new Button($model, 'submit', 'Send');
Form::end();
?>