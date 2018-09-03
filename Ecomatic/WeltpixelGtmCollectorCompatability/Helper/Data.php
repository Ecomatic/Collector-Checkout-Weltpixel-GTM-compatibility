<?php

namespace Ecomatic\WeltpixelGtmCollectorCompatability\Helper;

class Data extends \WeltPixel\GoogleTagManager\Helper\Data 
{
    
    public function addCheckoutInformation()
    {
        $requestPath = $this->_request->getModuleName() .
            DIRECTORY_SEPARATOR . $this->_request->getControllerName() .
            DIRECTORY_SEPARATOR . $this->_request->getActionName();

        if ($requestPath == 'checkout/index/index' || $requestPath == 'firecheckout/index/index' || $requestPath == 'collectorcheckout/index/index') {
            $checkoutBlock = $this->createBlock('Checkout', 'checkout.phtml');

            if ($checkoutBlock) {
                $quote = $this->checkoutSession->getQuote();
                $checkoutBlock->setQuote($quote);
                $checkoutBlock->toHtml();
            }
        }
    }
    
    /**
     * Set purchase details
     */
    public function addOrderInformation()
    {
        $lastOrderId = $this->checkoutSession->getLastOrderId();
        $requestPath = $this->_request->getModuleName() .
            DIRECTORY_SEPARATOR . $this->_request->getControllerName() .
            DIRECTORY_SEPARATOR . $this->_request->getActionName();

        if (($requestPath != 'collectorcheckout/success/index' && $requestPath != 'checkout/onepage/success') || !$lastOrderId) {
            return;
        }
        $orderBlock = $this->createBlock('Order', 'order.phtml');
        if ($orderBlock) {
            $order = $this->orderRepository->get($lastOrderId);
            $orderBlock->setOrder($order);
            $orderBlock->toHtml();
        }
    }
}