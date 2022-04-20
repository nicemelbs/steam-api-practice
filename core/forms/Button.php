<?php

namespace app\core\forms;

class Button extends BaseField
{
    private string $label;

    public function __construct($model, $attribute, $label = null)
    {
        $this->label = $label ?? 'Submit';
        parent::__construct($model, $attribute);
    }

    public function renderInput(): string
    {
        return '<button type="submit" class="btn btn-primary">' . $this->label . '</button>';
    }

    public function __toString()
    {
        $html = '<div class="form-group">' . $this->renderInput() . '</div>';
        return $html;
    }
}