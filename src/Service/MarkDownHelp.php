<?php


namespace App\Service;


use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

class MarkDownHelp
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Security
     */
    private $security;

    public function __construct(LoggerInterface $logger,Security  $security)
    {
        $this->logger = $logger;
        $this->security = $security;
    }
    public function logMessage(){
        $this->logger->info('User global',[
            'user' =>$this->security->getUser()
        ]);
    }
}
