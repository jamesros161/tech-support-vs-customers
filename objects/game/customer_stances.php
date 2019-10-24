<?php
namespace Game\Objects;

class CustomerStances{
    public $stance_list;
    public $angry;
    public $impatient;
    public $scared;
    public $confused;
    public $stupid;
    public $content;

    public function __construct(){
        $this->$stance_list = array(
            'angry','impatient','scared','confused',
            'stupid','content'
            );
        $this->angry = new Stance(
            '1', 'angry', 'Angry', 'rollvroll',
            $this->getResponses('angry'),
            array(
                'success' => array('cx_proficiency', 1),
                'fail' => null
                )
            );
            
        $this->impatient = new Stance(
            '2', 'impatient', 'Impatient', 'rollvroll',
            $this->getResponses('impatient'),
            array(
                'success' => array('ahtcost', 10),
                'fail' => null
                )
            );
            
        $this->scared = new Stance(
            '3', 'scared', 'Scared', 'evenodd',
            $this->getResponses('scared'),
            array(
                'success' => array('cx_proficiency', 1),
                'fail' => array('cx_proficiency', -1)
                )
            );
            
        $this->confused = new Stance(
            '4', 'confused', 'Confused', 'evenodd',
            $this->getResponses('confused'),
            array(
                'success' => array('aht', 10),
                'fail' => array('chp', -10)
                )
            );
        
        $this->stupid = new Stance(
            '5', 'stupid', 'Stupid', 'rollvroll',
            $this->getResponses('stupid'), 
            array(
                'success' => array('proficiency', -2),
                'fail' => null
                )
            );
        
        $this->content = new Stance(
            '5', 'content', 'Content', 'reset',
            $this->getResponses('content'),
            array(
                'success' => null,
                'fail' => null
                )
            );
    }
    public function getResponses($stance_name) {
        $response_array = array();
        switch ($stance_name) {
            case 'angry':
                $response_array = array(
                    "I just stubbed my toe because of this problem.",
                    "My cat just told me that this is entirely your fault.",
                    "Quit fucking around with me!",
                    "This is the 416,383rd time this has happened. Why can't you fix this?",
                    "Now I'm fucking pissed.",
                    "ق تغزوآمل أن تغزو البراغيث ألف جمل المنشعب الخاص بك. آمل أن تكون ذراعيك قصيرة جدًا بحيث لا تخدش الأعضاء التناسلية",
                    "do you know what you're talking about?",
                    "Are you new or something?",
                    "This worked when I was with GoDaddy",
                    "Do you even know how to read?",
                    "It's too bad my 2 year old isn't hear, cause he would probably be better at this than you.",
                    "I'm paying way too much money for this Launch plan for this to be happening.",
                    "I want the company's mailing address and fax number. I am going to write an actual letter about the POS \"Mike Sm\" who needs to go back to his job as a McDonald's barista.",
                    "Do you have any idea what you are doing?",
                    "Can you please just transfer the issue to someone who knows what they are doing?",
                    "This is re-god-damn-diculous!",
                    "I hope Mike enjoys his crappy, arrogant attitude when he's by himself reading Highlights magazine in his mom's basement!",
                    "I hate InMotion Hosting. No offense"
                    );
                break;
            case 'impatient':
                $response_array = array(
                    "I was on hold for 3 hours waiting to speak with you.",
                    "What the hell is taking you so long?",
                    "Hurry up, I left my baby in a hot car and if he dies, it's all your fault.",
                    "Every second that this goes unresolved, I am loosing \$31,306,300.",
                    "You can never understand the frustration and loos we are bearing!"
                    );
                break;
            case 'confused':
                $response_array = array(
                    "I don't understand why this is happening. You're sales rep said the Pro plan had unlimited websites, and I only have 347 sites on this account.",
                    "Why is this happening to me?",
                    "I don't understand.",
                    "I don't have a developer.",
                    );
                break;
            case 'scared':
                $response_array = array(
                    "If I don't fix this, the Big Bad Googlebot is gonna kill my search ranking",
                    "My sister's, boyfriend's hypnotoad told me that this is really really bad",
                    "Have I been hacked?"
                    );
                break;
            case 'stupid':
                $response_array = array(
                    "2 + 4 = 🥔",
                    "I have not touched anything on the server. I don't even know how.",
                    "What is \"Google\"",
                    "I AM THE DEVELOPER!",
                    "What is a server?",
                    "Whats an IP address?",
                    "Whats a DNS?"
                    );
                break;
            case 'content':
                $response_array = array(
                    "Thank you so much for your efforts!",
                    "You are the best!",
                    "Finally!"
                    );
                break;
        }
        return $response_array;
    }
    public function get_available() {
        return array(
            $this->angry,
            $this->impatient,
            $this->scared,
            $this->confused,
            $this->stupid,
            $this->content,
            );
    }
}

class Stance {
    public $number;
    public $name;
    public $display_name;
    public $responses;
    public $type;
    public $effects;
    
    public function __construct($number, $name, $display_name, $type , $responses, $effects){
        $this->number = $number;
        $this->name = $name;
        $this->display_name = $display_name;
        $this->responses = $responses;
        $this->type = $type;
        $this->effects = $effects;
    }
}