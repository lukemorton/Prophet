<?php defined('SYSPATH') or die('No direct script access.');

class Prophet {
    
    public function exception_handler(Exception $e)
    {
        if (Kohana::$environment === Kohana::DEVELOPMENT)
        {
            Kohana_Core::exception_handler($e);
        }
        
        // It's a nice time to log :)
        Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
        
        if ( ! defined('SUPPRESS_REQUEST'))
        { 
            $request = array(
                // Get code from current request
                'action'  => Request::$current->code,
                
                // If exception has a message this can be passed on
                'message' => $e->getMessage(),
            );
            
            // Override code if HTTP_Response_Exception thrown
            if ($e instanceof HTTP_Response_Exception)
            {
                $request['action'] = $e->getCode();
            }
            
            echo Request::factory(Route::get('prophet_error')->uri($request))
                ->execute()
                ->send_headers()
                ->response;
        }
    }
    
}