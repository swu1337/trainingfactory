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
        $this->view->set("lessons", $this->model->getAllLessons());
    }
    
    protected function gegevensWijzigenAction() {
        $this->view->set("gebruiker", $this->model->getGebruiker());

        if($this->model->isPostLeeg()) {
            $this->view->set("msg", "Vul uw gegevens in");
        } else {
            switch($this->model->wijziggegevens()) {
                case REQUEST_SUCCESS:
                     $this->view->set("msg", "U heeft successvol uw gegevens gewijzigd!");
                     $this->forward("default");
                     break;
                case REQUEST_FAILURE_DATA_INVALID:
                     $this->view->set('form_data',$_POST);
                     $this->view->set("msg", "Emailadres niet correct of gebruikersnaam bestaat al");
                     break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                     $this->view->set('form_data',$_POST);
                     $this->view->set("msg", "Niet alle gegevens zijn ingevuld");
                     break;     
            }
        }
    }
}