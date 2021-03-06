<?php

namespace Tests\Unit\Factory\PaymentMethod;

use Faker\Factory as FakerFactory;
use Payroll\PaymentMethod\DirectMethod;
use Payroll\Factory\PaymentMethod\Factory as MethodFactory;
use Payroll\PaymentMethod\HoldMethod;
use Payroll\PaymentMethod\MailMethod;
use Payroll\Tests\TestCase;

class FactoryTest extends TestCase
{
    public function testCreateByDataMail()
    {
        $method = MethodFactory::createByData([
            'address' => $this->faker->address
        ]);

        $this->assertTrue($method instanceof MailMethod);
    }

    public function testCreateByDataDirect()
    {
        $method = MethodFactory::createByData([
            'bank' => $this->faker->company,
            'account' => $this->faker->bankAccountNumber
        ]);

        $this->assertTrue($method instanceof DirectMethod);
    }

    public function testCreateByDataNoDataDefaultMethod()
    {
        $method = MethodFactory::createByData();
        $this->assertTrue($method instanceof HoldMethod);
    }

    public function testCreateByDataInvalidData()
    {
        $method = MethodFactory::createByData([
            'invalid' => $this->faker->paragraph
        ]);

        $this->assertTrue($method instanceof HoldMethod);
    }
}
