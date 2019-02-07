<?php

namespace Terminal42\CodeLoginBundle\FrontendModule;

use Contao\BackendTemplate;
use Contao\Environment;
use Contao\Frontend;
use Contao\Input;
use Contao\Module;
use Patchwork\Utf8;
use Terminal42\CodeLoginBundle\Security\User\CodeLoginUser;

class CodeLoginModule extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_code_login';

    /**
     * Display a wildcard in the back end
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE') {
            $template = new BackendTemplate('be_wildcard');

            $template->wildcard = '### '.Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['code_login'][0]).' ###';
            $template->title    = $this->headline;
            $template->id       = $this->id;
            $template->link     = $this->name;
            $template->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $template->parse();
        }

        if (FE_USER_LOGGED_IN) {
            return '';
        }

        return parent::generate();
    }

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
                Frontend::jumpToOrReload($this->jumpTo);
            }

            $this->Template->message = $GLOBALS['TL_LANG']['MSC']['code_login.validationFailed'];
        }

        $this->Template->formId = $formId;
        $this->Template->action = Environment::get('request');
    }
}
