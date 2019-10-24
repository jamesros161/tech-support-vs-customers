<?php
// 'user' object
include_once('attributes.php');
include_once "config/database.php";

class Agent{
 
    // database connection and table name
    private $table_name = "agents";
 
    // object properties
    public $id;
    public $firstname;
    public $player_id;
    public $initial_roll;
    public $dexterity;
    public $constitution;
    public $intelligence;
    public $wisdom;
    public $charisma;
    public $level;
    public $aht;
    public $hmp;
    public $ahtcost;
    public $xptolvlup;
 
    // constructor
    public function __construct(){
        $this->player_id = $_SESSION['user_id'];
        $this->strength = new Attribute('strength', 0, array(
            'attack_power'=>array('Attack Power', 0),
            'apache'=>array('Apache', 0),
            'cpanel'=>array('cPanel', 0))
            );
        $this->dexterity = new Attribute('dexterity', 0, array(
            'efficiency'=>array('Efficiency', 0),
            'dns'=>array('DNS', 0),
            'email'=>array('Email', 0))
            );
        $this->constitution = new Attribute('constitution', 0, array(
            'de_escalation'=>array('De-Escalation', 0),
            'ftp'=>array('FTP', 0),
            'linux'=>array('Linux', 0))
            );
        $this->intelligence = new Attribute('intelligence', 0, array(
            'contact_control'=>array('Contact Control', 0),
            'mysql'=>array('MySQL', 0),
            'nginx'=>array('Nginx', 0))
            );
        $this->wisdom = new Attribute('wisdom', 0, array(
            'confidence'=>array('Confidence', 0),
            'domains'=>array('Domains', 0),
            'php'=>array('PHP', 0))
            );
        $this->charisma = new Attribute('charisma', 0, array(
            'charm'=>array('Charm', 0),
            'ssl'=>array('SSL', 0),
            'wordpress'=>array('WordPress', 0))
            );
    }
    //Check if given Agent Exists in Database
    function playerAgentExists() {
        $db = new Database();
        
        $query = "SELECT id, firstname, strength, dexterity, constitution, intelligence, wisdom, charisma, level, xptolvlup, aht, hmp, ahtcost, initial_roll
                FROM " . $this->table_name . "
                WHERE player_id = :player_id
                LIMIT 0,1";
        $conn = $db->getConnection();
        $statement = $conn->prepare ( $query );
        $this->player_id=htmlspecialchars(strip_tags(strval($this->player_id)));
        $statement->bindParam(':player_id', $this->player_id);
        $statement->execute();
        
        $num = $statement->rowCount();
        if($num>0) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->strength = json_decode($row['strength']);
            $this->dexterity = json_decode($row['dexterity']);
            $this->constitution = json_decode($row['constitution']);
            $this->intelligence = json_decode($row['intelligence']);
            $this->wisdom = json_decode($row['wisdom']);
            $this->charisma = json_decode($row['charisma']);
            $this->level = $row['level'];
            $this->xptolvlup = $row['xptolvlup'];
            $this->aht = $row['aht'];
            $this->hmp = $row['hmp'];
            $this->ahtcost = $row['ahtcost'];
            $this->initial_roll = $row['initial_roll'];
            
            $this->strength = new Attribute('strength', $this->strength->value, array(
                'attack_power'=>$this->strength->attack_power,
                'apache'=>$this->strength->apache,
                'cpanel'=>$this->strength->cpanel));
            $this->dexterity = new Attribute('dexterity', $this->dexterity->value, array(
                'efficiency'=>$this->dexterity->efficiency,
                'dns'=>$this->dexterity->dns,
                'email'=>$this->dexterity->email));
            $this->constitution = new Attribute('constitution', $this->constitution->value, array(
                'de_escalation'=>$this->constitution->de_escalation,
                'ftp'=>$this->constitution->ftp,
                'linux'=>$this->constitution->linux));
            $this->intelligence = new Attribute('intelligence', $this->intelligence->value, array(
                'contact_control'=>$this->intelligence->contact_control,
                'mysql'=>$this->intelligence->mysql,
                'nginx'=>$this->intelligence->nginx));
            $this->wisdom = new Attribute('wisdom', $this->wisdom->value, array(
                'confidence'=>$this->wisdom->confidence,
                'domains'=>$this->wisdom->domains,
                'php'=>$this->wisdom->php));
            $this->charisma = new Attribute('charisma', $this->charisma->value, array(
                'charm'=>$this->charisma->charm,
                'ssl'=>$this->charisma->ssl,
                'wordpress'=>$this->charisma->wordpress));
            
            return true;
        }
        return false;
    }

    public static function calculate_aht($efficiency){
        $aht = 100 + ( $efficiency * 10);
        return $aht;
    }
    
    public static function calculate_hmp($attack_power) {
        $hmp = 100 + ( $attack_power * 10);
        return $hmp;
    }
    
    public static function calculate_ahtcost($efficiency) {
        if ( $efficiency < 5 ) {
            $ahtcost = 10 - $efficiency;
            return $ahtcost;
        }
        else if ( $efficiency > 5 || $efficiency < 10 ) {
            $ahtcost = 5 - (($efficiency - 5) / 2);
            return $ahtcost;
        }
        else {
            return 2;
        }
    }
    
    public static function calculate_xptolvlup($currentlevel, $constitution) {
        $basexptolevel = $currentlevel * 1000;
        $constitutionbonus = $constitution * 10 * $currentlevel;
        return $basexptolevel - $constitutionbonus;
    }
    
    function apply_xp_gain($xp_gain_amt) {
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    xptolvlup = :xptolvlup
                WHERE
                    id = :agent_id";
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare($query);
        
        $agent_id=htmlspecialchars(strip_tags($this->id));
        $xp_gain_amt=htmlspecialchars(strip_tags($xp_gain_amt));
        
        $stmt->bindParam(':agent_id', $agent_id);
        $stmt->bindParam(':xptolvlup', $xp_gain_amt);
        
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
    }
    
    function apply_lvl_up() {
        $current_lvl = $this->level;
        $new_level = $current_lvl + 1;
        
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    level = :newlevel
                WHERE
                    id = :agent_id";
                    
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare($query);
        
        $agent_id=htmlspecialchars(strip_tags($this->id));
        $new_level=htmlspecialchars(strip_tags($new_level));
        
        $stmt->bindParam(':agent_id', $agent_id);
        $stmt->bindParam(':newlevel', $new_level);
        
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
    }
    
    // create new user record
    function create(){
        $this->aht=$this->calculate_aht($this->dexterity->get_skill_val('efficiency'));
        $this->hmp=$this->calculate_hmp($this->strength->get_skill_val('attack_power'));
        $this->ahtcost=$this->calculate_ahtcost($this->dexterity->get_skill_val('efficiency'));
        $this->level = 1;
        $this->xptolvlup=$this->calculate_xptolvlup($this->level, $this->constitution->value);
        
        // to get time stamp for 'created' field
        $this->created=date('Y-m-d H:i:s');
     
        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    player_id = :player_id,
                    firstname = :firstname,
                    strength = :strength,
                    dexterity = :dexterity,
                    constitution = :constitution,
                    intelligence = :intelligence,
                    wisdom = :wisdom,
                    charisma = :charisma,
                    level = :level,
                    xptolvlup = :xptolvlup,
                    aht = :aht,
                    hmp = :hmp,
                    ahtcost = :ahtcost,
                    initial_roll = :initial_roll,
                    created = :created";
     
        // prepare the query
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare($query);
     
        // sanitize
        $this->player_id=htmlspecialchars(strip_tags($this->player_id));
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->strength=json_encode($this->strength);
        $this->dexterity=json_encode($this->dexterity);
        $this->constitution=json_encode($this->constitution);
        $this->intelligence=json_encode($this->intelligence);
        $this->wisdom=json_encode($this->wisdom);
        $this->charisma=json_encode($this->charisma);
        $this->level=htmlspecialchars(strip_tags($this->level));
        $this->xptolvlup=htmlspecialchars(strip_tags($this->xptolvlup));
        $this->aht=htmlspecialchars(strip_tags($this->aht));
        $this->hmp=htmlspecialchars(strip_tags($this->hmp));
        $this->ahtcost=htmlspecialchars(strip_tags($this->ahtcost));
     
        // bind the values
        $stmt->bindParam(':player_id', $this->player_id);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':strength', $this->strength);
        $stmt->bindParam(':dexterity', $this->dexterity);
        $stmt->bindParam(':constitution', $this->constitution);
        $stmt->bindParam(':intelligence', $this->intelligence);
        $stmt->bindParam(':wisdom', $this->wisdom);
        $stmt->bindParam(':charisma', $this->charisma);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':xptolvlup', $this->xptolvlup);
        $stmt->bindParam(':aht', $this->aht);
        $stmt->bindParam(':hmp', $this->hmp);
        $stmt->bindParam(':ahtcost', $this->ahtcost);
        $stmt->bindParam(':initial_roll', $this->initial_roll);
        $stmt->bindParam(':created', $this->created);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
     
    }
    public function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }
    
    function level_up(){
        $this->aht=$this->calculate_aht($this->dexterity->get_skill_val('efficiency'));
        $this->hmp=$this->calculate_hmp($this->strength->get_skill_val('attack_power'));
        $this->ahtcost=$this->calculate_ahtcost($this->dexterity->get_skill_val('efficiency'));
        $this->xptolvlup = $this->calculate_xptolvlup($this->level, $this->constitution->value);

        // insert query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    strength = :strength,
                    dexterity = :dexterity,
                    constitution = :constitution,
                    intelligence = :intelligence,
                    wisdom = :wisdom,
                    charisma = :charisma,
                    xptolvlup = :xptolvlup,
                    aht = :aht,
                    hmp = :hmp,
                    ahtcost = :ahtcost
                WHERE
                    id = :agent_id";
     
        // prepare the query
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare($query);
     
        // sanitize
        $agent_id=htmlspecialchars(strip_tags($this->id));
        $this->strength=json_encode($this->strength);
        $this->dexterity=json_encode($this->dexterity);
        $this->constitution=json_encode($this->constitution);
        $this->intelligence=json_encode($this->intelligence);
        $this->wisdom=json_encode($this->wisdom);
        $this->charisma=json_encode($this->charisma);
        $this->xptolvlup=htmlspecialchars(strip_tags($this->xptolvlup));
        $this->aht=htmlspecialchars(strip_tags($this->aht));
        $this->hmp=htmlspecialchars(strip_tags($this->hmp));
        $this->ahtcost=htmlspecialchars(strip_tags($this->ahtcost));
     
        // bind the values
        $stmt->bindParam(':agent_id', $agent_id);
        $stmt->bindParam(':strength', $this->strength);
        $stmt->bindParam(':dexterity', $this->dexterity);
        $stmt->bindParam(':constitution', $this->constitution);
        $stmt->bindParam(':intelligence', $this->intelligence);
        $stmt->bindParam(':wisdom', $this->wisdom);
        $stmt->bindParam(':charisma', $this->charisma);
        $stmt->bindParam(':xptolvlup', $this->xptolvlup);
        $stmt->bindParam(':aht', $this->aht);
        $stmt->bindParam(':hmp', $this->hmp);
        $stmt->bindParam(':ahtcost', $this->ahtcost);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
     
    }
}