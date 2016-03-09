<?php
namespace Application\Modules\Amazon\Services;

use Application\Exceptions\BadRequestException;
use Application\Modules\Amazon\Providers\ClientOrderProvider;
use Application\Exceptions\InternalServerErrorException;
use Application\Exceptions\ExportFactoryException;
use MarketplaceWebServiceOrders_Client as AmazonClient;

/**
 * Class OrderService
 *
 * @package Application\Modules\Amazon\Service
 * @link http://docs.developer.amazonservices.com/en_US/orders/2013-09-01/
 */
class OrderService {

    /**
     * Order's load path %s - date ISO
     *
     * @const SERVICE_LOAD_PATH
     */
    const SERVICE_LOAD_PATH = '/Orders/%s';

    /**
     * Pending Availability orders
     *
     * This status is available for pre-orders only. The order has been placed, payment has not been authorized,
     * and the release date of the item is in the future.
     * The order is not ready for shipment.
     * Note that Preorder is a possible OrderType value in Japan (JP) only.
     *
     * @const ORDER_STATUS_PENDING_AVAILABILITY
     */
    const ORDER_STATUS_PENDING_AVAILABILITY = 'PendingAvailability';

    /**
     * Pending orders.
     *
     * The order has been placed but payment has not been authorized.
     * The order is not ready for shipment. Note that for orders with OrderType = Standard,
     * the initial order status is Pending. For orders with OrderType = Preorder (available in JP only),
     * the initial order status is PendingAvailability,
     * and the order passes into the Pending status when the payment authorization process begins.
     *
     * @const ORDER_STATUS_PENDING
     */
    const ORDER_STATUS_PENDING = 'Pending';

    /**
     * Unshipped orders.
     *
     * Payment has been authorized and order is ready for shipment, but no items in the order have been shipped.
     *
     * @const ORDER_STATUS_UNSHIPPED
     */
    const ORDER_STATUS_UNSHIPPED = 'Unshipped';

    /**
     * Partially shipped orders.
     *
     * One or more (but not all) items in the order have been shipped.
     *
     * @const ORDER_STATUS_PARTIALLY_SHIPPED
     */
    const ORDER_STATUS_PARTIALLY_SHIPPED = 'PartiallyShipped';

    /**
     * Shipped orders.
     *
     * All items in the order have been shipped.
     *
     * @const ORDER_STATUS_SHIPPED
     */
    const ORDER_STATUS_SHIPPED = 'Shipped';

    /**
     * Invoice unconfirmed orders.
     *
     * All items in the order have been shipped.
     * The seller has not yet given confirmation to Amazon that the invoice has been shipped to the buyer.
     * Note: This value is available only in China (CN).
     *
     * @const ORDER_STATUS_INVOICE_UNCONFIRMED
     */
    const ORDER_STATUS_INVOICE_UNCONFIRMED = 'InvoiceUnconfirmed';

    /**
     * Canceled orders.
     *
     * The order was canceled.
     *
     * @const ORDER_STATUS_INVOICE_CANCELED
     */
    const ORDER_STATUS_INVOICE_CANCELED = 'Canceled';

    /**
     * Unfulfillable orders.
     *
     * The order cannot be fulfilled.
     * This state applies only to Amazon-fulfilled orders that were not placed on Amazon's retail web site.
     *
     * @const ORDER_STATUS_UNFULFILLABLE
     */
    const ORDER_STATUS_UNFULFILLABLE = 'Unfulfillable';

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
     * Client order provider
     *
     * @var \Application\Aware\Providers\Client $ClientOrderProvider
     */
    private $clientOrderProvider;

    /**
     * Init service
     *
     * @param \Application\Services\Db $db
     * @param array $config
     */
    public function __construct(\Application\Services\Db $db, array $config) {
        $this->db = $db;
        $this->config = $config;

        $this->config['export']['config']['ServiceURL'] = $this->config['export']['config']['ServiceURL']
            .sprintf(self::SERVICE_LOAD_PATH, $this->config['export']['auth']["applicationVersion"]);
    }

    /**
     * Amazon Order loader
     *
     * @param string $date
     * @return \MarketplaceWebServiceOrders_Model_ListOrdersResponse|void
     * @throws InternalServerErrorException
     */
    public function loadOrders($date = 'NOW') {

        try {

            // load client
            $this->clientOrderProvider = (new ClientOrderProvider(
                (new AmazonClient($this->config['export']['auth']['awsAccessKeyId'],
                    $this->config['export']['auth']['awsSecretAccessKey'],
                    $this->config['export']['auth']['applicationName'],
                    $this->config['export']['auth']['applicationVersion'],
                    $this->config['export']['config']
                )), $this->config['export']['auth']
            ));

            return $this->clientOrderProvider->getOrders($date, self::ORDER_STATUS_PENDING);

        }
        catch(BadRequestException $e) {
            throw new InternalServerErrorException($e->getMessage(), InternalServerErrorException::CODE);
        }
        catch(ExportFactoryException $e) {
            throw new InternalServerErrorException($e->getMessage(), InternalServerErrorException::CODE);
        }

    }
}