# Prophet for Kohana

    Predicting views based on the controller and action for a
    current request so you don't have to.

I created Prophet to provide an automatic way of initialising
views within my Kohana applications. Using the class of your
choice a view will be initialised and render as the request
response unless overridden. I have used Prophet personally
with Kohana Views and Kostache but it should work for any view
mechanism that has a factory method which parameter is a view 
location path.

## Usage

To start using prophet you don't need much, well theres 4
installing Kohana and enabling the module in your bootstrap.php 
file. After getting thus far you need to extend the 
Prophet_Controller in your own Controllers. Take this example:

    class Controller_Blog extends Prophet_Controller {
        
        public function action_index() {}
        
    }

Now blog/index will automatically render the view found in 
"APPPATH/views/blog/index.php" without anything else being 
specified.

### Using Kostache

In order to use Kostache instead of the default Kohana views
simply define the class in your controller:

    class Controller_Blog extends Prophet_Controller {
        
        public $view_class = 'Kostache';
        
        public function action_index() {}
        
    }
    
Now "APPPATH/classes/view/blog/index.php" will be used by 
Kostache along with the corresponding template found in
"APPPATH/templates/blog/index.mustache".