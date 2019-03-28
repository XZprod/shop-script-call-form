<?php

class shopOrdercalllocFormValidator
{
    private $errors = [];
    private $fieldsArray = [];
    private $processedData = [];
    const FIELDS_RULES = [
        'name' => 'req,str',
        'phone' => 'req,str',
        'time-from' => 'num',
        'time-to' => 'num',
        'comment' => 'str'
    ];

    public function __construct(array $data)
    {
        $this->fieldsArray = $data;
    }

    public function validate()
    {
        //отрефакторить
        $context = $this;
        $strValidator = function ($str, $field) use ($context) {
            $clean = htmlspecialchars($str);
            $context->addProcessedData($field, $clean);
            return $clean;;
        };
        $reqValidator = function ($str, $field) {
            return mb_strlen($str) > 0;
        };
        $numValidator = function ($str, $field) use ($context) {
            $clean = (int)$str;
            $context->addProcessedData($field, $clean);
            return $clean;
        };
        $func = [
            'str' => $strValidator,
            'req' => $reqValidator,
            'num' => $numValidator,
        ];

        foreach (self::FIELDS_RULES as $field => $rawRules) {
            $value = $this->gv($field);
            if ($value !== null) {
                $rules = explode(',', self::FIELDS_RULES[$field]);
                //array_map()
                foreach ($rules as $rule) {
                    $clearValue = $func[$rule]($value, $field);
                    if ($clearValue === false) {
                        $this->addError([$field => 'Ошибка заполнения поля']);
                    }
                }
            } else {
                $this->addError([$field => 'Это обязательное поле']);
            }
        }

    }

    public function hasErrors()
    {
        return count($this->errors) !== 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }


    public function getData()
    {
        return $this->processedData;
    }


    private function addProcessedData($field, $value)
    {
        $this->processedData[$field] = $value;
    }

    private function addError($err)
    {
        $this->errors[] = $err;
    }

    private function gv($field)
    {
        if (isset($this->fieldsArray[$field])) {
            return $this->fieldsArray[$field];
        }
        return null;
    }


}