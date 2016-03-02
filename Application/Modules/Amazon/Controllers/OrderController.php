<?php
namespace Application\Modules\Amazon\Controllers;

use Application\Modules\Amazon\Services\OrderService;

/**
 * Class CatalogueController
 *
 * @package Application\Modules\Amazon\Controllers
 */
class OrderController extends ControllerBase {

    /**
     * Order service
     *
     * @var \Application\Modules\Amazon\Services\OrderService $orderService
     */
    private $orderService;

    /**
     * Initialize services
     */
    public final function __construct() {

        parent::__construct();

        $this->orderService = new OrderService($this->db, $this->partnerConfig);
    }
    /**
     * Export catalogue action
     */
    public function exportAction() {

        // load orders
        $orders = $this->orderService->loadOrders();

        //@todo collect to view
        if($this->view->isCached() === false) {

            // save to cache
            $content = $this->view->output();
            return $this->view->cache($content);
        }
        
        return $this->view->output();
    }

}