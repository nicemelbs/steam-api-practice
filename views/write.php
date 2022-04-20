<?php

use app\core\forms\Button;
use app\core\forms\Form;
use app\core\forms\InputField;
use app\core\forms\TextAreaField;

?>

    <h1>What's happening?</h1>
<?php
$form = Form::begin('', 'post');
echo new InputField($model, 'title');
echo new TextAreaField($model, 'body');
echo new Button($model, 'submit', 'Publish');

Form::end();
?>