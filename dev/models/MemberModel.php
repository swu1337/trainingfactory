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
            $sql = "UPDATE `persons`
                    SET firstname = :voornaam,
                        preprovision = :tussenvoegsel,
                        lastname = :achternaam,
                        dateofbirth = :geboortedatum,
                        email_address = :email,
                        gender = :geslacht,
                        street = :straat,
                        postal_code = :postcode,
                        place = :stad
                        WHERE `id` = :id";
            $stmnt = $this->db->prepare($sql);
        } else {
            $sql = "UPDATE `persons` 
                    SET firstname = :voornaam,
                    preprovision = :tussenvoegsel,
                    lastname = :achternaam,
                    dateofbirth = :geboortedatum,
                    email_address = :email,
                    gender = :geslacht,
                    street = :straat,
                    postal_code = :postcode,
                    place = :stad,
                    password = :wachtwoord
                    WHERE `id` = :id";
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

        return REQUEST_NOTHING_CHANGED;
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
    
    public function getRegistrations($id) {
        $sql = "SELECT lessons.id as \"lesson_id\",
                       COUNT(registrations.lesson_id) AS \"registered\",
                       registrations.payment,
                       lessons.time, 
                       DATE_FORMAT(lessons.date, '%d-%m-%Y') AS \"date\",
                       lessons.location, lessons.max_persons, 
                       lessons.instructor_id, 
                       trainings.description, 
                       trainings.duration, 
                       trainings.extra_costs, 
                       registrations.member_id 
                 FROM lessons 
                 JOIN trainings ON lessons.training_id = trainings.id 
                 LEFT JOIN registrations ON lessons.id = registrations.lesson_id 
                 WHERE lessons.id IN (SELECT registrations.lesson_id from registrations where registrations.member_id = :id) 
                 GROUP BY lessons.id
                 ORDER BY lessons.id";

        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        if($id) {
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':id', $id);
            $stmnt->execute();

            if($stmnt->rowCount() > 0) {
                return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Registration');
            } else {
                return REQUEST_NO_DATA;
            }
        } else {
            return PARAM_URL_INCOMPLETE;
        }
    }

    public function lesUitschrijven($id) {
        $sql = "DELETE FROM registrations WHERE registrations.lesson_id = :l_id AND registrations.member_id = :m_id";
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {
            $stmnt = $this->db->prepare($sql);
            $m_id = $this->getGebruiker()->getId();
            $stmnt->bindParam(':l_id', $id);
            $stmnt->bindParam(':m_id', $m_id);

            try {
                $stmnt->execute();
            } catch (\PDOException $e) {
                return REQUEST_FAILURE_DATA_INVALID;
            }

            if($stmnt->rowCount() === 1) {
                return REQUEST_SUCCESS;
            }

            return REQUEST_NOTHING_CHANGED;
        } else {
            return PARAM_URL_INCOMPLETE;
        }
    }

}