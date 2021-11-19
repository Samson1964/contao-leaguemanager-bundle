<?php

namespace Schachbulle\ContaoLeaguemanagerBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Schachbulle\ContaoLeaguemanagerBundle\ContaoLeaguemanagerBundle;

class Plugin implements BundlePluginInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getBundles(ParserInterface $parser)
	{
		return [
			BundleConfig::create(ContaoLeaguemanagerBundle::class)
				->setLoadAfter([ContaoCoreBundle::class]),
		];
	}
}
