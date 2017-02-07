<?php

namespace Payroll\Transaction\Add;

use Payroll\Contract\Employee;
use Payroll\PaymentClassification\Factory as ClassificationFactory;
use Payroll\PaymentClassification\PaymentClassification;
use Payroll\PaymentSchedule\Factory as ScheduleFactory;
use Payroll\PaymentSchedule\PaymentSchedule;

class AddSalariedEmployee extends AddEmployee
{
    /**
     * @var
     */
    private $salary;

    /**
     * AddSalariedEmployee constructor.
     * @param $name
     * @param $address
     * @param $hourlyRate
     */
    public function __construct($name, $address, $hourlyRate)
    {
        parent::__construct($name, $address);
        $this->salary = $hourlyRate;
    }

    /**
     * @return PaymentClassification
     */
    protected function getPaymentClassification()
    {
        return ClassificationFactory::createClassificationByData([
            'salary' => $this->salary
        ]);
    }

    /**
     * @return PaymentSchedule
     */
    protected function getPaymentSchedule()
    {
        return ScheduleFactory::createScheduleByData([
            'salary' => $this->salary
        ]);
    }

    /**
     * @return Employee
     */
    protected function createEmployee()
    {
        $employee = parent::createEmployee();
        $employee->setSalary($this->salary);
        $employee->setType(self::SALARIED);
        $employee->save();

        return $employee;
    }
}