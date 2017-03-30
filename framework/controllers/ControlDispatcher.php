<?php
namespace framework\controllers;

class ControlDispatcher 
{
    private $control;
    private $action;

    public function __construct($control, $action) {
        $this->control = $control;
        $this->action = $action;
    }

    public function dispatch() {
        $klasseNaam = BASE_NAMESPACE . 'controllers\\' . ucFirst($this->control) . 'Controller';
        if(!class_exists($klasseNaam)) {
            throw new \framework\error\FrameworkException("controller $klasseNaam bestaat niet!");
        }

        if(!is_subclass_of($klasseNaam,'\\framework\\controllers\\AbstractController')) {
            throw new \framework\error\FrameworkException
                        ("klas $klasseNaam implementeert overerft niet van framework AbstractController. dat is verplicht");
        }

        $controller = new $klasseNaam($this->control, $this->action);
        $controller->execute();
    }
}






