<?php

namespace Game\Objects;

class Attacks{
    public $attack_list;
    public $hold;
    public $flattery;
    public $threaten;
    public $disarm;
    public $make_a_ticket;
    public $anything_else;
    public $oos;
    public $tos;
    public $apologize;
    public $reaffirm;
    public $types;

    public function __construct(){
        $this->attack_list = array(
            'hold','flattery','threaten','disarm',
            'make_a_ticket','anything_else','oos','tos'
            );
        $this->save_list = array('apologize', 'reaffirm');
        $this->types = array(
            'aht_restore'=>'AHT Restore',
            'cx_debuff'=>'Cx Debuff',
            'closer'=>'Closer',
            'instant_ko'=>'Instant KO'
            );
        
        $this->hold = new Attack(
            'Restores AHT based on your Contact Control Skill',
            '3 to 5 Minute Hold', 'hold',
            'aht_restore', 'contact_control', 10, array(
                'success'=> array(
                    'affected_stats'=>array('aht'),
                    'base_amt'=>10,
                    'mult_type'=>'base+mult',
                    'multiplier'=>10
                    ),
                'fail'=> array(
                    'affected_stats'=>array('aht'),
                    'base_amt'=>10,
                    'mult_type'=>'base-mult',
                    'multiplier'=>1
                    )
                )
            );
        $this->flattery = new Attack(
            'Restores both AHT and Cx HP based on your Charm Skill',
            'Flattery', 'flattery',
            'aht_restore', 'charm', 10, array(
                'success'=> array(
                    'affected_stats'=>array('aht','chp'),
                    'base_amt'=>20,
                    'mult_type'=>'base+mult',
                    'multiplier'=>10
                    ),
                'fail'=> array(
                    'affected_stats'=>array('aht'),
                    'base_amt'=>20,
                    'mult_type'=>'base-mult',
                    'multiplier'=>'10'
                    )
                )
            );
        $this->threaten = new Attack(
            'Reduces Cx Proficiency based on Confidence, but VERY risky',
            'Threaten', 'threaten',
            'cx_debuff', 'confidence', 10, array(
                'success'=> array(
                    'affected_stats'=>array('cx_proficiency'),
                    'base_amt'=>1,
                    'mult_type'=>'sub-mult',
                    'multiplier'=>1
                    ),
                'fail'=> array(
                    'affected_stats'=>array('aht'),
                    'base_amt'=>100,
                    'mult_type'=>'sub-percent',
                    'multiplier'=>'none'
                    )
                )
            );
        $this->disarm = new Attack(
            'Removes any Cx Proficiency bonuses',
            'Disarm', 'disarm',
            'cx_debuff', 'de_escalation', 10, array(
                'success'=> array(
                    'affected_stats'=>array('cx_proficiency'),
                    'base_amt'=>0,
                    'mult_type'=>'reduce-absolute',
                    'multiplier'=>'none'
                    ),
                'fail'=> array(
                    'affected_stats'=>array('cx_proficiency'),
                    'base_amt'=>1,
                    'mult_type'=>'stat+base',
                    'multiplier'=>'none'
                    )
                )
            );
        $this->make_a_ticket = new Attack(
            'Closes Contact. Requires the Issue HP be within a threshold based on Confidence',
            'Make A Ticket', 'make_a_ticket',
            'closer', 'confidence', 10, array(
                'success'=> array(
                    'affected_stats'=>array('chp'),
                    'base_amt'=>0,
                    'mult_type'=>'reduce-absolute',
                    'multiplier'=>'none'
                    ),
                'fail'=> array(
                    'affected_stats'=>array('aht'),
                    'base_amt'=>20,
                    'mult_type'=>'sub-base',
                    'multiplier'=>'none'
                    ),
                'requires'=> array(
                        'stat'=>'ihp',
                        'base_amt'=>10,
                        'mult_type'=>'less-base*mult',
                        'multiplier'=>'1'
                    )
                )
            );
        $this->anything_else = new Attack(
            'Closes Contact. Requires Issue HP be within a threshold based on Contact Control',
            'Is There Anything Else?', 'anything_else',
            'closer', 'contact_control', 10, array(
                'success'=> array(
                    'affected_stats'=>array('chp'),
                    'base_amt'=>0,
                    'mult_type'=>'absolute',
                    'multiplier'=>'none'
                    ),
                'fail'=> array(
                    'affected_stats'=>array('aht'),
                    'base_amt'=>20,
                    'mult_type'=>'sub-base',
                    'multiplier'=>'none'
                    ),
                'requires'=> array(
                        'stat'=>'ihp',
                        'base_amt'=>10,
                        'mult_type'=>'less-base*mult',
                        'multiplier'=>'1'
                    )
                )
            );
        $this->oos = new Attack(
            'Instantly KOs Cx based on Charm skill, but at the risk of loosing the contact',
            'Out of Scope', 'oos',
            'instant_ko', 'charm', 10, array(
                'success'=> array(
                    'affected_stats'=>array('chp'),
                    'base_amt'=>0,
                    'mult_type'=>'reduce-absolute',
                    'multiplier'=>'none'
                    ),
                'fail'=> array(
                    'affected_stats'=>array('aht'),
                    'base_amt'=>100,
                    'mult_type'=>'sub-percent',
                    'multiplier'=>'none'
                    )
                )
            );
        $this->tos = new Attack(
            'Instantly KOs Cx based on Confidence skill, but at risk of loosing the contact',
            'ToS Violation', 'tos',
            'instant_ko', 'confidence', 10, array(
                'success'=> array(
                    'affected_stats'=>array('chp'),
                    'base_amt'=>0,
                    'mult_type'=>'reduce-absolute',
                    'multiplier'=>'none'
                    ),
                'fail'=> array(
                    'affected_stats'=>array('aht'),
                    'base_amt'=>100,
                    'mult_type'=>'sub-percent',
                    'multiplier'=>'none'
                    )
                )
            );
        $this->apologize = new Attack(
            'Reduces damage from failed attack based on Charm Skill',
            'Apologize', 'apologize',
            'save_skill', 'charm', 10, array(
                'success'=> array(
                    'affected_stats'=>array('chp'),
                    'base_amt'=>2,
                    'mult_type'=>'stat/prof',
                    'multiplier'=>'none'
                    ),
                'fail'=> array(
                    'affected_stats'=>array('current_stance'),
                    'base_amt'=>0,
                    'mult_type'=>'roll-stance',
                    'multiplier'=>'none'
                    )
                )
            );
        $this->reaffirm = new Attack(
            'Reduces damage from failed attack based on Confidence Skill',
            'Apologize', 'reaffirm',
            'save_skill', 'confidence', 10, array(
                'success'=> array(
                    'affected_stats'=>array('chp'),
                    'base_amt'=>2,
                    'mult_type'=>'stat/prof',
                    'multiplier'=>'none'
                    ),
                'fail'=> array(
                    'affected_stats'=>array('current_stance'),
                    'base_amt'=>0,
                    'mult_type'=>'roll-stance',
                    'multiplier'=>'none'
                    )
                )
            );
    }
    
    public function get_available($contact){
        $aht = intval($contact->aht);
        $hmp = intval($contact->hmp);
        $chp = intval($contact->chp);
        $ihp = intval($contact->ihp);
        $cx_proficiency = intval($contact->cx_proficiency);
        
        $available_attacks = array();
        if ( $hmp >= 10 ) {
            foreach ($this->attack_list as $attack) {
                array_push($available_attacks, $this->{$attack});
            }
            
        }
        return $available_attacks;
    }
}

class Attack{
    public $desc;
    public $type;
    public $name;
    public $display_name;
    public $skill;
    public $cost;
    public $effects;
    
    public function __construct($desc, $display_name, $name, $type, $skill, $cost, $effects){
        $this->desc = $desc;
        $this->type = $type;
        $this->name = $name;
        $this->display_name = $display_name;
        $this->skill = $skill;
        $this->cost = $cost;
        $this->effects = $effects;
    }
}