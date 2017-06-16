<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magestore\OrderCheckingSuccess\Controller\Orders;

class Check extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    protected $orderConfig;

    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $customer;

    /**
     * Check constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Sales\Model\Order\Config $orderConfig
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->orderConfig = $orderConfig;
    }


    public function execute()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $email = $this->getRequest()->getParam('email');
        $this->customer = $this->_objectManager->get('Magento\Customer\Model\Customer');
        $this->storeManager = $this->_objectManager->get('\Magento\Store\Model\StoreManager');

        if ($this->customerSession->isLoggedIn()) {
            $customerId = $this->customerSession->getCustomerId();
        } else {
            $customerId = $this->customer->setWebsiteId($this->storeManager->getWebsite()->getWebsiteId())->loadByEmail($email)->getId();
        }
        if (!$customerId)
            $customerId = $email;

        $order = $this->checkOrderByIdAndCustomerId($orderId, $customerId);

        if (count($order->getData())) {
            $order = $this->_objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);
            $registry = $this->_objectManager->get('\Magento\Framework\Registry');
            $registry->register('current_order', $order);
            $registry->register('customer_id', $customerId);

            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        } else {
            $this->messageManager->addErrorMessage(
                __('Sales not found!')
            );
            $this->_redirect('*/*/index');
        }
    }

    private function checkOrderByIdAndCustomerId($orderId, $customerId)
    {
        /** @var \Magento\Sales\Model\ResourceModel\Order\Collection $orderCollection */
        $orderCollection = $this->orderCollectionFactory->create();
        $data = $orderCollection
            ->addAttributeToSelect(
                '*'
            )->addFieldToFilter(
                ['customer_id', 'customer_email'],
                [['like' => $customerId], ['like' => $customerId]]
            )->addAttributeToFilter(
                'increment_id',
                $orderId
            )->addAttributeToFilter(
                'status',
                ['in' => $this->orderConfig->getVisibleOnFrontStatuses()]
            )->load();
        return $data;
    }
}