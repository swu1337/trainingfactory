<?php
namespace dev\models;

use framework\models\AbstractModel;

class InstructorModel extends AbstractModel
{
    public function __construct($control, $action) {
        parent::__construct($control, $action);
    }
    
    public function getLessen() {
       $sql = 'SELECT * FROM `lessons`';
       $stmnt = $this->db->prepare($sql);
       $stmnt->execute();
       $lessen = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Lesson');
       return $lessen;
    }
    
    public function getTrainings() {
       $sql = 'SELECT * FROM `trainings`';
       $stmnt = $this->db->prepare($sql);
       $stmnt->execute();
       $trainingen = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');
       return $trainingen;
    }
    
    public function lesMaken()
    {
        
        $datum = filter_input(INPUT_POST, 'datum');
        $tijd = filter_input(INPUT_POST, 'tijd');
        $sport = filter_input(INPUT_POST, 'sport');
        $lokaal = filter_input(INPUT_POST, 'lokaal');
        $aantal = filter_input(INPUT_POST, 'aantal');
        
        if(in_array(NULL,$datum, $tijd,$sport ,$lokaal ,$aantal[])) {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }

        $sql=   "INSERT INTO `persons` (loginname,firstname,preprovision,lastname, 
                dateofbirth,email_address,gender,street,postal_code,place,role,password)VALUES (:gebruikersnaam,:voornaam,:tussenvoegsel,:achternaam, 
                :geboortedatum,:email,:geslacht,:straat,:postcode,:stad,'member',:wachtwoord) ";
            
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':datum', $datum);
        $stmnt->bindParam(':tijd', $tijd);
        $stmnt->bindParam(':sport', $sport);
        $stmnt->bindParam(':lokaal', $lokaal);
        $stmnt->bindParam(':aantal', $aantal);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($stmnt->rowCount() === 1)
        {            
           ; return REQUEST_SUCCESS;
        }
        //return REQUEST_FAILURE_DATA_INVALID; 
    }
}