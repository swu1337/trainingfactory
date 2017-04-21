<?php
namespace dev\controllers;

use framework\controllers\AbstractController;

class BezoekerController extends AbstractController
{
    public function __construct($control, $action, $message = NULL) {
        parent::__construct($control, $action, $message);
    }

    protected function defaultAction() {
    }

    protected function inloggenAction() {
        if(!$this->model->isPostLeeg()) {
            switch ($this->model->controleerInloggen()) {
                case REQUEST_SUCCESS:
                    $this->view->set("msg", ["info" => "Welkom " . $_SESSION['gebruiker']->getName()]);
                    $recht = $this->model->getGebruiker()->getRole();
                    $this->forward("default", $recht);
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("msg", ["warning" => "Gegevens kloppen niet. Probeer opnieuw."]);
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("msg", ["warning" => "Niet alle gegevens ingevuld"]);
                    break;
            }
            $this->forward("default");
        }
    }

    protected function contactAction() {
    }
    
    protected function aanbodAction() {
        $soortTrainingen = $this->model->getSoortTrainingen();
        $this->view->set("soortTrainingen", $soortTrainingen);
    }
    
    protected function gedragsregelsAction() {
    }
       
    protected function registrerenAction() {
        if($this->model->isPostLeeg()) {
            $this->view->set("msg", ["info" => "Vul uw gegevens in om te registreren"]);
        } else {
            switch($this->model->registreren()) {
                case REQUEST_SUCCESS:
                    $this->view->set("msg", ["success" => "U bent successvol geregistreerd!"]);
                    $this->forward("default");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("formdata", $this->model->getFormData());
                    $this->view->set("msg", ["danger" => "Emailadres niet correct, Geboortedatum is niet in de juiste format of gebruikersnaam bestaat al"]);
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("formdata", $this->model->getFormData());
                    $this->view->set("msg", ["warning" => "Niet alle gegevens ingevuld"]);
                    break;
            }
        }    
    }
 }