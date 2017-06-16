<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\OrderCheckingSuccess\Controller\Orders;

class Form extends \Magento\Framework\App\Action\Action
{
    /**
     * @return $this
     */
    public function execute()
    {
        return $this->resultRedirectFactory->create()->setPath('ordercheckingsuccess/orders');
    }
}