<?php
namespace Application\Service;

use Application\Aware\Filter;
use Application\Exceptions\BadRequestException;

/**
 * Class Request
 *
 * @package Application\Service
 */
class Request {

    /**
     * @var string $url
     */
    private $url;

    /**
     * Query params
     *
     * @var array $params
     */
    private $params;

    use Filter;

    /**
     * Setup requested url
     */
    public function __construct() {
        $this->url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $this->params = $this->filterRequestUrl($this->url);
    }

    /**
     * Get export partner
     *
     * @return string
     * @throws BadRequestException
     */
    public function getExportPartner() {

        if(isset($this->params['path']['export']) === false) {
            throw new BadRequestException('Could not find export path', BadRequestException::CODE);
        }

        return $this->params['path']['export'];
    }

    /**
     * Get shop
     *
     * @return string
     * @throws BadRequestException
     */
    public function getShop() {

        $shop = (isset($this->params['path']['catalogue']) === false) ? $this->params['path']['order'] : $this->params['path']['catalogue'];
        if(empty($shop)) {
            throw new BadRequestException('Could not find shop in request', BadRequestException::CODE);
        }

        return $shop;
    }

    /**
     * Get view type
     *
     * @return string
     * @throws BadRequestException
     */
    public function getViewType() {

        if(isset($this->params['path']['view']) === false) {
            throw new BadRequestException('Could not find view path', BadRequestException::CODE);
        }
        return $this->params['path']['view'];
    }
}