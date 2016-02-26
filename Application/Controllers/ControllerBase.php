<?php
namespace Application\Controllers;

use Application\Helpers\Filter;

/**
 * Class ControllerBase
 *
 * @package Application\Controllers
 */
class ControllerBase {

    /**
     * Input request
     *
     * @var $request array
     */
    private $request;

    /**
     * Init & filtering request data
     */
    public function __construct() {
        $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER[HTTP_HOST]}{$_SERVER[REQUEST_URI]}";
        $this->request = Filter::filterRequestUrl($url);
    }


    protected function getRequest() {
        return $this->request;
    }
}