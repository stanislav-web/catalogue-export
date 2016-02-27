<?php
namespace Application\Modules\GoogleMerchant\Controllers;

use Application\Modules\GoogleMerchant\Services\ProductService;

/**
 * Class CatalogueController
 *
 * @package Application\Modules\GoogleMerchant\Controllers
 */
class CatalogueController extends ControllerBase {

    /**
     * @var \Application\Modules\GoogleMerchant\Services\ProductService $productService
     */
    private $productService;

    /**
     * Initialize services
     */
    public final function __construct() {

        parent::__construct();
        $this->productService = new ProductService($this->db);
    }
    /**
     * Export catalogue action
     */
    public function exportAction() {


        var_dump($this->productService); exit;
        $this->view->set('test', '123456789')->output();
    }
}