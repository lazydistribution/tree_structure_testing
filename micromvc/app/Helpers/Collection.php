<?php

class Collection 
{
    private $_array;
    public function __construct($array) {
        $this->_array = $array; 
    }

    public function fields($fields) {
        $output = [];
        foreach($fields as $search_field) {
            foreach($this->_array as $key => $value) {
                if($search_field == $key) {
                    $output[$key] = $value;
                }
            }
        }
        return $output;
    }

    public function get($id, $params = []) {
        $item = isset($this->_array[$id]) ? $this->_array[$id] : [];
        tulosta($item);
        if(!empty($item) && isset($params['fields'])) {
            $item = new Collection($item);
            //tapa($item);
            $item = $item->fields($params['fields']);
        }
        return $item;
    }

    public function data() {
        return $this->_array;
    }
}