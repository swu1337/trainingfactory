<?php
namespace dev\models;

use framework\models\AbstractModel;

class InstructorModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }

    public function getLessons($id = null) {
        $sql = "SELECT lessons.id as \"lesson_id\",
                    (SELECT COUNT(registrations.lesson_id) FROM registrations WHERE registrations.lesson_id = lessons.id) AS \"registered\",
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
                ORDER BY lessons.id";

        if(isset($id)) {
            if(filter_var($id, FILTER_VALIDATE_INT)) {
                $sql = "SELECT *, DATE_FORMAT(lessons.date, '%d-%m-%Y') AS \"date\"  FROM lessons WHERE lessons.id = :id LIMIT 1";
                $stmnt = $this->db->prepare($sql);
                $stmnt->bindParam(':id', $id);
                $stmnt->execute();

                return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Lesson')[0];
            } else {
                return PARAM_URL_INCOMPLETE;
            }
        }

        $stmnt = $this->db->prepare($sql);
        $stmnt->execute();

        return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Registration');
    }

    public function getTrainings() {
        $sql = "SELECT * FROM `trainings`";
        $stmnt = $this->db->prepare($sql);
        $stmnt->execute();

        return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Training');
    }

    public function getRegisteredMember($id) {
        $sql = "SELECT persons.* 
                FROM registrations 
                LEFT JOIN persons ON registrations.member_id = persons.id 
                WHERE registrations.lesson_id = :id";

        if(filter_var($id, FILTER_VALIDATE_INT)) {
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':id', $id);
            $stmnt->execute();

            if($stmnt->rowCount() < 1) {
                return null;
            }

            return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Person');
        } else {
            return PARAM_URL_INVALID;
        }

    }

    public function getPersons($array) {
        $prop = key($array);
        $value = $array[$prop];

        $sql = "SELECT * FROM persons WHERE $prop = :value";
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':value', $value);
        $stmnt->execute();

        return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Person');
    }

    public function lesMaken() {
        $datum = filter_input(INPUT_POST, 'datum');
        $tijd = filter_input(INPUT_POST, 'tijd');
        $sport = filter_input(INPUT_POST, 'sport', FILTER_VALIDATE_INT);
        $lokaal = filter_input(INPUT_POST, 'lokaal');
        $aantal = filter_input(INPUT_POST, 'aantal', FILTER_VALIDATE_INT);
        
        if(in_array(NULL, [$datum, $tijd, $sport, $lokaal , $aantal])) {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }

        $datum = strtotime($datum);
        $tijd = strtotime($tijd);

        if(in_array(false, [$aantal, $sport, $datum, $tijd], true)) {
            return REQUEST_FAILURE_DATA_INVALID;
        }

        $datum = date('Y-m-d', $datum);
        $tijd = date('H:i:s', $tijd);
        $i_id = $this->getGebruiker()->getId();

        $sql = "INSERT INTO `lessons` (`time`, `date`, `location`, `max_persons`, `instructor_id`, `training_id`)
                VALUES(:tijd, :datum, :lokaal, :aantal, :i_id, :sport)";
            
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':datum', $datum);
        $stmnt->bindParam(':tijd', $tijd);
        $stmnt->bindParam(':sport', $sport);
        $stmnt->bindParam(':lokaal', $lokaal);
        $stmnt->bindParam(':aantal', $aantal);
        $stmnt->bindParam(':i_id', $i_id);

        try {
            $stmnt->execute();
        } catch(\PDOEXception $e) {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($stmnt->rowCount() === 1) {
            return REQUEST_SUCCESS;
        }

        return REQUEST_NOTHING_CHANGED;
    }

    public function update($id) {
        $tijd = filter_input(INPUT_POST, 'tijd');
        $datum = filter_input(INPUT_POST, 'datum');
        $lokaal = filter_input(INPUT_POST, 'lokaal');
        $aantal = filter_input(INPUT_POST, 'aantal', FILTER_VALIDATE_INT);
        $instructeur = filter_input(INPUT_POST, 'instructeur', FILTER_VALIDATE_INT);
        $sport = filter_input(INPUT_POST, 'sport', FILTER_VALIDATE_INT);

        if(in_array(NULL, [$tijd, $datum, $lokaal, $aantal, $instructeur, $sport,])) {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }

        $tijd = strtotime($tijd);
        $datum = strtotime($datum);

        if(in_array(false, [$tijd, $datum, $aantal, $instructeur, $sport], true)) {
            return REQUEST_FAILURE_DATA_INVALID;
        }

        $datum = date('Y-m-d', $datum);
        $tijd = date('H:i:s', $tijd);

        $sql = "UPDATE lessons 
                SET time = :tijd, 
                    date = :datum,
                    location = :lokaal,
                    max_persons = :aantal,
                    instructor_id = :instructeur,
                    training_id = :sport
                    WHERE id = :id";

        if(filter_var($id, FILTER_VALIDATE_INT)) {
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':datum', $datum);
            $stmnt->bindParam(':tijd', $tijd);
            $stmnt->bindParam(':sport', $sport);
            $stmnt->bindParam(':lokaal', $lokaal);
            $stmnt->bindParam(':aantal', $aantal);
            $stmnt->bindParam(':instructeur', $instructeur);
            $stmnt->bindParam(':id', $id);

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
            return PARAM_URL_INVALID;
        }
    }
}