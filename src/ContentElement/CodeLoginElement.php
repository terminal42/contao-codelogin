<?php

namespace Terminal42\CodeLoginBundle\ContentElement;

use Contao\ContentElement;
use Contao\Controller;
use Contao\Environment;
use Contao\Input;
use Terminal42\CodeLoginBundle\Security\User\CodeLoginUser;

class CodeLoginElement extends ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_code_login';

    /**
     * @inheritdoc
     */
    protected function compile()
    {
        $formId = 'login_code_' . $this->id;

        if (Input::post('FORM_SUBMIT') === $formId) {
            if ('' !== (string) Input::post('login_code')
                && CodeLoginUser::getInstance()->loginWithCode(Input::post('login_code'))
            ) {
                Controller::reload();
            }

            $this->Template->message = $GLOBALS['TL_LANG']['MSC']['code_login.validationFailed'];
        }

        $this->Template->formId = $formId;
        $this->Template->action = Environment::get('request');
    }
}
