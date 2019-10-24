<?php
namespace Game\Objects;

class Contact{
    public $customer;
    public $customer_name;
    public $issue;
    public $issue_string;
    public $category;
    public $turn = 1;
    public $aht;
    public $hmp;
    public $chp;
    public $ihp;
    public $stance;
    public $cx_proficiency;
    
    public function __construct(){
        $db = new \Game\Config\Database();
        $this->agent = new Agent($db->getConnection());
        $this->agent->playerAgentExists();
        $this->agent_name = $this->agent->firstname;
        $this->customer = new Customer($this->agent->level);
        $this->customer_name = $this->customer->name;
        $this->issue = new Issue();
        $this->issue_string = $this->issue->string;
        $this->category = $this->issue->category;
        $this->aht = $this->agent->aht;
        $this->hmp = $this->agent->hmp;
        $this->chp = $this->customer->chp;
        $this->ihp = $this->customer->ihp;
        $this->cx_stance = $this->customer->stance;
        $this->cx_proficiency = $this->customer->proficiency;
        
    }
    
    public function contact_display_data() {
        return array(
            'Agent Name: ' => $this->agent_name,
            'Customer Name: ' => $this->customer_name,
            'Issue: ' => $this->issue_string,
            'Category: ' => $this->category,
            'AHT: ' => $this->aht,
            'HMP: ' => $this->hmp,
            'Customer HP: ' => $this->chp,
            'Issue HP: ' => $this->ihp
            );
    }
}