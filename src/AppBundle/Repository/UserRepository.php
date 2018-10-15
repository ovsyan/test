<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository
{
    public function findUserByConfirmationToken($token)
    {
        return $this->findOneBy(
            [
                'confirmation_token' => $token,
            ]
        );
    }

}