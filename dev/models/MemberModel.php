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
                    (SELECT COUNT(registrations.lesson_id) FROM registrations WHERE registrations.lesson_id = lessons.id) AS \"registered\",
                    registrations.payment,
                    lessons.time, 
                    DATE_FORMAT(lessons.date, '%d-%m-%Y') AS \"date\",
                    lessons.location,
                    lessons.max_persons, 
                    lessons.instructor_id, 
                    trainings.description, 
                    trainings.duration, 
                    trainings.extra_costs, 
                    registrations.member_id
                FROM lessons 
                JOIN trainings ON lessons.training_id = trainings.id 
                LEFT JOIN registrations ON lessons.id = registrations.lesson_id 
                WHERE lessons.id IN (SELECT registrations.lesson_id from registrations WHERE registrations.member_id = :id) 
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

    public function getAllLessons($isDistinct = null, $array = [], $member_id = null) {
        if($isDistinct) {
            $sql = "SELECT DISTINCT DATE_FORMAT(date, '%d-%m-%Y') as \"formatted_date\" FROM `lessons` WHERE date >= CURDATE() ORDER BY formatted_date";
            $stmnt = $this->db->prepare($sql);
            $stmnt->execute();
            return $stmnt->fetchALL(\PDO::FETCH_NUM);
        }

        if(!empty($array)) {
            $prop = key($array);
            $value = $array[$prop];

            $sql = "SELECT lessons.id as \"lesson_id\",
                       lessons.max_persons - (SELECT COUNT(registrations.lesson_id) FROM registrations WHERE registrations.lesson_id = lessons.id) AS \"remaining\",
                       registrations.payment,
                       lessons.time, 
                       DATE_FORMAT(lessons.date, '%d-%m-%Y') AS \"date\",
                       lessons.location, 
                       lessons.max_persons, 
                       lessons.instructor_id, 
                       trainings.description, 
                       trainings.duration, 
                       trainings.extra_costs, 
                       registrations.member_id 
                    FROM lessons 
                    JOIN trainings ON lessons.training_id = trainings.id 
                    LEFT JOIN registrations ON lessons.id = registrations.lesson_id 
                    WHERE `lessons`.`$prop` = :c_date AND `lessons`.`id` NOT IN (SELECT lesson_id FROM registrations WHERE member_id = :id)
                    ORDER BY lessons.id";

            $sttvalue = $value;

            if($value === 'Vandaag') {
                $sttvalue = 'now';
            }

            if($value === 'Later') {
                $v = $this->getSchedule();
                $sttvalue = $v[count($v) - 2];
            }

            $intd = strtotime($sttvalue);

            if(!$intd) {
                return $intd;
            }

            $date = date('Y-m-d', $intd);

            if($value === 'Later') {
                $sql = "SELECT lessons.id as \"lesson_id\",
                       lessons.max_persons - (SELECT COUNT(registrations.lesson_id) FROM registrations WHERE registrations.lesson_id = lessons.id) AS \"remaining\",
                       registrations.payment,
                       lessons.time, 
                       DATE_FORMAT(lessons.date, '%d-%m-%Y') AS \"date\",
                       lessons.location, 
                       lessons.max_persons, 
                       lessons.instructor_id, 
                       trainings.description, 
                       trainings.duration, 
                       trainings.extra_costs, 
                       registrations.member_id 
                    FROM lessons 
                    JOIN trainings ON lessons.training_id = trainings.id 
                    LEFT JOIN registrations ON lessons.id = registrations.lesson_id 
                    WHERE `lessons`.`$prop` > :c_date AND `lessons`.`id` NOT IN (SELECT lesson_id FROM registrations WHERE member_id = :id)
                    ORDER BY lessons.id";
            }

            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':c_date', $date);
            $stmnt->bindParam(':id', $member_id);

        } else {
            $sql = "SELECT * FROM `lessons`";
            $stmnt = $this->db->prepare($sql);
        }

        $stmnt->execute();

        return $stmnt->fetchALL(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Lesson');
    }

    public function getSchedule() {
        $lessons = $this->getAllLessons(true);
        
        if($lessons) {
            $dates = call_user_func_array('array_merge', $lessons);
            
            if(strtotime($dates[0]) !== strtotime(date('d-m-Y'))) {
                array_unshift($dates, 'Vandaag');
            } else {
                $dates[0] = 'Vandaag';
            }

            array_splice($dates, 14, count($dates), "Later");

            return $dates;
        }
        
        return NULL;
    }

    public function inschrijven($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $g = $this->getGebruiker()->getId();

        if(!$id) {
           return PARAM_URL_INCOMPLETE;
        }

        $sql = "INSERT INTO registrations (lesson_id, member_id, payment)
                VALUES (:id, :m_id, 'unpaid')";

        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->bindParam(':m_id', $g);

        try {
            $stmnt->execute();
        } catch (\PDOException $e) {
            return REQUEST_FAILURE_DATA_INVALID;
        }

        if($stmnt->rowCount() === 1) {
            return REQUEST_SUCCESS;
        }
        REQUEST_NOTHING_CHANGED;
    }
}