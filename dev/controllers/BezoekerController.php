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

    protected function contactAction(){     
    }
    
    protected function aanbodAction(){ 
       $soortTrainingen=$this->model->getSoortTrainingen();
       $this->view->set("soortTrainingen",$soortTrainingen); 
    }
    
    protected function gedragsregelsAction(){     
    }
    
    protected function registrerenAction(){     
    }
 }