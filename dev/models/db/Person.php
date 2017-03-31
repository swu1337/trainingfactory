<?php

namespace dev\models\db;

use framework\models\db\Entiteit;

class Person extends Entiteit
{
    protected $id;
    protected $loginname;
    protected $password;
    protected $fistname;
    protected $preprovision;
    protected $lastname;
    protected $dateofbirth;
    protected $gender;
    protected $emailaddress;
    protected $hiring_date;
    protected $salary;
    protected $street;
    protected $postalcode;
    protected $place;

    public function __construct() {
        $this->id = filter_var($this->id, FILTER_VALIDATE_INT);
    }
}