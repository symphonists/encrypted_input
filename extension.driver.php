<?php

	Class extension_mcrypt_input extends Extension{
	
		public function about(){
			return array('name' => 'Field: Mcrypt Input',
						 'version' => '1.0',
						 'release-date' => '2012-03-21',
						 'author' => array('name' => 'Symphony Community',
										   'website' => 'https://github.com/symphonists')
				 		);
		}
		
		public function uninstall(){
			Symphony::Database()->query("DROP TABLE `tbl_fields_mcrypt_input`");
		}


		public function install(){

			return Symphony::Database()->query("CREATE TABLE `tbl_fields_mcrypt_input` (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `field_id` int(11) unsigned NOT NULL,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `field_id` (`field_id`)
			) TYPE=MyISAM");

		}
		
		public function getSubscribedDelegates(){
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'AddCustomPreferenceFieldsets',
					'callback' => 'appendPreferences'
				),
				array(
					'page' => '/system/preferences/',
					'delegate' => 'Save',
					'callback' => 'savePreferences'
				)
			);
		}
		
		/**
		 * Append maintenance mode preferences
		 *
		 * @param array $context
		 *  delegate context
		 */
		public function appendPreferences($context) {

			$group = new XMLElement('fieldset');
			$group->setAttribute('class', 'settings');
			$group->appendChild(new XMLElement('legend', __('Mcrypt Input')));

			$label = Widget::Label(__('Salt'));
			$input = Widget::Input('settings[mcrypt_input][salt]', Symphony::Configuration()->get('salt', 'mcrypt_input'));
			$label->appendChild($input);
			$group->appendChild($label);

			$context['wrapper']->appendChild($group);
		}

		/**
		 * Save preferences
		 *
		 * @param array $context
		 *  delegate context
		 */
		public function savePreferences($context) {

		}
        
			
	}

?>