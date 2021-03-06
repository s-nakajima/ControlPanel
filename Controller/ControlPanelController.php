<?php
/**
 * ControlPanel Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ControlPanelAppController', 'ControlPanel.Controller');

/**
 * ControlPanel Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\ControlPanel\Controller
 */
class ControlPanelController extends ControlPanelAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Notifications.Notification'
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout'
	);

/**
 * helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Date',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		if (! $this->Notification->validCacheTime() && ! $this->Session->read('getNotificationError')) {
			try {
				$this->Session->write('getNotificationError', true);
				//サイトの生死確認
				if ($this->Notification->ping()) {
					$notifications = $this->Notification->serialize();
					//更新処理
					$this->Notification->updateNotifications(array(
						'Notification' => $notifications
					));
					$this->Session->write('getNotificationError', false);
				}
			} catch (XmlException $e) {
				// Xmlが取得できなくても、エラーにしない
				CakeLog::error($e);
			}
		}

		$notifications = $this->Notification->find('all', array(
			'recursive' => -1,
			'limit' => Notification::MAX_ROW,
			'order' => array('last_updated' => 'desc')
		));

		$this->set('notifications', $notifications);
		$this->set('title', __d('notifications', 'Notifications'));
	}
}
