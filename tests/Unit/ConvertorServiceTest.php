<?php

namespace Tests\Unit;

use App\Services\Convertor as ConvertorService;
use Tests\TestCase;

class ConvertorServiceTest extends TestCase
{
    public function testConvertAmountToWords_0()
    {
        $service = new ConvertorService();
        $this->assertEquals('Zero Dollars', $service->convertAmountToWords('0'));
    }

    public function testConvertAmountToWords_point0()
    {
        $service = new ConvertorService();
        $this->assertEquals('Zero Dollars', $service->convertAmountToWords('.00'));
    }

    public function testConvertAmountToWords_0point00()
    {
        $service = new ConvertorService();
        $this->assertEquals('Zero Dollars', $service->convertAmountToWords('0.00'));
    }

    public function testConvertAmountToWords_1Dollar()
    {
        $service = new ConvertorService();
        $this->assertEquals('One Dollar', $service->convertAmountToWords('1'));
    }

    public function testConvertAmountToWords_2Dollars()
    {
        $service = new ConvertorService();
        $this->assertEquals('Two Dollars', $service->convertAmountToWords('2'));
    }

    public function testConvertAmountToWords_1Dollar0Cent()
    {
        $service = new ConvertorService();
        $this->assertEquals('One Dollar', $service->convertAmountToWords('1.00'));
    }

    public function testConvertAmountToWords_1Dollar1Cent()
    {
        $service = new ConvertorService();
        $this->assertEquals('One Dollar and One Cent', $service->convertAmountToWords('1.01'));
    }

    public function testConvertAmountToWords_9Dollars9Cents()
    {
        $service = new ConvertorService();
        $this->assertEquals('Nine Dollars and Nine Cents', $service->convertAmountToWords('9.09'));
    }

    public function testConvertAmountToWords_10Dollars10Cents()
    {
        $service = new ConvertorService();
        $this->assertEquals('Ten Dollars and Ten Cents', $service->convertAmountToWords('10.10'));
    }

    public function testConvertAmountToWords_11Dollars11Cents()
    {
        $service = new ConvertorService();
        $this->assertEquals('Eleven Dollars and Eleven Cents', $service->convertAmountToWords('11.11'));
    }

    public function testConvertAmountToWords_20Dollars20Cents()
    {
        $service = new ConvertorService();
        $this->assertEquals('Twenty Dollars and Twenty Cents', $service->convertAmountToWords('20.20'));
    }

    public function testConvertAmountToWords_100Dollars10Cents()
    {
        $service = new ConvertorService();
        $this->assertEquals('One Hundred Dollars and Ten Cents', $service->convertAmountToWords('100.10'));
    }

    public function testConvertAmountToWords_120Dollars10Cents()
    {
        $service = new ConvertorService();
        $this->assertEquals('One Hundred and Twenty Dollars and Ten Cents', $service->convertAmountToWords('120.10'));
    }

    public function testConvertAmountToWords_999Dollars99Cents()
    {
        $service = new ConvertorService();
        $this->assertEquals('Nine Hundred and Ninety Nine Dollars and Ninety Nine Cents', $service->convertAmountToWords('999.99'));
    }

    public function testConvertAmountToWords_1000Dollars()
    {
        $service = new ConvertorService();
        $this->assertEquals('One Thousand Dollars', $service->convertAmountToWords('1000'));
    }

    public function testConvertAmountToWords_1000DollarsZeroCent()
    {
        $service = new ConvertorService();
        $this->assertEquals('One Thousand Dollars', $service->convertAmountToWords('1000.00'));
    }

    public function testConvertAmountToWords_1000DollarsOneCent()
    {
        $service = new ConvertorService();
        $this->assertEquals('Unconvertable Value', $service->convertAmountToWords('1000.01'));
    }

    public function testConvertAmountToWords_1100Dollars()
    {
        $service = new ConvertorService();
        $this->assertEquals('Unconvertable Value', $service->convertAmountToWords('1100'));
    }

    public function testConvertAmountToWords_1Cent()
    {
        $service = new ConvertorService();
        $this->assertEquals('One Cent', $service->convertAmountToWords('.01'));
    }

    public function testConvertAmountToWords_10Cent()
    {
        $service = new ConvertorService();
        $this->assertEquals('Ten Cents', $service->convertAmountToWords('.10'));
    }

    public function testConvertAmountToWords_101Cent()
    {
        $service = new ConvertorService();
        $this->assertEquals('Unconvertable Value', $service->convertAmountToWords('.101'));
    }

    public function testConvertAmountToWords_01Cent()
    {
        $service = new ConvertorService();
        $this->assertEquals('Unconvertable Value', $service->convertAmountToWords('.1'));
    }

    public function testIsValueValid_OverPrecision()
    {
        $service = new ConvertorService();
        $this->assertFalse($service->isValueValid('.101'));
    }

    public function testIsValueValid_UnderPrecision()
    {
        $service = new ConvertorService();
        $this->assertFalse($service->isValueValid('.1'));
    }

    public function testIsValueValid_NaN()
    {
        $service = new ConvertorService();
        $this->assertFalse($service->isValueValid('Hello'));
    }

    public function testIsValueValid_NegativeNumber()
    {
        $service = new ConvertorService();
        $this->assertFalse($service->isValueValid('-1'));
    }

    public function testIsValueValid_OverlyLargeNumber()
    {
        $service = new ConvertorService();
        $this->assertFalse($service->isValueValid('100000'));
    }

    public function testIsValueValid_0()
    {
        $service = new ConvertorService();
        $this->assertTrue($service->isValueValid('0'));
    }

    public function testIsValueValid_1()
    {
        $service = new ConvertorService();
        $this->assertTrue($service->isValueValid('1'));
    }

    public function testIsValueValid_1000()
    {
        $service = new ConvertorService();
        $this->assertTrue($service->isValueValid('1000'));
    }

    public function testIsValueValid_1001()
    {
        $service = new ConvertorService();
        $this->assertFalse($service->isValueValid('1001'));
    }

}
