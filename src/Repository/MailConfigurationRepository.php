<?php

declare(strict_types = 1);

namespace BeHappy\SyliusMailPlugin\Repository;

use BeHappy\SyliusMailPlugin\Entity\MailConfiguration;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Sylius\Component\Core\Model\Channel;

class MailConfigurationRepository extends EntityRepository
{
    /**
     * @param Channel $channel
     *
     * @return MailConfiguration|null
     */
    public function findOneByChannel(Channel $channel): ?MailConfiguration
    {
        $qb = $this->createQueryBuilder('mail_configuration');
        $qb->join('mail_configuration.channels', 'channels')
            ->where('channels.id = :channel')
            ->setParameter('channel', $channel);
        
        $qb->setMaxResults(1);
        
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $exception) {
            return null;
        }
    }
}