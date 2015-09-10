# Helium
**What is it?**
Helium is a web application (written in PHP5, JavaScript/jQuery) for content management.

**Why not done?**
It will be, eventually, someday.

**Will it really?**
Maybe. Probably. Maybe.
## How to use?
### Download
Clone a copy of the Helium repository
   > git clone git://github.com/pkrll/Helium.git

### Installation
* Set up a virtual host in Apache, pointing to the Helium directory.
* Install the dependencies, using NPM and Composer, like so ([Click here](#installing-dependencies) for more information):

```bash
$ composer install
$ npm install
```
* After installing the Hyperion MVC Core, you need to create the MySQL database and set the database constants inside the ``config.php`` file.
    * See MySQL Database Schema in file Helium.sql (will be updated).

### Usage
* Log in to the Helium admin panel by navigating to *yoursite.io/user* and providing the default username and password (*admin*/*admin*). (You can change the default password by selecting Users in the menu bar.)
* Before you can start adding new articles/posts, you need to add Categories to the system (under menu Posts > Categories).
* Don't forget the front end!
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
    - Config.php
    - Permissions.php
- node_modules/
   - JS dependencies
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
- vendor/
   - PHP packages
- .htaccess
```
* Below is an example of how the controller, model, view and templates interact.
    * Note: All controllers must have the default main-method, which will be called if the URL request does not specify any action (i.e. *helium.dev/example*). Method foo() is an example of when the URL request path is set and a parameter is passed along (i.e. *helium.dev/example/foo/bar*).

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
       // Use $this->arguments[n] if there are more parameters
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

#### Installing dependencies
* If you've included the package.json file in the root folder, just run the following command:
```bash
$ npm update
```
* You can also install it via the `install` command:
```bash
$ npm install dropster
```
* If you're manually adding it to the project, it must be in the folder node_modules/dropster/lib at root level.

### Work in progress
* The Helium app is still in development.

![screenshot](https://raw.githubusercontent.com/pkrll/Helium/master/screenshot.png "Helium 0.20")

## License
This project is licensed under the **MIT License**. All fonts and font icons are licensed under the **SIL Open Font License 1.1**. The font **Numans** was created by **Jovanny Lemonad**. The font **Dosis** was created by **Pablo Impallari**. The font icons were created by **Dave Gandy** and **Daniel Bruce**.
