<?php
namespace dev\controllers;

use framework\controllers\AbstractController;

class MemberController extends AbstractController
{
    public function __construct($control, $action, $message = NULL) {
        parent::__construct($control, $action, $message);
    }

    protected function defaultAction() {
        $this->view->set("gebruiker", $this->model->getGebruiker());
    }
    
    protected function inschrijvenAction() {
        $this->view->set("gebruiker", $this->model->getGebruiker());
    }
    
}