<?php

include_once "Controllers/Controller.php";

include_once "Model/Model_car.php";

class Controller_accueil extends Controller {

    public function action_accueil() {
        $this->render('view_accueil');
    }
    
    public function action_default() {
        $this->action_accueil();
    }
}
