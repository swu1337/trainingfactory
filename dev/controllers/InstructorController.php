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
        $this->view->set("trainingen", $this->model->getTrainings());

        if(!$this->model->isPostLeeg()) {
            switch ($this->model->lesMaken()) {
                case REQUEST_SUCCESS:
                    $this->view->set("msg", "Les is toegevoegd");
                    $_POST = [];
                    $this->forward("plannen");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("msg", "Fout invoer");
                    $this->view->set("f_data", $this->model->getFormData());
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("msg", "Niet alles is ingevuld");
                    $this->view->set("f_data", $this->model->getFormData());
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("msg", "Er geen les toegevoegd");
                    break;
            }
        }
    }

    protected function lessenAction() {
        $this->view->set("gebruiker", $this->model->getGebruiker());
        $this->view->set("lessen", $this->model->getLessons());
    }
}