<?php
namespace dev\controllers;

use framework\controllers\AbstractController;

class BezoekerController extends AbstractController
{
    public function __construct($control, $action, $message = NULL) {
        parent::__construct($control, $action, $message);
    }

    protected function defaultAction() {
        if(!$this->model->isPostLeeg()) {
            switch ($this->model->controleerInloggen()) {
                case REQUEST_SUCCESS:
                    $this->view->set("msg", "Welkom " . $_SESSION['gebruiker']->getName());
                    $recht = $this->model->getGebruiker()->getRole();
                    $this->forward("default", $recht);
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("msg", "Gegevens kloppen niet. Probeer opnieuw.");
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("msg", "Niet alle gegevens ingevuld");
                    break;
            }
        }
    }
}