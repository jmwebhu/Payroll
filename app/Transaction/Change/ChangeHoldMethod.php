<?php

namespace Payroll\Transaction\Change;

use Payroll\PaymentMethod\PaymentMethod;
use Payroll\PaymentMethod\Factory as MethodFactory;

class ChangeHoldMethod extends ChangePaymentMethod
{
    /**
     * @return PaymentMethod
     */
    protected function getPaymentMethod()
    {
        return MethodFactory::createByData();
    }
}
