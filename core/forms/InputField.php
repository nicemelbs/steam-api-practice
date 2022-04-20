<?php

namespace app\core\forms;

use app\core\Model;

class InputField extends BaseField
{

    public string $type;

    public const TYPE_BUTTON = 'button';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_COLOR = 'color';
    public const TYPE_DATE = 'date';
    public const TYPE_DATETIME_LOCAL = 'datetime-local';
    public const TYPE_EMAIL = 'email';
    public const TYPE_FILE = 'file';
    public const TYPE_HIDDEN = 'hidden';
    public const TYPE_IMAGE = 'image';
    public const TYPE_MONTH = 'month';
    public const TYPE_NUMBER = 'number';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_RADIO = 'radio';
    public const TYPE_RANGE = 'range';
    public const TYPE_RESET = 'reset';
    public const TYPE_SEARCH = 'search';
    public const TYPE_SUBMIT = 'submit';
    public const TYPE_TEL = 'tel';
    public const TYPE_TEXT = 'text';
    public const TYPE_TIME = 'time';
    public const TYPE_URL = 'url';
    public const TYPE_WEEK = 'week';

    protected array $options;

    public function __construct(Model $model, string $attribute, string $type = self::TYPE_TEXT, $options = [])
    {
        $this->type = $type;
        $this->options = $options;
        parent::__construct($model, $attribute);
    }

    public function renderInput(): string
    {
        return sprintf('  <input type="%s" class="form-control %s" id="%s" name="%s" value="%s" %s>',
            $this->type,
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->attribute,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->renderOptions()
        );

    }

    //bug: if $this->options has a key of type, class, id, name or value
    //they won't be overriden by the input field as they are already set
    private function renderOptions(): string
    {
        $options = '';
        foreach ($this->options as $key => $value) {
            $options .= sprintf('%s="%s" ', $key, $value);
        }

        return $options;
    }
}