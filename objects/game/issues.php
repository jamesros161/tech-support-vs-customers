<?php
// 'user' object

class Issue{
 
    // object properties
    public $category;
    public $string;
    

    // constructor
    public function __construct(){
        $this->category = $this->getCategory();
        $this->string = $this->getIssueString();
    }
    
    function getCategory() {
        $cat_no = rand(0,3);
        $categories = array(
            'domains','website','email','services'
            );
        return $categories[$cat_no];
    }
    
    function getIssueString() {
        $category = $this->category;
        $issue_strings = array(
            'domains' => array(
                'I keep getting the error "ERR_NAME_NOT_RESOLVED" when trying to load my site',
                'My DNS isn\'t resolving, and it\'s been over 48 hours',
                'No puedo connect a mi server',
                'Please do the needful',
                'Domain no resolvy. Please unfucky wucky. Needful do pleaase'
                ),
            'website' => array(
                'My website is hacked! Fix this for me! It\'s all your fault!',
                'My website is down!. Why is my website down again?',
                'I can\'t submit messages from my contact form.',
                'Mon site WordPress ne se charge pas.',
                'Site Down. Do needful por favor.',
                'WordPress location load white paper. For me repair the needful.'
                ),
            'email' => array(
                'All my emails are being bounced back from Google. Something about my server\'s IP being blocked.',
                'Outlook isn\'t working when I try to check my email.',
                'Electronic messages all fucky wucky. Please unfucky wucky.',
                'Email was all uwu, but now it is -_- . Please do needful things to make uwu again',
                'My inbox is full of spam. Every other message is spam. I don\'t even like spam, Sam I am.'
                ),
            'services' => array(
                'When I try to connect via FTP, I get an error saying "invalid username or password". What could possibly be wrong?',
                'MySQL cannot connect, but my MySQL credentials are correct',
                'Every website on my server shows a 503 error',
                'I Cannot login to cPanel. Something about a disk space error?',
                'خادم بلدي هو كل شيء مارس الجنس')
            );
        $string_count = count($issue_strings[$category]);
        $string_no = rand(0,($string_count - 1));
        return $issue_strings[$category][$string_no];
    }
}