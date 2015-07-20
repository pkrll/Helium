# Helium
## What is it?
Helium is a web application (written in PHP5, JavaScript/jQuery) for content management.
## Why not done?
It will be, eventually, someday.
## Will it really?
Maybe. Probably. Maybe.
## How to use?
### Download
Clone a copy of the Helium repository
   > git clone git://github.com/pkrll/Helium.git

### Installation
* Set up a virtual host in Apache, pointing to the Helium directory.
* Create a MySQL database and supply the database constants in the file /library/Config.php with the appropriate values.
    * See MySQL Database Scheme in file Helium.sql (Will be updated).

### Usage
* Create your controllers, models and views and templates as per the folder structure below.
```
- application/
   - controllers/
     + Add custom controllers (ExampleController.php).
   - includes/
     + Add custom includes templates (controllerName/functionName.inc)
   - models/
     + Add custom models (ExampleModel.php).
   - templates/
     + The UI templates resides here, with its own folder structure (ie example/main.tpl).
   - views/
     + Add custom views (ExampleView.php).
- library/
   - core/
      - Bootstrap.php
      - Controller.class.php
      - Model.class.php
      - View.class.php
    - Config.php
    - Database.class.php
    - Session.class.php
- public/
   - css/
     + Folder for stylesheets to be used by the templates.
   - fonts/
     + Fonts can be placed here.
   - images/
     - system/
       + System required images.
     - uploads/
       + Folder for images uploaded by user with permission 775.
   - javacsript/
       + JavaScript files.
   - index.php
- .htaccess
```
* Below is an example of how the controller, model, view and templates interact.
    * Note: All controllers must have the default main-method, which will be called if the URL does not specify any method (i.e. *helium.dev/example*). Method foo() is an example of when the URL path is set and a parameter is passed along (i.e. *helium.dev/example/foo/bar*).

#### ExampleController.php
```php
class ExampleController extends Controller {
    public function main () {
       // Calling the model:
       $someVariable = $this->model()->doSomething();
       // Assign a variable to the view class
       // to send to the template:
       $this->view()->assign("variableName", $someVariable);
       // Render the template file (inside the application/templates folder):
       $this->view()->render("example/main.tpl");
    }
    // helium.dev/example/foo/bar
    public function foo() {
       // set $argument to the parameter ("bar")
       $argument = $this->arguments[0]; 
       ...
    }
}
```
#### ExampleModel.php
```php
class ExampleModel extends Model {
    public function doSomething () {
       // This is where the app logic goes
       // ...
       $response = "Hello World!";
       return $response;
    }
}
```
#### example/main.tpl
```html
<html>
   <head><title>Example</title></head>
   <body>
       <?=$someVariable?>
       <!-- prints out: Hello World! -->
   </body>
</html>
```
## License
This project is licensed under the **GNU General Public License v2.0**. All fonts and font icons in this project are licensed under the **SIL Open Font License 1.1**. The font **Numans** was created by **Jovanny Lemonad**. The font **Dosis** was created by **Pablo Impallari**. Fonts icons were created by **Dave Gandy** and **Daniel Bruce**.
