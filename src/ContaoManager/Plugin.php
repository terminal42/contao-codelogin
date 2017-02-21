<?php

namespace Terminal42\CodeLoginBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Terminal42\CodeLoginBundle\Terminal42CodeLoginBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * @inheritdoc
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(Terminal42CodeLoginBundle::class)->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
