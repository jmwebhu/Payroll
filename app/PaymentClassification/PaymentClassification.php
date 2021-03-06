<?php

namespace Payroll\PaymentClassification;

use Payroll\Contract\Employee;
use Payroll\Contract\Paycheck;


abstract class PaymentClassification
{
    /**
     * @var Employee
     */
    protected $employee = null;

    /**
     * @return Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     */
    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * @param Paycheck $paycheck
     * @return float
     */
    abstract public function calculatePay(Paycheck $paycheck);

    /**
     * @return string
     */
    abstract public function getType();

    /**
     * @param Employee $employee
     */
    abstract public function setEmployeeData(Employee $employee);
}