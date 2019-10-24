<?php

class IssueResolutions{
    public $types;
    public $domain_resolutions;
    public $email_resolutions;
    public $website_resolutions;
    public $services_resolutiona;
    
    public function __construct(){
        $this->domain_resolutions = array (
            array('run_auto_ssl', 'Run AutoSSL', 'ssl'),
            array('validate_registration', 'Validate Registration', 'domains'),
            array('correct_dns_zone', 'Correct DNS Zone', 'dns'),
            array('create_addon_domain', 'Create Addon Domain', 'cpanel'),
            array('fix_document_root', 'Fix Document Root', 'apache')
            );
        foreach ($this->domain_resolutions as $res) {
            $this->{$res[0]} = new Resolution('domain', $res[0], $res[1], $res[2]);
        }
        
        $this->email_resolutions = array (
            array('delist_mailing_ip', 'Delist Mailing IP', 'email'),
            array('set_spf_record', 'Set SPF Record', 'dns'),
            array('set_custom_hostname', 'Set Custom Hostname', 'linux'),
            array('reset_password', 'Reset Password', 'cpanel'),
            array('fix_nameservers', 'Fix Nameservers', 'dns')
            );
        foreach ($this->email_resolutions as $res) {
            $this->{$res[0]} = new Resolution('email', $res[0], $res[1], $res[2]);
        }
        
        $this->website_resolutions = array (
            array('disable_all_plugins', 'Disable All Plugins', 'wordpress'),
            array('restart_apache', 'Restart Apache', 'apache'),
            array('rebuild_nginx', 'Rebuild NGINX', 'nginx'),
            array('adjust_phpini_directives', 'Adjust php.ini directives', 'php'),
            array('correct_db_creds', 'Correct Database Credentials', 'mysql')
            );
        foreach ($this->website_resolutions as $res) {
            $this->{$res[0]} = new Resolution('website', $res[0], $res[1], $res[2]);
        }    
        
        $this->services_resolutions = array (
            array('repair_mysql_db', 'Repair MySQL Databases', 'mysql'),
            array('correct_reseller_privileges', 'Correct Reseller Privileges', 'cpanel'),
            array('adjust_phpfpm_pools', 'Adjust PHP-FPM Pools', 'php'),
            array('fix_ftp_creds', 'Fix FTP Credentials', 'ftp'),
            array('unblock_ip_add', 'Unblock IP Address', 'linux')
            );
        foreach ($this->services_resolutions as $res) {
            $this->{$res[0]} = new Resolution('services', $res[0], $res[1], $res[2]);
        }
    }
        
    public function get_available($contact){
        $available_resolutions = array();
        
        if ( $contact->category == 'domains' ) {
            foreach ($this->domain_resolutions as $res) {
                array_push($available_resolutions, $this->{$res[0]});
            }
        }
        
        if ( $contact->category == 'email' ) {
            foreach ($this->email_resolutions as $res) {
                array_push($available_resolutions, $this->{$res[0]});
            }
        }
        
        if ( $contact->category == 'website' ) {
            foreach ($this->website_resolutions as $res) {
                array_push($available_resolutions, $this->{$res[0]});
            }
        }
        
        if ( $contact->category == 'services' ) {
            foreach ($this->services_resolutions as $res) {
                array_push($available_resolutions, $this->{$res[0]});
            }
        }
        
        return $available_resolutions;
    }
}

class Resolution{
    public $type;
    public $name;
    public $display_name;
    public $skill;
    
    public function __construct($type, $name, $display_name, $skill){
        $this->type = $type;
        $this->name = $name;
        $this->display_name = $display_name;
        $this->skill = $skill;
    }
}