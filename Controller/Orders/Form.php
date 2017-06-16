<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\OrderCheckingSuccess\Controller\Orders;

class Form extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\RedirectFactory
     */
    protected $redirectFactory;

    /**
     * Form constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\StateInterface $cacheState
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return $this
     */
    public function execute()
    {
        return $this->redirectFactory->create()->setPath('ordercheckingsuccess/orders');
    }
}