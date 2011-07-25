<?
class BatchExport_Settings extends Backend_SettingsController
{

	protected $access_for_groups = array(Users_Groups::admin);
	public $implement = 'Db_FormBehavior';

	public $form_edit_title = '[moduletitle]';
	public $form_model_class = '[modulename]_Setting';
	
	public $form_redirect = null;
	public $form_edit_save_flash = '[moduletitle] configuration has been saved.';

	public function __construct()
	{
		parent::__construct();
		$this->app_tab = 'system';
		
		$this->form_redirect = url('system/settings/');
	}

	public function index()
	{
		$this->app_module_name = '';
		$this->app_page_title = 'Settings';
		
		try
		{
			$record = BatchExport_Setting::get();
			if (!$record)
				throw new Phpr_ApplicationException('[moduletitle] configuration not found.');
			
			$this->edit($record->id);
			$this->app_page_title = $this->form_edit_title;
		}
		catch (exception $ex)
		{
			$this->handlePageError($ex);
		}
		

		
	}
	
	protected function index_onSave()
	{
		$record = [moduletitle]_Setting::get();
		$this->edit_onSave($record->id);
	}
	
	protected function index_onCancel()
	{
		$record = [moduletitle]_Setting::get();
		$this->edit_onCancel($record->id);
	}


}
?>