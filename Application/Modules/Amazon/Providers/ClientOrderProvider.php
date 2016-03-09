<?php
namespace Application\Modules\Amazon\Providers;
use Application\Aware\Providers\Client;
use Application\Exceptions\ClientProviderException;
use Application\Exceptions\InternalServerErrorException;
use MarketplaceWebServiceOrders_Model_ListOrdersRequest as ListOrderRequest;
use MarketplaceWebServiceOrders_Model_MarketplaceIdList as MarketplaceIdList;
use MarketplaceWebServiceOrders_Model_OrderStatusList as OrderStatusList;

/**
 * Class ClientOrderProvider
 *
 * @package Application\Modules\Amazon\Providers
 * @link https://github.com/plugmystore/amazon-mws-orders
 * @link https://images-na.ssl-images-amazon.com/images/G/01/mwsportal/doc/en_US/orders/2013-09-01/MWSOrdersApiReference._V361505966_.pdf
 **/
class ClientOrderProvider extends Client {

    /**
     * Amazon merchant Id
     *
     * @var int $merchantId
     */
    protected $merchantId;

    /**
     * Amazon Marketplace Id
     *
     * @var int $marketplaceId
     */
    protected $marketplaceId;

    /**
     * MarketplaceWebService order client
     *
     * @var \MarketplaceWebServiceOrders_Interface $client
     */
    protected $orderClient;

    /**
     * @var ListOrderRequest $request
     */
    protected $request;

    /**
     * Amazon merchant config
     *
     * @var array $merchantConfig
     */
    protected $merchantConfig;

