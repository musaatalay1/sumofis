<?php

namespace Makrosum\MeetingBundle\Repository;
use Makrosum\MeetingBundle\Entity\User;

/**
 * CompanyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompanyRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllCompaniesRelatedToMe(User $User)
    {

        $AllCompanies = array();

        $MyCompanies = $this->findBy([
            "owner" => $User->getId()
        ]);

        foreach($MyCompanies as $Company){
            $AllCompanies[$Company->getDomain()] = $Company;
        }

        $PersonnelRepository = $this->getEntityManager()->getRepository("MeetingBundle:Personnel");
        $Relations = $PersonnelRepository->findBy([
            "user" => $User->getId()
        ]);

        $RelatedCompanies = array();

        foreach($Relations as $Relation){
            $RelatedCompanies[] = $this->find($Relation->getCompany());
        }

        foreach($RelatedCompanies as $Company){
            $AllCompanies[$Company->getDomain()] = $Company;
        }

        return $AllCompanies;

    }
}
