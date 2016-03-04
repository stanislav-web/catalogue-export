<?php
namespace Application\Modules\Amazon\Providers;
use Application\Aware\Providers\Client;
use Application\Exceptions\ClientProviderException;
use MarketplaceWebServiceOrders_Client;
use MarketplaceWebServiceOrders_Model_ListOrdersRequest as ListOrderRequest;
use MarketplaceWebServiceOrders_Model_MarketplaceIdList as MarketplaceIdList;

/**
 * Class ClientProvider
 *
 * @package Application\Modules\Amazon\Providers
 */
class ClientProvider extends Client {

    /**
     * @var int $merchantId
     */
    protected $merchantId;

    /**
     * @var int $marketplaceId
     */
    protected $marketplaceId;

    /**
     * @var MarketplaceWebServiceOrders_Client $client
     */
    protected $client;

    /**
     * @var ListOrderRequest $request
     */
    protected $request;

    /**
     * @var array $merchant
     */
    protected $merchant;


    /**
     * Init client
     *
     * @param object $client
     * @param array $merchant
     * @throws ClientProviderException
     */
    public function __construct($client, array $merchant) {

        if(is_object($client) === false) {
            throw new ClientProviderException('Object error implementation', ClientProviderException::CODE);
        }

        // set client & merchant config
        $this->client = $client;
        $this->merchant = $merchant;

        // set marketplace id
        $marketplaceIdList = new MarketplaceIdList();
        $marketplaceIdList->setId([$this->merchant['marketplaceId']]);
        $this->request->setMarketplaceId($marketplaceIdList);

        // set request options
        $this->request = new ListOrderRequest();
        $this->request->setSellerId($this->merchant['merchantId']);
    }

    /**
     * Get order
     *
     * @return mixed
     */
    public function getOrder() {
        // TODO: Implement getOrder() method.
    }

    /**
     * List all orders updated after a certain date
     *
     * @param string $date
     * @param string       $status
     * @return \MarketplaceWebServiceOrders_Model_ListOrdersResponse
     */
    public function getOrders($date = 'NOW', $status) {

        $this->request->setCreatedAfter(new \DateTime($date, new \DateTimeZone('UTC')));
        return $this->client->listOrders($this->request);
    }

    /**
     * Get order items
     *
     * @return mixed
     */
    public function getOrderItems() {
        // TODO: Implement getOrderItems() method.
    }
}