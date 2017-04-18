<?php
namespace dev\models;

use framework\models\AbstractModel;

class InstructorModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }

    public function getLessons() {
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
                 GROUP BY lessons.id
                 ORDER BY lessons.id";
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
    
    public function lesMaken() {
        $datum = filter_input(INPUT_POST, 'datum');
        $tijd = filter_input(INPUT_POST, 'tijd');
        $sport = filter_input(INPUT_POST, 'sport');
        $lokaal = filter_input(INPUT_POST, 'lokaal');
        $aantal = filter_input(INPUT_POST, 'aantal', FILTER_VALIDATE_INT);
        
        if(in_array(NULL, [$datum, $tijd, $sport, $lokaal , $aantal])) {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }

        $datum = strtotime($datum);
        $tijd = strtotime($tijd);

        if(in_array(false, [$aantal, $datum, $tijd], true)) {
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
}