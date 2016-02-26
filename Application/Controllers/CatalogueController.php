<?php
namespace Application\Controllers;

class CatalogueController extends ControllerBase {

    public function exportAction() {

        print_r($this->getRequest());
        echo 'OK';
    }
}