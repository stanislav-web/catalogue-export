<?php
namespace Application\Aware\Providers;

/**
 * Class Provider
 *
 * @package Application\Aware\Providers
 */
abstract class Client {

    /**
     * @param object $client
     * @param array $merchant
     */
    abstract public function __construct($client, array $merchant);

    /**
     * Get order
     *
     * @return mixed
     */
    abstract function getOrder();

    /**
     * List all orders updated after a certain date
     *
     * @param string $orderDate
     * @param array $orderStatuses
     * @return void
     */
    abstract function getOrders($orderDate = 'NOW', array $orderStatuses);

    /**
     * Get order items
     *
     * @return mixed
     */
    abstract function getOrderItems();
}