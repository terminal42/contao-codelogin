<?php

namespace Terminal42\CodeLoginBundle\FrontendModule;

use Contao\BackendTemplate;
use Contao\Environment;
use Contao\Frontend;
use Contao\Input;
use Contao\Module;
use Patchwork\Utf8;
use Terminal42\CodeLoginBundle\Security\User\CodeLoginUser;

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
        $code = $this->getCode();

        if (null !== $code) {
            if (CodeLoginUser::getInstance()->loginWithCode($code)) {
                Frontend::jumpToOrReload($this->jumpTo);
            }

            $this->Template->message = $GLOBALS['TL_LANG']['MSC']['code_login.validationFailed'];
        }

        $this->Template->formId = $this->getFormId();
        $this->Template->action = Environment::get('request');
    }

    private function getCode(): ?string
    {
        if (!empty($this->code_param)) {
            $code = (string) Input::get($this->code_param);
        }

        if (Input::post('FORM_SUBMIT') === $this->getFormId()) {
            $code = (string) Input::post('login_code');
        }

        return $code ?: null;
    }

    private function getFormId()
    {
        return 'login_code_' . $this->id;
    }
}
