<?php
namespace dev\controllers;

use framework\controllers\AbstractController;

class AdminController extends AbstractController
{
    public function __construct($control, $action, $message = NULL) {
        parent::__construct($control, $action, $message);
    }

    protected function defaultAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
    }

    protected function instructorsAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $this->view->set('instructors', $this->model->getPerson('instructors'));
    }

    protected function membersAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $this->view->set('members', $this->model->getPerson('members'));
    }

    protected function trainingsAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $this->view->set('trainings', $this->model->getTraining());
    }

    protected function trainingEditAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $request = $this->model->getTraining($_GET['id']);

        if(request !== PARAM_URL_INVALID) {
            $this->view->set('training', $request);
        } else {
            $this->view->set('msg', 'Invalid URL');
        }
    }
}