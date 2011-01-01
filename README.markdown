# Prophet for Kohana

What can Prophet do for you?
- Automatic view loading (Kostache, Kohana Views, etc.)
- Error handling 404, 500 (inspired by Errorist)

## Usage

To start using prophet you don't need much, well theres first
installing Kohana and enabling the module in your bootstrap.php 
file. After getting thus far you need to extend the 
Controller or Prophet_Controller in your own Controllers. Take 
this example:

    class Controller_Blog extends Controller {
        
        public function action_index() {}
        
    }

Now blog/index will automatically render the view found in 
"APPPATH/views/blog/index.php" without anything else being 
specified.

### Using Kostache

In order to use Kostache instead of the default Kohana views
simply define the class in your controller:

    class Controller_Blog extends Controller {
        
        public $view_class = 'Kostache';
        
        public function action_index() {}
        
    }
    
Now "APPPATH/classes/view/blog/index.php" will be used by 
Kostache along with the corresponding template found in
"APPPATH/templates/blog/index.mustache".