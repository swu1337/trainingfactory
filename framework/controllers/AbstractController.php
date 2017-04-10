<?php
namespace framework\controllers;

use framework\error as ERROR;

abstract class AbstractController implements IController
{
    protected $control;
    protected $action; 
    protected $view;
    protected $model;
    
    public function __construct($control, $action) {
        $this->control = $control;
        $this->action = $action;
        $this->view = new \framework\view\View();
        $modelClassName = BASE_NAMESPACE . 'models\\'.ucfirst($this->control)."Model";

        if(!class_exists($modelClassName)) {
            throw new ERROR\FrameworkException("klasse $modelClassName bestaat niet!!!");  
        }

        if(!is_subclass_of($modelClassName,'\\framework\\models\\AbstractModel')) {
            throw new ERROR\FrameworkException("klasse $modelClassName erft niet van framework AbstractModel");
        }

        $this->model = new $modelClassName($control, $action);
        $gebruikersRecht = $this->model->getGebruikerRecht();

        if(!empty($message)) {
            $this->view->set('msg', $message);
        }

        if($gebruikersRecht !== $this->control) {
            $this->model->stopSession();
            $this->view->set('msg', 'je doet rare dingen met deze applicatie. Gebruik de gewone formulieren');
            $this->forward('default', DEFAULT_ROLE);
        }
    }
   
    
    public function execute() {
        $opdracht = $this->action . "Action";

        if(method_exists($this, $opdracht)) {
            $this->$opdracht();
            $this->view->setAction($this->action);
            $this->view->setControl($this->control);
            $this->view->toon();
        } else {
            $this->forward('default');
        }
    }
    
    protected function forward($action, $control = null) {
        $action = strtolower(trim($action));

        if(isset($control)) {
            
            $klasseNaam = BASE_NAMESPACE . 'controllers\\' . ucFirst($control) . 'Controller';
            if(!class_exists($klasseNaam)) {
                throw new ERROR\FrameworkException("klas $klasseNaam bestaat niet!!!");  
            }

            if(!is_subclass_of($klasseNaam,'\\framework\\controllers\\AbstractController')) {
                throw new ERROR\FrameworkException("klas $klasseNaam erft niet van framework AbstractController");
            }

            $controller = new $klasseNaam($control, $action);
        } else {
            $controller = $this;
            $this->action = $action;
            $this->model->setAction($this->action);
        }

        $controller->execute();
        exit();
    }

    protected abstract function defaultAction();

    protected function uitloggenAction() {
        list($url, $substring) = explode("?", $_SERVER['HTTP_REFERER']);
        header("Location: $url");
        $this->model->uitloggen();
        $this->forward('default', DEFAULT_ROLE);
    }
}


