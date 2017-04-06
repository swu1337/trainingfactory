<?php
namespace dev\models;

use framework\models\AbstractModel;

class BezoekerModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }

    public function controleerInloggen() {
        $ln =  filter_input(INPUT_POST, 'ln');
        $pw =  filter_input(INPUT_POST, 'pw');

        if($ln !== null && $pw !== null) {
            $sql = 'SELECT * FROM `persons` WHERE `loginname` = :ln AND `password` = :pw';
            $sth = $this->db->prepare($sql);
            $sth->bindParam(':ln', $ln);
            $sth->bindParam(':pw', $pw);
            $sth->execute();
            //var_dump($sth->fetchAll(\PDO::FETCH_ASSOC));
            $result = $sth->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__ . '\db\Person');

            if(count($result) === 1) {
                $this->startSession();
                $_SESSION['gebruiker'] = $result[0];
                return REQUEST_SUCCESS;
            }
            return REQUEST_FAILURE_DATA_INVALID;
        }
        return REQUEST_FAILURE_DATA_INCOMPLETE;
    }
}