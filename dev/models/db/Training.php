<?php

namespace dev\models\db;

use framework\models\db\Entiteit;

class Training extends Entiteit
{
    protected $id;
    protected $time;
    protected $date;
    protected $location;
    protected $max_persons;

    public function __construct() {
        $this->id = filter_var($this->id, FILTER_VALIDATE_INT);
    }
}