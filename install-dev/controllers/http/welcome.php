<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * Step 1 : display agrement form
 */
class InstallControllerHttpWelcome extends InstallControllerHttp
{
	/**
	 * Process welcome form
	 *
	 * @see InstallAbstractModel::process()
	 */
	public function processNextStep()
	{
		$this->session->licence_agrement = Tools::getValue('licence_agrement');
		$this->session->configuration_agrement = Tools::getValue('configuration_agrement');
	}

	/**
	 * Licence agrement must be checked to validate this step
	 *
	 * @see InstallAbstractModel::validate()
	 */
	public function validate()
	{
		return $this->session->licence_agrement;
	}

	/**
	 * Change language
	 */
	public function process()
	{
		if (Tools::getValue('language'))
		{
			$this->session->lang = Tools::getValue('language');
			$this->redirect('welcome');
		}
	}

	/**
	 * Display welcome step
	 */
	public function display()
	{
		$this->can_upgrade = false;
		if (file_exists(_PS_ROOT_DIR_.'/config/settings.inc.php'))
		{
			@include_once(_PS_ROOT_DIR_.'/config/settings.inc.php');
			if (version_compare(_PS_VERSION_, _PS_INSTALL_VERSION_, '<'))
			{
				$this->can_upgrade = true;
				$this->ps_version = _PS_VERSION_;
			}
		}

		$this->displayTemplate('welcome');
	}
}
