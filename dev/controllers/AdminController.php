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
        $request = $this->model->getObject('person');

        if(is_int($request)) {
            switch($request) {
                case PARAM_URL_INCOMPLETE:
                    $this->view->set('msg', 'Invalid URL Parameters');
                    break;
                case PARAM_URL_INVALID:
                    $this->view->set('msg', 'Incomplete URL Parameters');
                    break;
            }
        } else {
            $this->view->set('instructors', $request);
        }
    }

    protected function membersAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $request = $this->model->getObject('person');

        if(is_int($request)) {
            switch($request) {
                case PARAM_URL_INCOMPLETE:
                    $this->view->set('msg', 'Invalid URL Parameters');
                    break;
                case PARAM_URL_INVALID:
                    $this->view->set('msg', 'Incomplete URL Parameters');
                    break;
            }
        } else {
            $this->view->set('members', $request);
        }
    }

    protected function trainingsAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $request = $this->model->getObject('training');

        if(is_int($request)) {
            switch($request) {
                case PARAM_URL_INCOMPLETE:
                    $this->view->set('msg', 'Invalid URL Parameters');
                    break;
                case PARAM_URL_INVALID:
                    $this->view->set('msg', 'Incomplete URL Parameters');
                    break;
            }
        } else {
            $this->view->set('trainings', $request);
        }
    }

    protected function trainingEditAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $request = $this->model->getObject('training', $_GET['id']);

        if(is_int($request)) {
            switch($request) {
                case PARAM_URL_INCOMPLETE:
                    $this->view->set('msg', 'Invalid URL Parameters');
                    break;
                case PARAM_URL_INVALID:
                    $this->view->set('msg', 'Incomplete URL Parameters');
                    break;
            }
        } else {
            $this->view->set('training', $request);
        }
    }

    protected function editAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $prop = $_GET['prop'];
        switch ($prop) {
            case 'instructor':
                $request = $this->model->getObject('person', $_GET['id']);
                break;
            case 'member':
                $request = $this->model->getObject('person', $_GET['id']);
                break;
            case 'training':
                $request = $this->model->getObject('training', $_GET['id']);
                break;
        }

        if(is_int($request)) {
            switch($request) {
                case PARAM_URL_INCOMPLETE:
                    $this->view->set('msg', 'Invalid URL Parameters');
                    break;
                case PARAM_URL_INVALID:
                    $this->view->set('msg', 'Incomplete URL Parameters');
                    break;
            }
        } else {
            $this->view->set("$prop", $request);
        }
    }
}