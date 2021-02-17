<?php

namespace Tests\Unit;

use Tests\TestCase;

class ConvertorControllerTest extends TestCase
{

    public function testConvert_OneDollar()
    {
        $response = $this->json('GET', '/api/convert/1');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'convertedValue' => 'One Dollar'
        ]);
    }

    public function testConvert_OneDollarOneCent()
    {
        $response = $this->json('GET', '/api/convert/1.01');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'convertedValue' => 'One Dollar and One Cent'
        ]);
    }

    public function testConvert_LargeValue()
    {
        $response = $this->json('GET', '/api/convert/10000');

        $response->assertStatus(400);

        $response->assertJsonFragment([
            'error' => 'Defined value must be a dollar amount between 0 and 1000 with an optional decimal place precision of 2'
        ]);
    }

    public function testConvert_UnknownValue()
    {
        $response = $this->json('GET', '/api/convert/blah');

        $response->assertStatus(400);

        $response->assertJsonFragment([
            'error' => 'Defined value must be a dollar amount between 0 and 1000 with an optional decimal place precision of 2'
        ]);
    }


    public function testConvert_NoValue()
    {
        $response = $this->json('GET', '/api/convert/10000');

        $response->assertStatus(400);

        $response->assertJsonFragment([
            'error' => 'Defined value must be a dollar amount between 0 and 1000 with an optional decimal place precision of 2'
        ]);
    }
}
