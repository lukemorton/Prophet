# Prophet for Kohana

What can Prophet do for you?

*   Automatic view loading ([Kostache][], [Kohana Views][], etc.)

[Kostache]: https://github.com/zombor/KOstache
[Kohana Views]: http://kohanaframework.org/guide/kohana/mvc/views
[Errorist]: https://github.com/ThePixelDeveloper/kohana-bits-and-bobs/tree/master/modules/errorist

## Current Version: v0.1.2

[Download v0.1.2](https://github.com/DrPheltRight/Prophet/tree/v0.1.2)

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

## License

Prophet is MIT licensed. That is all :)