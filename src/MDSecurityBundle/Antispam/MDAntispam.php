<?php

namespace MDSecurityBundle\Antispam;

class MDAntispam
{
	private $minLength;
	
	public function __construct($minLength)
	{
		$this->minLength = (int) $minLength;
	}
	
	public function isSpam($text)
	{
		return strlen($text) < $this->minLength;
	}
}
