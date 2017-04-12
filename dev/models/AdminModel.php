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
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            return PARAM_URL_INVALID;
        }

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
            case 'member':
                $dateofbirth = filter_input(INPUT_POST, 'dateofbirth');
                $loginname = filter_input(INPUT_POST, 'loginname');
                $gender = filter_input(INPUT_POST, 'gender');
                $street = filter_input(INPUT_POST, 'street');
                $postal_code = filter_input(INPUT_POST, 'postal_code');
                $place = filter_input(INPUT_POST, 'place');
                $email_address = filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL);

                $payments = filter_input(INPUT_POST, 'payments', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

                if(in_array(null, [$dateofbirth, $loginname, $gender, $street, $postal_code, $place, $email_address])) {
                    return REQUEST_FAILURE_DATA_INCOMPLETE;
                }

                $dateofbirth = strtotime($dateofbirth);

                if(in_array(false, [$email_address, $dateofbirth, $payments], true)) {
                    return REQUEST_FAILURE_DATA_INVALID;
                }

                if($payments === null) {
                    $payments = [];
                }

                $dateofbirth = date('Y-m-d', $dateofbirth);

                $sql = "UPDATE `persons` 
                            SET dateofbirth = :dateofbirth,
                                loginname = :loginname,
                                gender = :gender, 
                                street = :street, 
                                postal_code = :postal_code,
                                place = :place,
                                email_address = :email_address
                            WHERE id = :id";

                $stmnt = $this->db->prepare($sql);
                $stmnt->bindParam(':dateofbirth', $dateofbirth);
                $stmnt->bindParam(':loginname', $loginname);
                $stmnt->bindParam(':gender', $gender);
                $stmnt->bindParam(':street', $street);
                $stmnt->bindParam(':postal_code', $postal_code);
                $stmnt->bindParam(':place', $place);
                $stmnt->bindParam(':email_address', $email_address);

                $payments = array_map(function($v) { return (int)$v; }, $payments);
                $m_registrations = $this->getRegistrations($id);

                $stmnts = [];

                foreach ($m_registrations as $member_r) {
                    if(in_array($member_r->getLesson_id(), $payments)) {
                        $rsql = "UPDATE `registrations` 
                                 SET payment = 'paid' 
                                 WHERE lesson_id = :l_id AND member_id = :m_id";
                    } else {
                        $rsql = "UPDATE `registrations` 
                                 SET payment = 'unpaid' 
                                 WHERE lesson_id = :l_id AND member_id = :m_id";
                    }

                    $sth = $this->db->prepare($rsql);
                    $sth->bindValue(':l_id', $member_r->getLesson_id());
                    array_push($stmnts, $sth);
                }

                break;
//            case 'instructor':
//                break;
            default:
                return PARAM_URL_INVALID;
        }

        $stmnt->bindParam(':id', $id);

        try {
            $stmnt->execute();

            foreach ($stmnts as $sth) {
                $sth->bindParam(':m_id', $id);
                $sth->execute();
            }

        } catch (\PDOException $e) {
            if($e->getCode() == 23000) {
                return DB_NOT_ACCEPTABLE_DATA;
            }

            return REQUEST_FAILURE_DATA_INVALID;
        }

        $response = array_map(function($r) { return $r->rowCount() === 1; }, $stmnts);

        if($stmnt->rowCount() === 1 || in_array(true, $response)) {
            return REQUEST_SUCCESS;
        }

        return REQUEST_NOTHING_CHANGED;
    }

    public function getRegistrations($id) {
        $sql = "SELECT lesson_id, payment, time, DATE_FORMAT(date, '%d-%m-%Y') AS \"date\", location, max_persons, instructor_id, description, duration, extra_costs
                FROM registrations
                JOIN lessons
                ON registrations.lesson_id = lessons.id
                JOIN trainings 
                ON lessons.training_id = trainings.id
                WHERE registrations.member_id = :id";

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
}