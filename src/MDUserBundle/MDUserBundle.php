<?php

namespace MDUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MDUserBundle extends Bundle
{

	public function getParent()
	{
		return 'FOSUserBundle';
	}

}
