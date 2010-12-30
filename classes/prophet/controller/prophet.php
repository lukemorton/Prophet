<?php defined('SYSPATH') or die('No direct script access.');

class Prophet_Controller_Prophet extends Controller {
    
    public function before()
    {
        // External requests default to 500
        if (Request::$instance === Request::$current)
        {
            $this->request->action = 500;
        }
        
        return parent::before();
    }
    
    public function action_404()
    {
        $this->request->code = 404;
    }
    
    public function action_500()
    {
        $this->request->code = 500;
    }
    
}