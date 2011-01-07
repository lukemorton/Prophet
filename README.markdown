# Prophet for Kohana

What can Prophet do for you?

*   Automatic view loading ([Kostache][], [Kohana Views][], etc.)
*   Error handling 404, 500 (inspired by [Errorist][])

[Kostache]: https://github.com/zombor/KOstache
[Kohana Views]: http://kohanaframework.org/guide/kohana/mvc/views
[Errorist]: https://github.com/ThePixelDeveloper/kohana-bits-and-bobs/tree/master/modules/errorist

## Current Version: v0.1.1

The current version is v0.1.1. This release should be considered
fairly stable but not stable enough for a v1 release just yet.
Take that how you want :)

Download or clone the v0.1.1 tag of this repo into your modules 
folder to use with the Kohana 3.1.x series.

If you require Kohana 3.0.x compatibility you will need to
download the alternative tag **v0.1-compat-3.0.x**. That is the
first and last v3.0.x compatible release.

## Requirements

*   PHP 5.2 + (5.3 recommended),
*   Kohana 3.0.x or Kohana 3.1.x, only updates will be provided
    for the 3.1.x branch,
*   Adeptness in prophecy.

## Usage

To start using prophet you don't need much, well theres first
installing Kohana and enabling the module in your bootstrap.php 
file. After getting thus far you need to extend the 
Controller or Prophet_Controller in your own Controllers. Take 
this example:

    class Controller_Blog extends Controller {
        
        public function action_index() {}
        
    }

Now Controller_Blog::action_index will automatically render the
view found in "views/blog/index.php" without anything else being
specified.

### Using Kostache

In order to use Kostache instead of the default Kohana views
simply define the class in your controller or in your own
controller.php file like so:

    class Controller extends Prophet_Controller {
        
        protected $_view_class = 'Kostache';
        
    }
    
Pretty self explanatory hey?

### Viewless actions

You can define individual actions that do not need a view to
save resources and the environment if you're that way
inclined. Take an example:

    <?php defined('SYSPATH') or die('No direct script access.');

    /**
     * Example controller using the view guessing marlarkey
     */
    class Controller_Blog extends Controller {

        /**
         * @var
         * @see  Prophet_Controller::$_viewless
         */
        protected $_viewless = array('create');

        /**
         * For this action the view "blog/index" will have been already loaded.
         *
         * @return  void
         */
        public function action_index()
        {
            // Set some $_GET data to view
            $this->view->set(Arr::extract($_GET, array('page', 'order_by')));
        }

        /**
         * This action loads the "blog/add" view and nothing else
         *
         * @return  void
         */
        public function action_add()
        {
            // No need to do anything
        }

        /**
         * This action creates the blog post, it doesn't need a view.
         *
         * @return  void
         */
        public function action_create()
        {
            $post = Model::factory('post', $_POST);

            // Try and create
            try
            {
                $post->create();
            }
            catch (Kohana_Validate_Exception $e)
            {
                // We set the errors to session here before we redirect.
                Session::instance()->set('errors', $e->array->errors());
            }

            // Redirect back to index action
            $this->request->redirect($this->request->uri(array('action' => 'add')));
        }

    }
    
### Disabling views for an entire controller

You can also disable view rendering for an entire controller if
you need to.

    class Controller_Blog extends Controller {
    
        /**
         * Disable views :D
         * @var  mixed
         * @see  Prophet_Controller::$_view
         */
        protected $_view = FALSE;
    
    }
    
## Error Handling

When an action or controller cannot be found
Controller_Error::action_404 will be served instead. You can
customise the behaviour of this action by extending
Prophet_Controller_Error.

All other errors will be served as 500 and therefore
Controller_Error::action_500 will be used to serve a response.

You can also throw a Http_Exception for any status code,
although only 404 and 500 errors have an action defined.

You don't have to extend Prophet_Controller_Error to customise
the error response however. You can simply make your own custom
view. "views/error/404.php" and "views/error/500.php" will
be loaded by default. You can replace these files in your
application if you wish to without needing to update any
controllers.

## License

Prophet is MIT licensed. That is all :)