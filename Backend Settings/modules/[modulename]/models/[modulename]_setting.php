<?php

	class [modulename]_Setting extends Backend_SettingsRecord
	{
		public $table_name = '[modulename]_settings';
		public static $obj = null;

		public $automatic = false;
		public $require_key = false;
		public $api_key = '';
		public $output = 1;
		public $location = '/reports/';
		//for ftp or other such locations
		public $username = '';
		public $password = '';
		
		
		public $encrypted_columns = array('op_password','api_key');
		
		
		public static function get($className = null)
		{
			if (self::$obj !== null)
				return self::$obj;
			
			return self::$obj = parent::get('[modulename]_Setting');
		}
		
		public function define_columns($context = null)
		{
			//$this->validation->setFormId('settings_form');
			
			$this->define_column('automatic', 'Automatic exports')->validation();
			$this->define_column('require_key', 'Require private key')->validation();
			$this->define_column('api_key', 'Private key')->validation();
			$this->define_column('output_type', 'Output type')->validation();
			$this->define_column('op_location', 'Location')->validation();
			$this->define_column('op_username', 'Username')->validation();
			$this->define_column('op_password', 'Password')->validation();

		}
		
		public function get_output_type_options($db_name, $current_key_value = -1)
		{
			$options = array(0=> 'Raw'
							,	 'File'
							,	 'FTP'
							,	 'Email');
							
			if ($current_key_value == -1)
				return $options;
				
			return isset($options[$current_key_value]) ? $options[$current_key_value] : null;
		
		}

		public function before_validation($deferred_session_key = null)
		{
		
			if($this->require_key){
							
				$this->column_definitions['api_key']->validation()
						->fn('trim')
						->required('The Private key field is required when option is on');
			}			
			
			switch($this->output_type){
			
				case 1: //File output
					$this->column_definitions['op_location']->validation()
						->setError('invalid location','op_location');
				 break;
				case 2: //FTP output
					$this->column_definitions['op_location']->validation()
						->regexp('!^((ht|f)tps?://)?[a-zA-Z]{1}([w-]+.)+([w]{2,5})/?$!i','Invalid FTP Location');
				 break;
				case 3: //Email output
					$this->column_definitions['op_location']->validation()
						->email();
				 break;
			
			}
			
		
		}
		
		public function define_form_fields($context = null)
		{
			
			$this->add_form_field('automatic')->comment('Automatic exports')->renderAs(frm_onoffswitcher)->validation()->fn('trim')->required();
			$this->add_form_field('require_key')->comment('Require private key')->renderAs(frm_onoffswitcher)->validation()->fn('trim')->required();
			$this->add_form_field('api_key')->comment('Private key')->validation();
			$this->add_form_field('output_type')->comment('Output type')->renderAs(frm_dropdown)->validation();
			$this->add_form_field('op_location')->comment('Location')->renderAs(frm_text)->validation();
			$this->add_form_field('op_username')->comment('Username')->renderAs(frm_text)->validation();
			$this->add_form_field('op_password')->comment('Password')->renderAs(frm_password)->validation();
			
			$this->add_form_partial('ajax');

		}
		
}
?>

