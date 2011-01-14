<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller default view loading for Kostache!
 *
 * To get your controllers guessing what views to load simply
 * place this file into your "classes" directory in your application.
 */
class Prophet_Controller extends Kohana_Controller {
	
	/**
	 * @var  string  The view class
	 * @protected
	 */
	protected $_view_class = 'View';
	
	/**
	 * @var  array  Define viewless actions here
	 * @protected
	 */
	protected $_viewless = array();
	
	/**
	 * @var  mixed  Holds the current view instance
	 * @protected
	 */
	protected $_view = NULL;
	
	/**
	 * Magic get method used for lazy loading the view so if you
	 * don't call the view, it won't be loaded.
	 *
	 * @param  string  Variable name
	 */
	public function __get($name)
	{
		if ($name === 'view')
		{
			if ($this->_view === NULL && ! in_array($this->request->action(), $this->_viewless))
			{
				$view_parts = array();
				
				foreach (array('directory', 'controller', 'action') as $_part)
				{
					$part = call_user_func(array($this->request, $_part));
					
					if ( ! empty($part))
					{
						$view_parts[] = $part;
					}
				}
				
				// Build the view location
				$view_location = implode('/', $view_parts);
				
				// Load the view using chosen class
				$this->_view = call_user_func($this->_view_class.'::factory', $view_location);
			}
			
			return $this->_view;
		}
	}
	
	/**
	 * The after method turns the view into a response
	 *
	 * @return  Kohana_Controller::after
	 */
	public function after()
	{
		if ($this->view)
		{
			$this->response->body($this->view);
		}
		
		return parent::after();
	}
	
}