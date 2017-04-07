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
        $this->view->set('trainings', $this->model->getTraining('trainings'));
    }

    protected function trainingEditAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $request = $this->model->getTraining((int)$_GET['id']);
        switch ($request) {
            case PARAM_URL_INVALID:
                $this->view->set('msg', 'Invalid URL');
                break;
            case PARAM_URL_INCOMPLETE:
                $this->view->set('msg', 'URL missing parameters');
                break;
            default: return;
        }

        $this->view->set('training', $this->model->getTraining($_GET['id']));
    }
}