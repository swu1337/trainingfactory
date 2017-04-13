<?php
namespace dev\controllers;

use framework\controllers\AbstractController;

class InstructorController extends AbstractController
{
    public function __construct($control, $action, $message = NULL) {
        parent::__construct($control, $action, $message);
    }

    protected function defaultAction() {
        $this->view->set("gebruiker", $this->model->getGebruiker());
    }
    
    protected function plannenAction() {
        $this->view->set("gebruiker", $this->model->getGebruiker());
        
        $lessen=$this->model->getLessen();
        $this->view->set("lessen",$lessen);
        
        $trainingen=$this->model->getTrainings();
        $this->view->set("trainingen",$trainingen);
    }
}