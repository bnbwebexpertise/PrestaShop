<?php
/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShopBundle\Tests\Translation\Provider;

use PrestaShopBundle\Translation\Provider\FrontOfficeProvider;

class FrontOfficeProviderTest extends \PHPUnit_Framework_TestCase
{
    // @see /resources/translations/en-US/ShopNotificationsWarning.en-US.xlf
    private $provider;
    private static $resourcesDir;

    public function setUp()
    {
        $loader = $this->getMockBuilder('Symfony\Component\Translation\Loader\LoaderInterface')
            ->getMock()
        ;

        self::$resourcesDir = __DIR__.'/../../resources/translations';
        $this->provider = new FrontOfficeProvider($loader, self::$resourcesDir);
    }

    public function testGetMessageCatalogue()
    {
        // The xliff file contains 6 keys
        $expectedReturn = $this->provider->getMessageCatalogue();
        $this->assertInstanceOf('Symfony\Component\Translation\MessageCatalogue', $expectedReturn);

        // Check integrity of translations
        $this->assertArrayHasKey('ShopNotificationsWarning.en-US', $expectedReturn->all());
        $this->assertArrayHasKey('ModulesShoppingCartShop.en-US', $expectedReturn->all());

        $this->assertCount(4, $expectedReturn->all());

        $frontTranslations = $expectedReturn->all('ShopNotificationsWarning.en-US');
        $this->assertCount(6, $frontTranslations);
        $this->assertArrayHasKey('You do not have any vouchers.', $frontTranslations);
        $this->assertSame('You do not have any vouchers.', $frontTranslations['You do not have any vouchers.']);

        $moduleTranslations = $expectedReturn->all('ModulesShoppingCartShop.en-US');
        $this->assertCount(1, $moduleTranslations);
        $this->assertArrayHasKey('Customers who bought this product also bought:', $moduleTranslations);
        $this->assertSame(
            'Customers who bought this product also bought:',
            $moduleTranslations['Customers who bought this product also bought:']
        );
    }
}
