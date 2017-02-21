<?php

namespace Terminal42\CodeLoginBundle\Security\User;

use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\FrontendUser;
use Psr\Log\LogLevel;

class CodeLoginUser extends FrontendUser
{
    /**
     * @inheritdoc
     */
    public static function getInstance()
    {
        return new static();
    }

    /**
     * Login member from given code
     *
     * @param string $code
     *
     * @return bool
     */
    public function loginWithCode($code)
    {
        if (false === $this->findBy('login_code', $code)) {
            return false;
        }

        // The account is disabled
        if (false === $this->checkAccountStatus()) {
            return false;
        }

        $this->setUserFromDb();

        // Last login date
        $this->lastLogin    = $this->currentLogin;
        $this->currentLogin = time();
        $this->save();

        // Generate the session
        $this->generateSession();

        // Log the entry
        static::getContainer()->get('monolog.logger.contao')->log(
            LogLevel::INFO,
            sprintf('User "%s" has logged in with code', $this->username),
            ['contao' => new ContaoContext(__METHOD__, TL_ACCESS)]
        );

        return true;
    }
}
