<?php
namespace Application\Modules\Amazon\Services;

use Application\Exceptions\InternalServerErrorException;
use Application\Aware\Factories\ResponderFactory;
use Application\Exceptions\ResponderFactoryException;

/**
 * Class OrderService
 *
 * @package Application\Modules\Amazon\Service
 */
class OrderService {

    /**
     * Db service
     *
     * @var \Application\Services\Db $db
     */
    private $db;

    /**
     * Configurations
     *
     * @var array $config
     */
    private $config;

    /**
     * Respond provider
     *
     * @var \Application\Aware\Providers\Export $respondProvider
     */
    private $respondProvider;

    /**
     * Init service
     *
     * @param \Application\Services\Db $db
     * @param array $config
     */
    public function __construct(\Application\Services\Db $db, array $config) {
        $this->db = $db;
        $this->config = $config;
    }

    public function loadOrders() {

        try {

            $this->respondProvider = (new ResponderFactory($this->config['export']))->load();
            $loader = $this->respondProvider->loadSource();

            return $loader->getData();
            //return new
        }
        catch(ResponderFactoryException $e) {
            throw new InternalServerErrorException($e->getMessage(), InternalServerErrorException::CODE);
        }

    }
}