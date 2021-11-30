<?php

class Request {
    private $_input = [];
    private $_post = [];
    private $_status = [];

    public function __construct() {
        $this->_input = $_GET;
        $this->_post = $_POST;
    }

    public function input($key = ''){
        if(empty($key)) {
            return $this->_input;
        } else if(!isset($this->_input[$key])) {
            return '';
        } else {
            return $this->_input[$key];
        }
    }

    public function post($key = ''){
        if(empty($key)) {
            return $this->_post;
        } else if(!isset($this->_post[$key])) {
            return '';
        } else {
            return $this->_post[$key];
        }
    }

    public function status($value = '') {
        if(empty($value)) {
            if(empty($this->_status)) {
                $this->_status = 200;
            }
        } else {
            $this->_status = $value;
        }
        return $this->_status;
    }

    public function is_api() {
        return substr($this->input('route'), 0, 4) === 'api/';
    }
}