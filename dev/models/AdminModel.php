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
                    break;
                default:
                    return PARAM_URL_INVALID;
            }

            $stmnt = $this->db->prepare($sql);
            $stmnt->execute();
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
}