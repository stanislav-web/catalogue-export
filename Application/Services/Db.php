<?php
namespace Application\Services;

use Application\Exceptions\InternalServerErrorException;

/**
 * Class Db
 *
 * @package Application\Services
 */
class Db {

    /**
     * Db connection
     *
     * @var null|\PDO
     */
    private $db = null;

    /**
     * Connect to database
     * @param array $config
     * @throws InternalServerErrorException
     */
    public function __construct(array $config) {

        try {

            $this->db = new \PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'], $config['username'], $config['password'], [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '".$config['charset']."'",
                \PDO::ATTR_CASE => \PDO::CASE_LOWER,
                \PDO::ATTR_ERRMODE => $config['debug'],
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
        }
        catch(\PDOException $e) {
            throw new InternalServerErrorException($e->getMessage(), InternalServerErrorException::CODE);
        }
    }
}