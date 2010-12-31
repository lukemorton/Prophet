<?php defined('SYSPATH') or die('No direct script access.');

class Prophet {
    
    public static function exception_handler(Exception $e)
    {
        Kohana::$environment = Kohana::PRODUCTION;
        
        if (Kohana::$environment === Kohana::DEVELOPMENT)
        {
            Kohana_Core::exception_handler($e);
        }
        
        // It's a nice time to log :)
        Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
        
        if ( ! defined('SUPPRESS_REQUEST'))
        { 
            $request = array(
                // Get status from current request
                'action'  => Request::$current->status,
                
                // If exception has a message this can be passed on
                'message' => rawurlencode($e->getMessage()),
            );
            
            // Override status if HTTP_Response_Exception thrown
            if ($e instanceof HTTP_Response_Exception)
            {
                $request['action'] = $e->getCode();
            }
            
            var_dump($request, Route::get('prophet_error')->uri($request));
            exit;
            
            echo Request::factory(Route::get('prophet_error')->uri($request))
                ->execute()
                ->send_headers()
                ->response;
        }
    }
    
}