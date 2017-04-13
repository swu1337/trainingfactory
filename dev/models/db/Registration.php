<?php

namespace dev\models\db;

use framework\models\db\Entiteit;

class Registration extends Entiteit
{
    protected $lesson_id;
    protected $payment;
    protected $time;
    protected $date;
    protected $location;
    protected $max_persons;
    protected $instructor_id;
    protected $description;
    protected $duration;
    protected $extra_costs;
    protected $current_amount;

    public function __construct() {
        $this->lesson_id = filter_var($this->lesson_id, FILTER_VALIDATE_INT);
        $this->instructor_id = filter_var($this->instructor_id, FILTER_VALIDATE_INT);
    }
}