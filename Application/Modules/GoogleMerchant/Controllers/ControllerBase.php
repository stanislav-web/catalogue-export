<?php
namespace Application\Modules\GoogleMerchant\Controllers;

use Application\Helpers\Filter;
use Application\Service\Db;
use Application\Service\View;
use Application\Service\Request;

/**
 * Class ControllerBase
 *
 * @package Application\Controllers
 */
class ControllerBase {

    /**
     * Request handler
     *
     * @var \Application\Service\Request $request
     */
    private $request;

    /**
     * Configuration
     *
     * @var array $config
     */
    protected $config;

    /**
     * View service
     *
     * @var \Application\Service\View $view
     */
    protected $view;

    /**
     * Database instance
     *
     * @var \Application\Service\Db $db
     */
    protected $db;

    /**
     * Init & filtering request data
     */
    public function __construct() {

        global $config;

        // set configuration
        $this->config = $config;
        // set request handler
        $this->request = new Request();

        // set view templater
        $this->view = new View(
            $this->config['services'][$this->request->getExportPartner()],
            $this->request->getShop(),
            $this->request->getViewType()
        );
        // setup database connect
        $this->db = new Db($this->config['database']);
    }
}