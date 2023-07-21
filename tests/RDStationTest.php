<?php

namespace Hdelima\RDStation\Tests;

use Hdelima\RDStation\RDStation;
use PHPUnit\Framework\TestCase;

class RDStationTest extends TestCase 
{
	/** @test */
	public function shouldInstantiate()
	{
		$publicToken = getenv('RD_STATION_PUBLIC_TOKEN');

		$rd = new RDStation($publicToken, 'https://api.rd.services/platform');

		$this->assertInstanceOf('\Hdelima\RDStation\RDStation', $rd);

		$this->assertSame('https://api.rd.services/platform', $rd->getApiEndpoint());
	}

	/** @test */
	public function shouldPost()
	{
		$publicToken = $_ENV['RD_STATION_PUBLIC_TOKEN'];

		$rd = new RDStation($publicToken);

		$response = $rd->post('conversions', ['payload' => [
			'email' => 'hebert.lim@hotmail.com',
		]]);

		var_dump( $response );
	}
}