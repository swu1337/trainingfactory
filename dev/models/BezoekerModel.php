<?php
namespace dev\models;

use framework\models\AbstractModel;

class BezoekerModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }

    public function controleerInloggen() {
        $ln =  filter_input(INPUT_POST, 'ln');
        $pw =  filter_input(INPUT_POST, 'pw');

        if($ln !== null && $pw !== null) {
            $sql = 'SELECT * FROM `persons` WHERE `loginname` = :ln AND `password` = :pw';
            $sth = $this->db->prepare($sql);
            $sth->bindParam(':ln', $ln);
            $sth->bindParam(':pw', $pw);
            $sth->execute();

            $result = $sth->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Person');

            if(count($result) === 1) {
                $this->startSession();
                $_SESSION['gebruiker'] = $result[0];
                return REQUEST_SUCCESS;
            }
            return REQUEST_FAILURE_DATA_INVALID;
        }
        return REQUEST_FAILURE_DATA_INCOMPLETE;
    }

    public function getSoortTrainingen() {
       $sql = 'SELECT * FROM `trainings`';
       $stmnt = $this->db->prepare($sql);
       $stmnt->execute();
       $soortTrainingen = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');
       return $soortTrainingen;
    }
    
    public function registreren()
    {
        $gn = filter_input(INPUT_POST, 'gebruikersnaam');
        $vn = filter_input(INPUT_POST, 'voornaam');
        $tv = filter_input(INPUT_POST, 'tussenvoegsel');
        $an =filter_input(INPUT_POST, 'achternaam');
        $gd = filter_input(INPUT_POST, 'geboortedatum');
        $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $ww = filter_input(INPUT_POST, 'wachtwoord');
        $gl = filter_input(INPUT_POST, 'geslacht');
        $st = filter_input(INPUT_POST, 'straat');
        $pc = filter_input(INPUT_POST, 'postcode');
        $sd = filter_input(INPUT_POST, 'stad');
         
        if(in_array(NULL, [$gn, $vn, $an, $gd, $gl, $st, $pc])) {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
       
        if(empty($ww))
        {
            $sql=   "INSERT INTO `persons`  (loginname,firstname,preprovision,lastname, 
                dateofbirth,email_address,gender,street,postal_code,place,role)VALUES (:gebruikersnaam,:voornaam,:tussenvoegsel,:achternaam, 
                :geboortedatum,:email,:geslacht,:straat,:postcode,:stad,'member') ";
            $stmnt = $this->db->prepare($sql);
        }
        else{
            $sql=   "INSERT INTO `persons`  (loginname,firstname,preprovision,lastname, 
                dateofbirth,email_address,gender,street,postal_code,place,role,password)VALUES (:gebruikersnaam,:voornaam,:tussenvoegsel,:achternaam, 
                :geboortedatum,:email,:geslacht,:straat,:postcode,:stad,'member',:wachtwoord) ";
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':wachtwoord', $ww);
        }
        $stmnt->bindParam(':gebruikersnaam', $gn);
        $stmnt->bindParam(':voornaam', $vn);
        $stmnt->bindParam(':tussenvoegsel', $tv);
        $stmnt->bindParam(':achternaam', $an);
        $stmnt->bindParam(':geboortedatum', $gd);
        $stmnt->bindParam(':email', $email);
        $stmnt->bindParam(':geslacht', $gl);
        $stmnt->bindParam(':straat', $st);
        $stmnt->bindParam(':postcode', $pc);
        $stmnt->bindParam(':stad', $sd);
        var_dump($_POST);
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($stmnt->rowCount() === 1)
        {            
           ; return REQUEST_SUCCESS;
        }
        //return REQUEST_FAILURE_DATA_INVALID; 
    }
}