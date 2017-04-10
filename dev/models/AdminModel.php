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
                case 'lesson':
                    $sql = "SELECT * FROM `lessons`";
                    break;
                case 'person':
                    $type = filter_input(INPUT_GET, 'type');
                    if(!empty($type)) {
                        switch ($_GET['type']) {
                            case 'member':
                                $sql = "SELECT * FROM `persons` WHERE role = 'member'";
                                break;
                            case 'instructor':
                                $sql = "SELECT * FROM `persons` WHERE role = 'instructor'";
                                break;
                            default:
                                return PARAM_URL_INCOMPLETE;
                        }
                    } else {
                        return PARAM_URL_INVALID;
                    }

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
                    case 'lesson':
                        $sql = "SELECT * FROM `lessons` WHERE id = :id LIMIT 1";
                        break;
                    case 'person':
                        $sql = "SELECT * FROM `persons` WHERE id = :id LIMIT 1";
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
                $sql = "DELETE FROM `persons` WHERE id = :id";
                break;
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
}