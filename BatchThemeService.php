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
}
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

    public function batchTheme($batch, $page)
    {
        $themeRepository = $this->em->getRepository('MDGameBundle:Theme');
        return $themeRepository->findLimitedAll($batch, $page);
    }
}
