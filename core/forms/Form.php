<?php

namespace app\core\forms;

use app\core\Model;

class Form
{

    public static function begin($action, $method, $options = [])
    {
        $options['action'] = $action;
        $options['method'] = $method;
        $html = '<form';
        foreach ($options as $name => $value) {
            $html .= " $name=\"$value\"";
        }
        $html .= '>';
        echo $html;
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute): InputField
    {
        return new InputField($model, $attribute);
    }

}