    /**
     * Init client
     *
     * @param \MarketplaceWebServiceOrders_Interface $orderClient
     * @param array $merchantConfig
     * @throws ClientProviderException
     */
    public function __construct($orderClient, array $merchantConfig) {

        if(is_object($orderClient) === false) {
            throw new ClientProviderException('Object error implementation', ClientProviderException::CODE);
        }

        // set client & merchant config
        $this->orderClient = $orderClient;
        $this->merchantConfig = $merchantConfig;
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
     * @param string       $orderStatus
     * @link http://docs.developer.amazonservices.com/en_US/orders/2013-09-01/Orders_ListOrders.html
     * @link https://mws.amazonservices.ca/Orders/%s?Action=listOrders&SellerId=1&CreatedAfter=2016-02-23T14%3A06%3A41%2B0000&OrderStatus.Status.1=Pending&MarketplaceId.Id.1=1&AWSAccessKeyId=12124654645746765756&Timestamp=2016-02-23T14%3A06%3A41.000Z&Version=2013-09-01&SignatureVersion=2&SignatureMethod=HmacSHA256&Signature=g4xOYeHF5f9oIH8RPv5DIyw0QklnZmVDv10cKG3KdP8%3D
     * @return \MarketplaceWebServiceOrders_Model_ListOrdersResponse
     */
    public function getOrders($date = 'NOW', array $orderStatuses) {


        try {

            // ini list order request
            $this->request = new ListOrderRequest();

            // set marketplace id
            $this->request->setMarketplaceId($this->merchantConfig['marketplaceId']);

            // set seller id
            $this->request->setSellerId($this->merchantConfig['merchantId']);

            // set create order's date
            $this->request->setCreatedAfter(new \DateTime($date, new \DateTimeZone('UTC')));

            // set the order statuses
            $this->request->setOrderStatus($orderStatuses);

            return $this->orderClient->listOrders($this->request);
        }
        catch(\MarketplaceWebServiceOrders_Exception $e) {
            throw new InternalServerErrorException($e->getErrorMessage(), InternalServerErrorException::CODE);
        }

        /**
         * List Orders Action Sample
         * ListOrders can be used to find orders that meet the specified criteria.
         *
         * @param MarketplaceWebServiceOrders_Interface $service instance of MarketplaceWebServiceOrders_Interface
         * @param mixed $request MarketplaceWebServiceOrders_Model_ListOrders or array of parameters
//         */
//        function invokeListOrders(\MarketplaceWebServiceOrders_Interface $service, $request)
//        {
//            $response = $service->listOrders($request);
//
//            var_dump($response);
//            exit;
//            try {
//                $response = $service->listOrders($request);
//
//                echo ("Service Response\n");
//                echo ("=============================================================================\n");
//
//                echo("        ListOrdersResponse\n");
//                if ($response->isSetListOrdersResult()) {
//                    echo("            ListOrdersResult\n");
//                    $listOrdersResult = $response->getListOrdersResult();
//                    if ($listOrdersResult->isSetNextToken())
//                    {
//                        echo("                NextToken\n");
//                        echo("                    " . $listOrdersResult->getNextToken() . "\n");
//                    }
//                    if ($listOrdersResult->isSetCreatedBefore())
//                    {
//                        echo("                CreatedBefore\n");
//                        echo("                    " . $listOrdersResult->getCreatedBefore() . "\n");
//                    }
//                    if ($listOrdersResult->isSetLastUpdatedBefore())
//                    {
//                        echo("                LastUpdatedBefore\n");
//                        echo("                    " . $listOrdersResult->getLastUpdatedBefore() . "\n");
//                    }
//                    if ($listOrdersResult->isSetOrders()) {
//                        echo("                Orders\n");
//                        $orders = $listOrdersResult->getOrders();
//                        $orderList = $orders->getOrder();
//                        foreach ($orderList as $order) {
//                            echo("                    Order\n");
//                            if ($order->isSetAmazonOrderId())
//                            {
//                                echo("                        AmazonOrderId\n");
//                                echo("                            " . $order->getAmazonOrderId() . "\n");
//                            }
//                            if ($order->isSetSellerOrderId())
//                            {
//                                echo("                        SellerOrderId\n");
//                                echo("                            " . $order->getSellerOrderId() . "\n");
//                            }
//                            if ($order->isSetPurchaseDate())
//                            {
//                                echo("                        PurchaseDate\n");
//                                echo("                            " . $order->getPurchaseDate() . "\n");
//                            }
//                            if ($order->isSetLastUpdateDate())
//                            {
//                                echo("                        LastUpdateDate\n");
//                                echo("                            " . $order->getLastUpdateDate() . "\n");
//                            }
//                            if ($order->isSetOrderStatus())
//                            {
//                                echo("                        OrderStatus\n");
//                                echo("                            " . $order->getOrderStatus() . "\n");
//                            }
//                            if ($order->isSetFulfillmentChannel())
//                            {
//                                echo("                        FulfillmentChannel\n");
//                                echo("                            " . $order->getFulfillmentChannel() . "\n");
//                            }
//                            if ($order->isSetSalesChannel())
//                            {
//                                echo("                        SalesChannel\n");
//                                echo("                            " . $order->getSalesChannel() . "\n");
//                            }
//                            if ($order->isSetOrderChannel())
//                            {
//                                echo("                        OrderChannel\n");
//                                echo("                            " . $order->getOrderChannel() . "\n");
//                            }
//                            if ($order->isSetShipServiceLevel())
//                            {
//                                echo("                        ShipServiceLevel\n");
//                                echo("                            " . $order->getShipServiceLevel() . "\n");
//                            }
//                            if ($order->isSetShippingAddress()) {
//                                echo("                        ShippingAddress\n");
//                                $shippingAddress = $order->getShippingAddress();
//                                if ($shippingAddress->isSetName())
//                                {
//                                    echo("                            Name\n");
//                                    echo("                                " . $shippingAddress->getName() . "\n");
//                                }
//                                if ($shippingAddress->isSetAddressLine1())
//                                {
//                                    echo("                            AddressLine1\n");
//                                    echo("                                " . $shippingAddress->getAddressLine1() . "\n");
//                                }
//                                if ($shippingAddress->isSetAddressLine2())
//                                {
//                                    echo("                            AddressLine2\n");
//                                    echo("                                " . $shippingAddress->getAddressLine2() . "\n");
//                                }
//                                if ($shippingAddress->isSetAddressLine3())
//                                {
//                                    echo("                            AddressLine3\n");
//                                    echo("                                " . $shippingAddress->getAddressLine3() . "\n");
//                                }
//                                if ($shippingAddress->isSetCity())
//                                {
//                                    echo("                            City\n");
//                                    echo("                                " . $shippingAddress->getCity() . "\n");
//                                }
//                                if ($shippingAddress->isSetCounty())
//                                {
//                                    echo("                            County\n");
//                                    echo("                                " . $shippingAddress->getCounty() . "\n");
//                                }
//                                if ($shippingAddress->isSetDistrict())
//                                {
//                                    echo("                            District\n");
//                                    echo("                                " . $shippingAddress->getDistrict() . "\n");
//                                }
//                                if ($shippingAddress->isSetStateOrRegion())
//                                {
//                                    echo("                            StateOrRegion\n");
//                                    echo("                                " . $shippingAddress->getStateOrRegion() . "\n");
//                                }
//                                if ($shippingAddress->isSetPostalCode())
//                                {
//                                    echo("                            PostalCode\n");
//                                    echo("                                " . $shippingAddress->getPostalCode() . "\n");
//                                }
//                                if ($shippingAddress->isSetCountryCode())
//                                {
//                                    echo("                            CountryCode\n");
//                                    echo("                                " . $shippingAddress->getCountryCode() . "\n");
//                                }
//                                if ($shippingAddress->isSetPhone())
//                                {
//                                    echo("                            Phone\n");
//                                    echo("                                " . $shippingAddress->getPhone() . "\n");
//                                }
//                            }
//                            if ($order->isSetOrderTotal()) {
//                                echo("                        OrderTotal\n");
//                                $orderTotal = $order->getOrderTotal();
//                                if ($orderTotal->isSetCurrencyCode())
//                                {
//                                    echo("                            CurrencyCode\n");
//                                    echo("                                " . $orderTotal->getCurrencyCode() . "\n");
//                                }
//                                if ($orderTotal->isSetAmount())
//                                {
//                                    echo("                            Amount\n");
//                                    echo("                                " . $orderTotal->getAmount() . "\n");
//                                }
//                            }
//                            if ($order->isSetNumberOfItemsShipped())
//                            {
//                                echo("                        NumberOfItemsShipped\n");
//                                echo("                            " . $order->getNumberOfItemsShipped() . "\n");
//                            }
//                            if ($order->isSetNumberOfItemsUnshipped())
//                            {
//                                echo("                        NumberOfItemsUnshipped\n");
//                                echo("                            " . $order->getNumberOfItemsUnshipped() . "\n");
//                            }
//                            if ($order->isSetPaymentExecutionDetail()) {
//                                echo("                        PaymentExecutionDetail\n");
//                                $paymentExecutionDetail = $order->getPaymentExecutionDetail();
//                                $paymentExecutionDetailItemList = $paymentExecutionDetail->getPaymentExecutionDetailItem();
//                                foreach ($paymentExecutionDetailItemList as $paymentExecutionDetailItem) {
//                                    echo("                            PaymentExecutionDetailItem\n");
//                                    if ($paymentExecutionDetailItem->isSetPayment()) {
//                                        echo("                                Payment\n");
//                                        $payment = $paymentExecutionDetailItem->getPayment();
//                                        if ($payment->isSetCurrencyCode())
//                                        {
//                                            echo("                                    CurrencyCode\n");
//                                            echo("                                        " . $payment->getCurrencyCode() . "\n");
//                                        }
//                                        if ($payment->isSetAmount())
//                                        {
//                                            echo("                                    Amount\n");
//                                            echo("                                        " . $payment->getAmount() . "\n");
//                                        }
//                                    }
//                                    if ($paymentExecutionDetailItem->isSetPaymentMethod())
//                                    {
//                                        echo("                                PaymentMethod\n");
//                                        echo("                                    " . $paymentExecutionDetailItem->getPaymentMethod() . "\n");
//                                    }
//                                }
//                            }
//                            if ($order->isSetPaymentMethod())
//                            {
//                                echo("                        PaymentMethod\n");
//                                echo("                            " . $order->getPaymentMethod() . "\n");
//                            }
//                            if ($order->isSetMarketplaceId())
//                            {
//                                echo("                        MarketplaceId\n");
//                                echo("                            " . $order->getMarketplaceId() . "\n");
//                            }
//                            if ($order->isSetBuyerEmail())
//                            {
//                                echo("                        BuyerEmail\n");
//                                echo("                            " . $order->getBuyerEmail() . "\n");
//                            }
//                            if ($order->isSetBuyerName())
//                            {
//                                echo("                        BuyerName\n");
//                                echo("                            " . $order->getBuyerName() . "\n");
//                            }
//                            if ($order->isSetShipmentServiceLevelCategory())
//                            {
//                                echo("                        ShipmentServiceLevelCategory\n");
//                                echo("                            " . $order->getShipmentServiceLevelCategory() . "\n");
//                            }
//                            if ($order->isSetShippedByAmazonTFM())
//                            {
//                                echo("                        ShippedByAmazonTFM\n");
//                                echo("                            " . $order->getShippedByAmazonTFM() . "\n");
//                            }
//                            if ($order->isSetTFMShipmentStatus())
//                            {
//                                echo("                        TFMShipmentStatus\n");
//                                echo("                            " . $order->getTFMShipmentStatus() . "\n");
//                            }
//                        }
//                    }
//                }
//                if ($response->isSetResponseMetadata()) {
//                    echo("            ResponseMetadata\n");
//                    $responseMetadata = $response->getResponseMetadata();
//                    if ($responseMetadata->isSetRequestId())
//                    {
//                        echo("                RequestId\n");
//                        echo("                    " . $responseMetadata->getRequestId() . "\n");
//                    }
//                }
//
//                echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
//            } catch (\MarketplaceWebServiceOrders_Exception $ex) {
//                echo("Caught Exception: " . $ex->getMessage() . "\n");
//                echo("Response Status Code: " . $ex->getStatusCode() . "\n");
//                echo("Error Code: " . $ex->getErrorCode() . "\n");
//                echo("Error Type: " . $ex->getErrorType() . "\n");
//                echo("Request ID: " . $ex->getRequestId() . "\n");
//                echo("XML: " . $ex->getXML() . "\n");
//                echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
//            }
//        }
//        invokeListOrders($this->client, $this->request); exit;
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