<?php

namespace MDGameBundle\Services;

use Doctrine\ORM\EntityManager;

class BatchService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function batchGenre($batch, $page)
    {
        $genreRepository = $this->em->getRepository('MDGameBundle:Genre');
        return $genreRepository->findLimitedAll($batch, $page);
    }

    public function batchTheme($batch, $page)
    {
        $themeRepository = $this->em->getRepository('MDGameBundle:Theme');
        return $themeRepository->findLimitedAll($batch, $page);
    }

    public function batchPlateforme($batch, $page)
    {
        $plateformeRepository = $this->em->getRepository('MDGameBundle:Plateforme');
        return $plateformeRepository->findLimitedAll($batch, $page);
    }

    public function batchLicence($batch, $page)
    {
        $licenceRepository = $this->em->getRepository('MDGameBundle:Licence');
        return $licenceRepository->findLimitedAll($batch, $page);
    }

    public function batchMarket($batch, $page)
    {
        $marketRepository = $this->em->getRepository('MDGameBundle:Market');
        return $marketRepository->findLimitedAll($batch, $page);
    }

    public function batchPublisher($batch, $page)
    {
        $publisherRepository = $this->em->getRepository('MDGameBundle:Publisher');
        return $publisherRepository->findLimitedAll($batch, $page);
    }

    public function batchDeveloper($batch, $page)
    {
        $developerRepository = $this->em->getRepository('MDGameBundle:Developer');
        return $developerRepository->findLimitedAll($batch, $page);
    }

    public function batchGame($batch, $page)
    {
        $gameRepository = $this->em->getRepository('MDGameBundle:Game');
        return $gameRepository->findLimitedAll($batch, $page);
    }
}
