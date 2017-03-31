<?php
namespace dev\models\db;

use framework\models\db\Entiteit;

class Lesson extends Entiteit
{
    protected $id;
    protected $description;
    protected $duration;
    protected $extra_costs;
    protected $instructor_id;
    protected $training_id;

    public function __construct() {
        $this->id = filter_var($this->id, FILTER_VALIDATE_INT);
        $this->instructor_id = filter_var($this->instructor_id, FILTER_VALIDATE_INT);
        $this->training_id = filter_var($this->training_id, FILTER_VALIDATE_INT);
    }
}