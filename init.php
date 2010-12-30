<?php defined('SYSPATH') or die('No direct script access.');

if (Kohana::$errors)
{
    // Override Kohana exception handler
    set_exception_handler(array('prophet', 'exception_handler'));
}

// Error Route for internal error requests
Route::set('prophet_error', '<action>(/<message>)', array('action' => '[0-9]{3}', 'message' => '.*'))
    ->defaults(array(
        'controller' => 'prophet'
    ));

// Catch All Route (404 Response)
Route::set('prophet_catchall', '<catchall>', array('catchall' => '.*'))
    ->defaults(array(
        'controller' => 'prophet',
        'action'     => '404',
    ));

/**
 * Helper function for set/get once data
 *
 * @param   string  Name of data
 * @param   mixed   Data to be stored
 * @return  mixed   Returns data if no value set
 */
function Flash($name, $value = NULL)
{
    if ($value === NULL)
    {
        return Session::instance()->get_once($name);
    }
    
    Session::instance()->set($name, $value);
}