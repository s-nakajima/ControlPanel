<?php
/**
 * ControlPanelLayoutComponentのテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * ControlPanelLayoutComponentのテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\ControlPanel\Test\test_app\Plugin\TestControlPanel\Controller
 */
class TestLayoutComponentController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout',
	);

/**
 * index
 *
 * @return void
 **/
	public function index() {
	}
}
