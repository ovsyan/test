<?php

namespace AppBundle\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AccountStatusBlockedException extends AuthenticationException
{

    public function getMessageKey()
    {
        return 'Account is blocked. Check your email to activate account';
    }

}