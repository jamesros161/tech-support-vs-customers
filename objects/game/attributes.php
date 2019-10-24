<?php

class Attribute {
    public $attr_name;
    public $value;
    public $skill_names;
    
    function __construct($attr_name, $value, $skill_names) {
        $this->attr_name = $attr_name;
        $this->value = $value;
        $this->skill_names = array();
        foreach ($skill_names as $skill_name => $values) {
            array_push($this->skill_names, $skill_name);
            $this->{$skill_name} = $values;
        }
    }
    
    function get_skill_val($skill)  {
        return $this->{$skill}[1];
    }
    
    function get_skill_display_name($skill) {
        return $this->$skill[0];
    }
}