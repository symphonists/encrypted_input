<?php

	Class extension_encrypted_input extends Extension{
	
		public function about() {
			return array(
				'name' => 'Field: Encrypted Input',
				'version' => '1.0',
				'release-date' => '2012-03-21',
				'author' => array(
					'name' => 'Nick Dunn',
					'website' => 'https://nick-dunn.co.uk'
				)
			);
		}
		
		public function install() {
			// create suitable salt
			Symphony::Configuration()->set('salt', General::generatePassword() , 'encrypted_input');
			Administration::instance()->saveConfig();
			// create settings table
			return Symphony::Database()->query("CREATE TABLE `tbl_fields_encrypted_input` (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `field_id` int(11) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `field_id` (`field_id`)
			) TYPE=MyISAM");
		}
		
		public function uninstall() {
			// remove config
			Symphony::Configuration()->remove('encrypted_input');			
			Administration::instance()->saveConfig();
			// remove field settings
			Symphony::Database()->query("DROP TABLE `tbl_fields_encrypted_input`");
		}
		
		public function getSubscribedDelegates() {
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'AddCustomPreferenceFieldsets',
					'callback' => 'appendPreferences'
				),
				array(
					'page'		=> '/backend/',
					'delegate'	=> 'InitaliseAdminPageHead',
					'callback'	=> 'initaliseAdminPageHead'
				)
			);
		}
		
		public function initaliseAdminPageHead($context) {
			$page = Administration::instance()->Page;
			$callback = Administration::instance()->getPageCallback();
			
			if ($page instanceOf contentPublish && in_array($callback['context']['page'], array('edit', 'new'))) {
				Administration::instance()->Page->addScriptToHead(URL . '/extensions/encrypted_input/assets/encrypted_input.publish.js', 300);
			}
		}
		
		public function appendPreferences($context) {
			$group = new XMLElement('fieldset');
			$group->setAttribute('class', 'settings');
			$group->appendChild(new XMLElement('legend', __('Encrypted Input')));

			$label = Widget::Label(__('Salt'));
			$input = Widget::Input('settings[encrypted_input][salt]', Symphony::Configuration()->get('salt', 'encrypted_input'));
			$label->appendChild($input);
			$group->appendChild($label);

			$context['wrapper']->appendChild($group);
		}
			
	}