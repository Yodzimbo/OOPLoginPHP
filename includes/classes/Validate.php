<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 02.12.2017
 * Time: 12:56
 */

class Validate {
    private $_passed = false,
            $_errors = array(),
            $_db     = null;

    public function __construct(){
        $this->_db = DataBase::getInstance();
    }

    public function check($source, $items = array()){
        foreach ($items as $item => $rules){
            foreach ($rules as $rule => $rule_value){

                //echo "{$item} {$rule} musi być {$rule_value}<br>";/quick validation test

                $value = trim($source[$item]);
                $item = escape($item);

                if($rule === 'required' && empty($value)){
                    $this->addError("{$item} jest wymagany");
                } else if(!empty($value)){
                    switch ($rule){
                        case 'min':
                            if(strlen($value) < $rule_value){
                                $this->addError("{$item} musi zawierać więcej niż {$rule_value} znaki.");
                            }
                        break;
                        case 'max':
                            if(strlen($value) > $rule_value){
                                $this->addError("{$item} musi zawierać mniej niż {$rule_value} znaki.");
                            }
                        break;
                        case 'matches':
                            if($value != $source[$rule_value]){
                                $this->addError("{$rule_value} musi być identyczny z {$item}");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()){
                                $this->addError("Ten {$item} już istnieje");
                            }
                        break;
                    }
                }
            }
        }
        if(empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error){
        $this->_errors[] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }
}