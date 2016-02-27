<?php
namespace Application\Modules\GoogleMerchant\Controllers;

use Application\Helpers\Filter;
use Application\Service\Db;
use Application\Service\View;

/**
 * Class ControllerBase
 *
 * @package Application\Controllers
 */
class ControllerBase {

    /**
     * Input request
     *
     * @var array $request
     */
    private $request;

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

        $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $this->request = Filter::filterRequestUrl($url);

        // set view templater
        $this->view = new View($config['services'][$this->request['path']['export']], $this->request['path']['view']);

        // setup database connect
        $this->db = new Db($config['database']);
    }

    /**
     * Return prepared request data
     *
     * @return array
     */
    protected function getRequest() {
        return $this->request;
    }
}