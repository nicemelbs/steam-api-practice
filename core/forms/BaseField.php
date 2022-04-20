<?php

namespace app\core\forms;

use app\core\Model;

abstract class BaseField
{
    protected Model $model;
    protected string $attribute;

    abstract public function renderInput(): string;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label for="%s">%s</label>
                %s
            </div>
        <div class="invalid-feedback d-block">%s</div>',
            $this->attribute,
            $this->model->labels()[$this->attribute] ?? $this->attribute,
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}