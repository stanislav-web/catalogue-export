<?php
namespace Application\Modules\Amazon\Services;

use Application\Modules\Amazon\Providers\ClientProvider;
use Application\Exceptions\InternalServerErrorException;
use Application\Exceptions\ExportFactoryException;
use MarketplaceWebServiceOrders_Client as AmazonClient;

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
     * Export provider
     *
     * @var \Application\Aware\Providers\Export $exportProvider
     */
    private $exportProvider;

    /**
     * Export provider
     *
     * @var \Application\Aware\Providers\Client $clientProvider
     */
    private $clientProvider;

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

            // load client
            $this->clientProvider = (new ClientProvider(
                (new AmazonClient($this->config['export']['auth']['awsAccessKeyId'],
                    $this->config['export']['auth']['awsSecretAccessKey'],
                    $this->config['export']['auth']['applicationName'],
                    $this->config['export']['auth']['applicationVersion'],
                    $this->config['export']['config']
                )), $this->config['export']['auth']
            ));

            //var_dump($this->clientProvider->getOrders()); exit;
        }
        catch(ExportFactoryException $e) {
            throw new InternalServerErrorException($e->getMessage(), InternalServerErrorException::CODE);
        }

    }
}