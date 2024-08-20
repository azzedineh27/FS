<?php
include_once "Controllers/Controller.php";

class Controller_contact extends Controller {
    public function action_afficher_contact() {
        // Code pour afficher la vue de contact
        $this->render('contact');
    }
    public function action_contact() {
        $this->redirect("contact/afficher_contact");
    }
    public function action_default(){
        $this->action_afficher_contact();
    }
}