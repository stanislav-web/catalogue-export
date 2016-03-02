<?php
namespace Application\Modules\Amazon\Services;

/**
 * Class ProductService
 *
 * @package Application\Modules\Amazon\Service
 */
class ProductService {

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