<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\OrderCheckingSuccess\Block;

class Main extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Main constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->customerSession = $customerSession;
    }

    /**
     * Construct
     */
    protected function _construct()
    {
        parent::_construct();
    }
    /**
     * @return mixed
     */
    /**
     * @return $this
     */
    public function _prepareLayout()
    {
        parent::_prepareLayout();
        return $this;
    }

    /**
     * @return bool
     */
    public function isCustomerLogedIn()
    {
        if ($this->customerSession->isLoggedIn()) {
            return true;
        } else
            return false;
    }
}