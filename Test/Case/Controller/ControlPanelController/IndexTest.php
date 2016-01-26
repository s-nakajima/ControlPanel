<?php
/**
 * ControlPanelController::index()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * ControlPanelController::index()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\ControlPanel\Test\Case\Controller\ControlPanelController
 */
class ControlPanelControllerIndexTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.notifications.notification',
	);

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'control_panel';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'control_panel';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->generateNc('ControlPanel.ControlPanel', array(
			'components' => array(
				'ControlPanelLayout'
			)
		));

		CakeSession::write('getNotificationError', null);

		$this->controller->Notification = $this->getMockForModel('Notifications.Notification',
				array('validCacheTime', 'ping', 'serialize', 'updateNotifications'));
		$this->_mockForReturn('Notifications.Notification', 'validCacheTime', false);
		$this->_mockForReturn('Notifications.Notification', 'ping', true);
	}

/**
 * indexのテスト
 *
 * @return void
 */
	public function testIndex() {
		//Mockの設定
		$this->_mockForReturn('Notifications.Notification', 'serialize', true);
		$this->_mockForReturn('Notifications.Notification', 'updateNotifications', true);

		//テスト実行
		$this->_testNcAction('/control_panel/control_panel/index', array(
			'method' => 'get'
		));

		//チェック
		$this->assertCount(1, $this->vars['notifications']);

		$pattern = '/<a.*?href="' . preg_quote('/notifications/notification/link/1', '/') . '".*?>/';
		$this->assertRegExp($pattern, $this->view);
	}

/**
 * XmlException()のテスト
 *
 * @return void
 * @throws XmlException
 */
	public function testIndexOnXmlException() {
		//Mockの設定
		$this->controller->Notification->expects($this->once())
			->method('serialize')
			->will($this->returnCallback(function () {
				throw new XmlException(__d('cake_dev', 'Invalid input.'));
			}));

		//テスト実行
		$this->_testNcAction('/control_panel/control_panel/index', array(
			'method' => 'get'
		));

		$this->assertCount(1, $this->vars['notifications']);
	}
}
