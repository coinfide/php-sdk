<?php

namespace Coinfide\Entity;

use Coinfide\CoinfideException;

abstract class Base
{
    /**
     * @var array
     */
    protected $validationRules = null;

    public function validate()
    {
        if (null === $this->validationRules) {
            throw new CoinfideException('Validation rules must be set for any entity');
        }

        foreach ($this->validationRules as $field => $rule) {
            $value = call_user_func(array($this, 'get'.ucfirst($field)));

            $this->validateValue($field, $value, $rule);
        }
    }

    public function fromArray($array)
    {
        foreach ($this->validationRules as $field => $rule) {
            if (isset($array[$field])) {
                //todo: temporary to affiliate bug
                if ($array[$field] == array() && $rule['type'] == 'object') {
                    continue;
                }

                $setter = 'set' . ucfirst($field);

                call_user_func([$this, $setter], $this->createValue($array[$field], $rule));
            } elseif ($rule['required']) {
                throw new CoinfideException(
                    sprintf(
                        'Required value "%s" for class "%s" is not present in input array with keys "%s"',
                        $field,
                        get_called_class(),
                        implode(', ', array_keys($array)))
                );
            }
        }
    }

    protected function createValue($data, $rule)
    {
        switch ($rule['type']) {
            case 'list':
                $value = [];
                foreach ($data as $item) {
                    $value[] = $this->createValue($item, $rule['prototype']);
                }
                break;
            case 'object':
                $value = new $rule['class']();
                $value->fromArray($data);
                break;
            default:
                $value = $data;
                break;
        }

        return $value;
    }

    public function toArray()
    {
        $data = [];

        foreach ($this->validationRules as $field => $rule) {
            $value = call_user_func(array($this, 'get' . ucfirst($field)));

            if ($value !== null || $rule['required']) {
                switch ($rule['type']) {
                    case 'object':
                        $data[$field] = $value->toArray();
                        break;
                    case 'list':
                        $list = array();

                        foreach ($value as $item) {
                            $list[] = $item->toArray();
                        }

                        $data[$field] = $list;
                        break;
                    default:
                        $data[$field] = $value;
                        break;
                }
            }
        }

        return $data;
    }

    protected function validateValue($field, $value, $rule)
    {
        if ($rule['required'] && is_null($value)) {
            throw new CoinfideException(sprintf('Value for field "%s" is required for class "%s"', $field, get_called_class()));
        }

        if (null === $value) {
            return;
        }

        switch ($rule['type']) {
            case 'string':
                if (!is_null($value)) {
                    if (gettype($value) != 'string') {
                        throw new CoinfideException(sprintf('Provided value is not a string for field "%s" for class "%s"', $field, get_called_class()));
                    }

                    if (isset($rule['min_length']) && strlen($value) < $rule['min_length']) {
                        throw new CoinfideException(sprintf('Value too short for field "%s", at least %d characters required for class "%s"', $field, $rule['min_length'], get_called_class()));
                    }

                    if (isset($rule['max_length']) && strlen($value) > $rule['max_length']) {
                        throw new CoinfideException(sprintf('Value too long for field "%s", at most %d characters allowed for class "%s"', $field, $rule['max_length'], get_called_class()));
                    }
                }

                break;
            case 'object':
                if (!$value instanceof $rule['class']) {
                    throw new CoinfideException(sprintf('Value for field "%s" must be instance of "%s" for class "%s"', $field, $rule['class'], get_called_class()));
                }

                /* @var $value Base */
                $value->validate();
                break;
            case 'date':
                $date = \DateTime::createFromFormat('YmdHis', $value);
                if (false === $date) {
                    throw new CoinfideException(sprintf('Date "%s" does not match format "yyyyMMddHHmmss" for class "%s"', $value, get_called_class()));
                }
                break;
            case 'list':
                if (isset($rule['min_items']) && count($value) < $rule['min_items']) {
                    throw new CoinfideException(sprintf('List in field "%s" should contain at least %d item(s) for class "%s"', $field, $rule['min_items'], get_called_class()));
                }

                foreach ($value as $item) {
                    $this->validateValue($field.'[]', $item, $rule['prototype']);
                }
                break;
            case 'integer':
                if (!is_numeric($value) || round($value) != $value) {
                    throw new CoinfideException(sprintf('Value "%s" for field "%s" is not integer for class "%s"', $value, $field, get_called_class()));
                }

                break;
            case 'decimal':
                if (!is_numeric($value)) {
                    throw new CoinfideException(sprintf('Value "%s" for field "%s" is not numeric for class "%s"', $value, $field, get_called_class()));
                }

                $parts = explode('.', $value);

                if (isset($rule['digits']) && strlen($parts[0]) > $rule['digits']) {
                    throw new CoinfideException(sprintf('Value "%s" for field "%s" contains too many digits, only %d is allowed for class "%s"', $value, $field, $rule['digits'], get_called_class()));
                }

                if (isset($rule['precision']) && isset($parts[1]) && strlen($parts[1]) > $rule['precision']) {
                    throw new CoinfideException(sprintf('Value "%s" for field "%s" has too high precision, only %d digits allowed for class "%s"', $value, $field, $rule['precision'], get_called_class()));
                }

                break;
            case 'boolean':
                if ($value !== false && $value !== true) {
                    throw new CoinfideException(sprintf('Value "%s" for field "%s" for class must be either "true" or "false"', $value, $field, get_called_class()));
                }
                break;
            default:
                throw new CoinfideException(sprintf('Valdation type "%s" unknown for class "%s"', $rule['type'], get_called_class()));
                break;
        }
    }
}
