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
        $request = $this->model->getObject('instructor');

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
        $request = $this->model->getObject('member');

        if(is_int($request)) {
            switch($request) {
                case PARAM_URL_INCOMPLETE:
                    $this->view->set('msg', 'Incomplete URL Parameters');
                    break;
                case PARAM_URL_INVALID:
                    $this->view->set('msg', 'Invalid URL Parameters');
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

    protected function editAction() {
        $this->view->set('gebruiker', $this->model->getGebruiker());
        $prop = $_GET['prop'];

        switch ($prop) {
            case 'instructor':
                $requests['instructor'] = $this->model->getObject('person', $_GET['id']);
                break;
            case 'member':
                $requests['member'] = $this->model->getObject('person', $_GET['id']);
                $requests['registrations'] = $this->model->getRegistrations($_GET['id']);
                break;
            case 'training':
                $requests['training'] = $this->model->getObject('training', $_GET['id']);
                break;
            default :
                $requests[] = PARAM_URL_INVALID;
        }

        foreach ($requests as $request => $value) {
            if(is_array($value) || is_object($value)) {
                $this->view->set($request, $value);
            } else {
                switch($value) {
                    case PARAM_URL_INCOMPLETE:
                        $this->view->set('msg', 'Incomplete URL Parameters');
                        break;
                    case PARAM_URL_INVALID:
                        $this->view->set('msg', 'Invalid URL Parameters');
                        break;
                    case REQUEST_NO_DATA:
                        $this->view->set($request, null);
                }
            }
        }

        if(!$this->model->isPostLeeg()) {
            switch ($prop) {
                case 'instructor':
                    $request = $this->model->edit('instructor', $_GET['id']);
                    break;
                case 'member':
                    $request = $this->model->edit('member', $_GET['id']);
                    break;
                case 'training':
                    $request = $this->model->edit('training', $_GET['id']);
                    break;
                default:
                    $request = PARAM_URL_INCOMPLETE;
            }

            switch ($request) {
                case REQUEST_SUCCESS:
                    $this->view->set("msg", "De $prop is gewijzigd");
                    $this->forward($prop . 's');
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("msg", "Fout invoer");
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("msg", "Niet alle gegevens zijn ingevuld!");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("msg", "Er niks te wijzigen");
                    break;
                case PARAM_URL_INCOMPLETE:
                    $this->view->set('msg', 'Incomplete URL Parameters');
                    break;
                case PARAM_URL_INVALID:
                    $this->view->set('msg', 'Invalid URL Parameters');
                    break;
                case DB_NOT_ACCEPTABLE_DATA:
                    $this->view->set('msg', 'Email of Gebruikersnaam is al in gebruik');
            }
        }
    }

    protected function deleteAction() {
        $prop = $_GET['prop'];
        switch ($prop) {
            case 'instructor':
                $request = $this->model->delete('instructor', $_GET['id']);
                break;
            case 'member':
                $request = $this->model->delete('member', $_GET['id']);
                break;
            case 'training':
                $request = $this->model->delete('training', $_GET['id']);
                break;
            default :
                $request = PARAM_URL_INCOMPLETE;
        }

        switch ($request) {
            case REQUEST_SUCCESS:
                $this->view->set("msg", "De geselecteerde $prop is verwijderd!");
                break;
            case REQUEST_FAILURE_DATA_INVALID:
                $this->view->set("msg", "De request naar de server is niet voldaan");
                break;
            case REQUEST_FAILURE_DATA_INCOMPLETE:
                $this->view->set("msg", "De geselecteerde $prop bestaat niet");
                break;
            case PARAM_URL_INVALID:
                $this->view->set('msg', 'Invalid URL Parameters');
                break;
            case PARAM_URL_INCOMPLETE:
                $this->view->set('msg', 'Incomplete URL Parameters');
                break;
        }

        $this->forward($prop . 's');
    }
    }