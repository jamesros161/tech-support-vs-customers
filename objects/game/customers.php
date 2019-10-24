<?php
// 'user' object

class Customer{
 
    // object properties
    public $name;
    public $level;
    public $proficiency;
    public $chp;
    public $ihp;
    public $stance;

    // constructor
    public function __construct($agent_level){
        $this->name = $this->getName();
        $this->level = $agent_level;
        $this->proficiency = 0;
        $this->chp = 100 + (($this->level - 1) * 10);
        $this->ihp = 100 + (($this->level - 1) * 10);
        $this->stance = 'content';
    }
    function getName() {
        $name_list = array(
            'Arie Emrick','Freddie Christensen','Tana Guffey','Ivy Messerly','Fernanda Dubon','Sharan Lewellyn',
            'Debbi Fleckenstein','Elaina Godfrey','Andres Silvas','Salley Frey','Rigoberto Kyger','Demarcus Overbeck',
            'Walker Machado','Maritza Soder','Dewitt Vasser','Williemae Sterling','Theron Terlizzi','Sherwood Norby',
            'Pilar Farnes','Hung Simington','Fern Herbst','Federico Pina','Sergio Witherite','Damien Maricle','Kathryn Slaybaugh',
            'Loreta Krieg','Bella Smalley','Kerri Kanner','Kenneth Fennell','Antonietta Swopes','Natividad Hamernik',
            'Patria Bosarge','Jada Alward','Dwayne Thibodeaux','Sebrina Slifer','Erin Hiebert','Winter Abarca','Ailene Casto',
            'Pa Tootle','Sari Carver','Alease Swiney','Neida Loth','Shantel Peters','Audrie Pillot','Jeanie Rooney',
            'Lou Rudolph','Erline Defeo','Percy Mclin','Eleonor Straub','Loriann Letarte');
        $names_count = count($name_list);
        $name_no = rand(0,($names_count - 1));
        return $name_list[$name_no];
    }
}