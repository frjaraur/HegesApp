<?php

namespace HegesApp\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HegesAppUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
