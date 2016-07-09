<?php

namespace MDArticlesBundle\Beta;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
	protected $betaHTML;
	protected $endDate;

	public function __construct(BetaHTMLAdder $betaHTML, $endDate)
	{
		$this->betaHTML = $betaHTML;
		$this->endDate = new \Datetime($endDate);
	}

	public function processBeta(FilterResponseEvent $event)
	{
		$remainingDays = $this->endDate->diff(new \Datetime())->days;
		if ($remainingDays <= 0)
		{
			return;
		}

	//	$response = $this->betaHTML->addBeta($event->getResponse(), $remainingDays);
	//	$event->setResponse($response);

	}

}
