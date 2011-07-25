<?php
class [modulename]_module extends Core_ModuleBase
{

	
	public function listSettingsItems(){
	
		return array(
				array(
					'icon'=>'/modules/[modulename]/resources/images/[settingsicon].png', 
					'title'=>'[moduletitle]', 
					'url'=>'/[modulename]/settings',
					'description'=>'[modulesettings_descr]',
					'sort_id'=>[sort_index]
					),
		);
	
	
	}
	
}


?>