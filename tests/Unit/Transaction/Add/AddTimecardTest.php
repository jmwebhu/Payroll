<?php

namespace Payroll\Tests\Unit\Transaction;

use Faker\Factory;
use Payroll\Employee;
use Payroll\PaymentClassification\HourlyClassification;
use Payroll\Tests\TestCase;
use Payroll\Factory\Employee as EmployeeFactory;
use Payroll\Transaction\Add\AddTimeCard;

class AddTimeCardTest extends TestCase
{
    /**
     * @var Generator
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function testExecute()
    {
        $employee = new Employee;
        $employee->name = $this->faker->name;
        $employee->address = $this->faker->address;
        $employee->hourly_rate = $this->faker->randomFloat(2, 10, 30);
        $employee->type = EmployeeFactory::HOURLY;
        $employee->save();

        $transaction = new AddTimeCard((new \DateTime())->format('Y-m-d'), 8.0, $employee);
        $transaction->execute();

        /**
         * @var HourlyClassification $paymentClassification
         */
        $paymentClassification = $employee->getPaymentClassification();
        $this->assertTrue($paymentClassification instanceof HourlyClassification);

        $timeCard = $paymentClassification->getTimeCard((new \DateTime())->format('Y-m-d'));
        $this->assertEquals(8.0, $timeCard->hours);
        $this->assertEquals($employee->getId(), $timeCard->employee_id);
    }

    public function testExecuteInvalidUser()
    {
        $employee = new Employee;
        $employee->name = $this->faker->name;
        $employee->address = $this->faker->address;
        $employee->salary = $this->faker->randomFloat(2, 1000, 3000);
        $employee->type = EmployeeFactory::SALARIED;
        $employee->save();

        $transaction = new AddTimeCard((new \DateTime())->format('Y-m-d'), 8.0, $employee);

        try {
            $transaction->execute();
            $this->fail();
        } catch (\Exception $ex) {
            $this->assertEquals('Tried to add time card to non-hourly employee', $ex->getMessage());
        }

    }
}