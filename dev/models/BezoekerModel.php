<?php
namespace dev\models;

use framework\models\AbstractModel;

class BezoekerModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }
    
    public function getSoortTrainingen()
    {
       $sql = 'SELECT * FROM `trainings`';
       $stmnt = $this->db->prepare($sql);
       $stmnt->execute();
       $soortTrainingen = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');    
       return $soortTrainingen;
    }
}