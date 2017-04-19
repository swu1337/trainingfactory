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
    
    protected function inschrijvingenoverzichtAction() {
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker', $gebruiker);
        $request = $this->model->getRegistrations($gebruiker->getId());

        if(is_int($request)) {
            switch($request) {
                case REQUEST_NO_DATA:
                    $this->view->set('registrations', null);
                    break;
                case PARAM_URL_INVALID:
                    $this->view->set('msg', 'Invalid URL Parameters');
                    break;
            }
        } else {
            $this->view->set('registrations', $request);
        }
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
                    $this->view->set("msg", "Emailadres niet correct of gebruikersnaam bestaat al");
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("msg", "Niet alle gegevens zijn ingevuld");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("msg", "Er niks te wijzigen");
                    break;
            }
        }
    }

    protected function uitschrijvenAction() {
        switch ($this->model->lesUitschrijven($_GET['id'])) {
            case REQUEST_SUCCESS:
                $this->view->set("msg", "U heeft voor de les uitgeschreven.");
                break;
            case REQUEST_FAILURE_DATA_INVALID:
                $this->view->set("msg", "De request naar de server is niet voldaan");
                break;
            case REQUEST_NOTHING_CHANGED:
                $this->view->set("msg", "Er niks te uitschrijven");
                break;
            case PARAM_URL_INCOMPLETE:
                $this->view->set('msg', 'Incomplete URL Parameters');
                break;
        }

        $this->forward('inschrijvingenoverzicht');
    }
}