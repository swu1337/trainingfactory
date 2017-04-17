<?php
namespace dev\models;

use framework\models\AbstractModel;

class MemberModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }
    
    public function wijziggegevens() {
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
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

        if(empty($ww)) {
            $sql = "UPDATE `persons`SET firstname = :voornaam, preprovision = :tussenvoegsel, lastname = :achternaam, dateofbirth = :geboortedatum, email_address = :email, gender = :geslacht, street = :straat, postal_code = :postcode, place = :stad WHERE `id` = :id";
            $stmnt = $this->db->prepare($sql);
        } else {
            $sql = "UPDATE `persons`SET firstname = :voornaam, preprovision = :tussenvoegsel, lastname = :achternaam, dateofbirth = :geboortedatum, email_address = :email, gender = :geslacht, street = :straat, postal_code = :postcode, place = :stad, password = :wachtwoord WHERE `id` = :id";
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':wachtwoord', $ww);
        }
        
        $stmnt->bindParam(':id', $id);
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
            $this->updateGebruiker();
            return REQUEST_SUCCESS;
        }

        return REQUEST_FAILURE_DATA_INVALID; 
    }
    
    private function updateGebruiker() {
        $gebruiker_id = $this->getGebruiker()->getId();
        $sql = "SELECT * FROM `persons` WHERE `persons`.`id` = :gebruiker_id";
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':gebruiker_id', $gebruiker_id);
        $stmnt->setFetchMode(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Person');
        $stmnt->execute();
        $_SESSION['gebruiker'] = $stmnt->fetch(\PDO::FETCH_CLASS);
    }

    public function getAllLessons($isDistinct = null) {
        $sql = "SELECT * FROM `lessons`";

        if($isDistinct) {
            $sql = "SELECT * FROM `lessons` GROUP BY date ORDER BY date";
        }

        $stmnt = $this->db->prepare($sql);
        $stmnt->execute();
        return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Lesson');
    }
}