<?php

namespace Terminal42\CodeloginBundle\FrontendModule;

use Contao\BackendTemplate;
use Contao\Controller;
use Contao\Environment;
use Contao\Input;
use Contao\Module;
use Contao\PageModel;
use Patchwork\Utf8;
use Terminal42\CodeloginBundle\Security\User\CodeLoginUser;

/**
 * @param string $code_param
 */
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

        if (!empty($this->code_param)
            && !empty($code = (string) Input::get($this->code_param))
            && CodeLoginUser::getInstance()->loginWithCode($code)
        ) {
            $this->redirectAfterLogin();
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
        if (Input::post('FORM_SUBMIT') === $this->getFormId()) {
            if (CodeLoginUser::getInstance()->loginWithCode((string) Input::post('login_code'))) {
                $this->redirectAfterLogin();
            }

            $this->Template->message = $GLOBALS['TL_LANG']['MSC']['code_login.validationFailed'];
        }

        $this->Template->formId = $this->getFormId();
        $this->Template->action = Environment::get('request');
    }

    private function redirectAfterLogin()
    {
        $jumpTo = null;

        if ($this->jumpTo) {
            $jumpTo = PageModel::findByPk($this->jumpTo);
        }

        if (null === $jumpTo) {
            $jumpTo = $GLOBALS['objPage'];
        }

        Controller::redirect($jumpTo->getFrontendUrl());
    }

    private function getFormId()
    {
        return 'login_code_' . $this->id;
    }
}
