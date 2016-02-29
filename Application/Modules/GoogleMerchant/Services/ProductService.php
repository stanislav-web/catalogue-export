<?php
namespace Application\Modules\GoogleMerchant\Services;

use Application\Service\Db;

/**
 * Class ProductService
 *
 * @package Application\Modules\GoogleMerchant\Service
 */
class ProductService {

    /**
     * Db service
     *
     * @var \Application\Service\Db $db
     */
    protected $db;

    /**
     * Init db connection
     * @param \Application\Service\Db $db
     */
    public function __construct(\Application\Service\Db $db) {
        $this->db = $db;
    }
}