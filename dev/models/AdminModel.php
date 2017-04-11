<?php
namespace dev\models;

use framework\models\AbstractModel;

class AdminModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }

    public function getObject($prop, $id = null) {
        if(!isset($id)) {
            switch ($prop) {
                case 'training':
                    $sql = "SELECT * FROM `trainings`";
                    break;
                case 'instructor':
                    $sql = "SELECT *, DATE_FORMAT(`dateofbirth`, '%d-%m-%Y') AS \"dateofbirth\" FROM `persons` WHERE role = 'instructor'";
                    $prop = 'person';
                    break;
                case 'member':
                    $sql = "SELECT *, DATE_FORMAT(`dateofbirth`, '%d-%m-%Y') AS \"dateofbirth\" FROM `persons` WHERE role = 'member'";
                    $prop = 'person';
                    break;
                default:
                    return PARAM_URL_INVALID;
            }

            $stmnt = $this->db->prepare($sql);
            $stmnt->execute();

            if($stmnt->rowCount() < 1) {
                return null;
            }

            return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\\' . ucfirst($prop));
        } else {
            if(filter_var($id, FILTER_VALIDATE_INT)) {
                switch ($prop) {
                    case 'training':
                        $sql = "SELECT * FROM `trainings` WHERE id = :id LIMIT 1";
                        break;
                    case 'person':
                        $sql = "SELECT *, DATE_FORMAT(`dateofbirth`, '%d-%m-%Y') AS \"dateofbirth\" FROM `persons` WHERE id = :id LIMIT 1";
                        break;
                    default:
                        return PARAM_URL_INVALID;
                }

                $stmnt = $this->db->prepare($sql);
                $stmnt->bindParam(':id', $id);
                $stmnt->execute();

                if ($stmnt->rowCount() !== 1) {
                    return PARAM_URL_INVALID;
                }

                return $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\\' . ucfirst($prop))[0];
            } else {
                return PARAM_URL_INCOMPLETE;
            }
        }
    }

    public function delete($prop, $id) {
        switch ($prop) {
            case 'training':
                $sql = "DELETE FROM `trainings` WHERE id = :id";
                break;
            case 'member':
            case 'instructor':
                $sql = "DELETE FROM `persons` WHERE id = :id";
                break;
            default:
                return PARAM_URL_INVALID;
        }

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':id', $id);

            try {
                $stmnt->execute();
            } catch (\PDOEXception $e) {
                return REQUEST_FAILURE_DATA_INVALID;
            }

            if($stmnt->rowCount() === 1) {
                return REQUEST_SUCCESS;
            } else {
                return REQUEST_FAILURE_DATA_INCOMPLETE;
            }
        } else {
            return PARAM_URL_INCOMPLETE;
        }
    }

    public function edit($prop, $id) {
        switch ($prop) {
            case 'training':
                $description = filter_input(INPUT_POST, 'description');
                $duration = filter_input(INPUT_POST, 'duration');


                if(in_array(null, [$description, $duration])) {
                    return REQUEST_FAILURE_DATA_INCOMPLETE;
                }

                if(!empty($_POST['extra_costs'])) {
                    $extra = filter_input(INPUT_POST, 'extra_costs', FILTER_VALIDATE_FLOAT);
                } else {
                    $extra = NULL;
                }

                $duration = strtotime($duration);

                if(in_array(false, [$extra, $duration], true)) {
                    return REQUEST_FAILURE_DATA_INVALID;
                }

                $duration = date('H:i:s', $duration);

                $sql = "UPDATE `trainings` SET `description` = :desc, `duration` = :dur, `extra_costs` = :ec WHERE id = :id";
                $stmnt = $this->db->prepare($sql);
                $stmnt->bindParam(':desc', $description);
                $stmnt->bindParam(':dur', $duration);
                $stmnt->bindParam(':ec', $extra);
                break;
//            case 'member':
//                break;
//            case 'instructor':
//                break;
            default:
                return PARAM_URL_INVALID;
        }

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            return PARAM_URL_INVALID;
        }

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
    }

    public function getReservations($id) {

    }
}