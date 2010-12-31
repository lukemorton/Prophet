<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller default view loading for Kostache!
 *
 * To get your controllers guessing what views to load simply
 * place this file into your "classes" directory in your application.
 */
class Prophet_Controller extends Kohana_Controller {
	
	/**
	 * @var  mixed  Holds the current view instance
	 */
	public $view = NULL;
	
	/**
	 * @var  string  The view class
	 */
	public $view_class = 'View';
    
	/**
	 * @var  string  Holds a view exception
	 */
	public $view_exception = NULL;
	
	/**
	 * @var  array  Define viewless actions here
	 */
	public $viewless = array();

	/**
	 * The before method can be used for predicting a view. It uses the
	 * controller and it's directory, along with the action to work out
	 * what path to load. For example Controller_Blog_Comments::action_add
	 * would have a view location of blog/comments/add.
	 *
	 * @return  void
	 */
	public function before()
	{
		// If views not turned off and not a viewless action
		if ($this->view !== FALSE && ! in_array($this->request->action, $this->viewless))
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
			
            try
            {
                // Load the view using chosen class
                $this->view = call_user_func($this->view_class.'::factory', $view_location);
            }
            catch (Kohana_View_Exception $e)
            {
                $this->view_exception = $e;
            }
		}
		
		return parent::before();
	}
	
	/**
	 * The after method turns the view into a response
	 *
	 * @return  void
	 */
	public function after()
	{
        if ($this->view_exception)
        {
            // Re throw error if got this far
            throw $this->view_exception;
        }
    
		if ($this->view)
		{
			$this->request->response = $this->view;
		}
		
		return parent::after();
	}
	
}