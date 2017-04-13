<?php

namespace dev\models\db;

use framework\models\db\Entiteit;

class Lesson extends Entiteit
{
    protected $id;
    protected $time;
    protected $date;
    protected $location;
    protected $max_persons;
    protected $instructor_id;
    protected $training_id;
    protected $db;

    public function __construct() {
        $this->id = filter_var($this->id, FILTER_VALIDATE_INT);
        $this->instructor_id = filter_var($this->instructor_id, FILTER_VALIDATE_INT);
        $this->training_id = filter_var($this->training_id, FILTER_VALIDATE_INT);
        $this->db = new \PDO(DATA_SOURCE_NAME,DB_USERNAME,DB_PASSWORD);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getTraining() {
        $sql = "SELECT * FROM `trainings` WHERE id = :id LIMIT 1";
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':id', $this->id);
        $stmnt->execute();
        return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\Training');
    }
}
