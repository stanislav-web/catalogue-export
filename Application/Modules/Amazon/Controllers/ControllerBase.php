<?php
namespace Application\Modules\Amazon\Controllers;

use Application\Services\Db;
use Application\Services\View;
use Application\Services\Request;

/**
 * Class ControllerBase
 *
 * @package Application\Controllers
 */
class ControllerBase {

    /**
     * Request handler
     *
     * @var \Application\Services\Request $request
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
     * @var \Application\Services\View $view
     */
    protected $view;

    /**
     * Database instance
     *
     * @var \Application\Services\Db $db
     */
    protected $db;

    /**
     * Partner config
     *
     * @var array $partnerConfig
     */
    protected $partnerConfig;

    /**
     * Init & filtering request data
     */
    public function __construct() {

        global $config;

        // set configuration
        $this->config = $config;
        // set request handler
        $this->request = new Request();
        // set partner config
        $this->partnerConfig = $this->config['services'][$this->request->getExportPartner()];

        // set view templater
        $this->view = new View(
            $this->partnerConfig,
            $this->request->getShop(),
            $this->request->getViewType()
        );
        // setup database connect
        $this->db = new Db($this->config['database']);
    }
}