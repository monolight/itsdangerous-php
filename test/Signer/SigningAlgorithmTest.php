<?php

use ItsDangerous\Signer\SigningAlgorithm;
use PHPUnit\Framework\TestCase;

class SigningAlgorithmTest extends TestCase
{

	public function testConstantTimeCompare_unequalLengths_returnFalse()
	{
		$stub = new class extends SigningAlgorithm {
			public function get_signature($key, $value): string
			{
				return '';
			}
		};

		$equal = $stub->constant_time_compare('four', 'sixsix');

		$this->assertFalse($equal);
	}

	// TODO: timing test to assert that constant time means that it
	// doesn't short circuit?
}
