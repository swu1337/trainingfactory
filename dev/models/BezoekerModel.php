<?php
namespace dev\models;

use framework\models\AbstractModel;

class BezoekerModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }

    public function controleerInloggen() {
        $ln = filter_input(INPUT_POST, 'ln');
        $pw = filter_input(INPUT_POST, 'pw');

        if($ln !== null && $pw !== null) {
            $sql = "SELECT * FROM `persons` WHERE `loginname` = :ln AND `password` = :pw";
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':ln', $ln);
            $stmnt->bindParam(':pw', $pw);
            $stmnt->execute();

            $result = $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Person');

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
       $sql = "SELECT * FROM `trainings`";
       $stmnt = $this->db->prepare($sql);
       $stmnt->execute();
       return $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');
    }
    
    public function registreren() {
        $gn = filter_input(INPUT_POST, 'gebruikersnaam');
        $vn = filter_input(INPUT_POST, 'voornaam');
        $tv = filter_input(INPUT_POST, 'tussenvoegsel');
        $an = filter_input(INPUT_POST, 'achternaam');
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

        $gd = strtotime($gd);

        if(in_array(false, [$email, $gd], true)) {
            return REQUEST_FAILURE_DATA_INVALID;
        }

        $gd = date('Y-m-d', $gd);

        if(empty($ww)) {
            $sql=   "INSERT INTO `persons`
                     (loginname, firstname, preprovision, lastname, dateofbirth, email_address, gender, street, postal_code, place, role)
                     VALUES
                     (:gebruikersnaam, :voornaam, :tussenvoegsel, :achternaam, :geboortedatum, :email, :geslacht, :straat, :postcode, :stad, 'member')";
            $stmnt = $this->db->prepare($sql);
        } else {
            $sql = "INSERT INTO `persons`
                    (loginname, firstname, preprovision, lastname, dateofbirth, email_address, gender, street, postal_code, place, role, password)
                    VALUES 
                    (:gebruikersnaam, :voornaam, :tussenvoegsel, :achternaam, :geboortedatum, :email, :geslacht, :straat, :postcode, :stad, 'member', :wachtwoord)";
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

        try {
            $stmnt->execute();
        } catch(\PDOEXception $e) {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($stmnt->rowCount() === 1) {
           return REQUEST_SUCCESS;
        }
    }
}