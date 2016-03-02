<?php
namespace Application\Modules\GoogleMerchant\Services;

/**
 * Class OrderService
 *
 * @package Application\Modules\GoogleMerchant\Service
 */
class OrderService {

    /**
     * Db service
     *
     * @var \Application\Services\Db $db
     */
    protected $db;

    /**
     * Init db connection
     * @param \Application\Services\Db $db
     */
    public function __construct(\Application\Services\Db $db) {
        $this->db = $db;
    }
}