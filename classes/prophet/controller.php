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
	 */
	public $view_class = 'View';
    
	/**
	 * @var  array  Define viewless actions here
	 */
	public $viewless = array();
    
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
            if ($this->_view === NULL && ! in_array($this->request->action, $this->viewless))
            {
                $view_parts = array();
                
                foreach (array('directory', 'controller', 'action') as $_part)
                {
                    if ( ! empty($this->request->{$_part}))
                    {
                        $view_parts[] = $this->request->{$_part};
                    }
                }
                
                // Build the view location
                $view_location = implode('/', $view_parts);
                
                // Load the view using chosen class
                $this->_view = call_user_func($this->view_class.'::factory', $view_location);
            }
            
            return $this->_view;
        }
    }
	
	/**
	 * The after method turns the view into a response
	 *
	 * @return  void
	 */
	public function after()
	{
		if ($this->view)
		{
			$this->request->response = $this->view;
		}
		
		return parent::after();
	}
	
}