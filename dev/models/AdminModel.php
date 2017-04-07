<?php
namespace dev\models;

use framework\models\AbstractModel;

class AdminModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }

    public function getPerson($id) {
        if(is_int($id)) {
            $sql = "SELECT * FROM `persons` WHERE id = :id LIMIT 1";
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':id', $id);
            $stmnt->execute();
            return $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__ . '\db\Person')[0];
        }

        switch ($id) {
            case 'members':
                $sql = "SELECT * FROM `persons` WHERE role = 'member'";
                break;
            case 'instructors':
                $sql = "SELECT * FROM `persons` WHERE role = 'instructor'";
                break;
            case 'admins':
                $sql = "SELECT * FROM `persons` WHERE role = 'admin'";
                break;
            default:
                return REQUEST_FAILURE_DATA_INVALID;
        }

        $stmnt = $this->db->prepare($sql);
        $stmnt->execute();
        return $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__ . '\db\Person');
    }

    public function getTraining($id) {
        $id = filter_input($id, FILTER_VALIDATE_INT);

        if($id === null) {
            return PARAM_URL_INCOMPLETE;
        }

        if($id === false) {
            return PARAM_URL_INVALID;
        }

        if(is_int($id)) {
            $sql = "SELECT * FROM `trainings` WHERE id = :id LIMIT 1";
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':id', $id);
            $stmnt->execute();
            return $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__ . '\db\Training')[0];
        }

        if($id === 'trainings') {
            $sql = "SELECT * FROM `trainings`";
            $stmnt = $this->db->prepare($sql);
            $stmnt->execute();
            return $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__ . '\db\Training');
        } else {
            return REQUEST_FAILURE_DATA_INVALID;
        }

        $stmnt = $this->db->prepare($sql);
        $stmnt->execute();
        return $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__ . '\db\Person');

    }


}