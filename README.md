# SimpleCMS
## What is it?
SimpleCMS (Content Management System) is a web based application (written in PHP5 and JavaScript/jQuery) for authoring, editing and otherwise managing the content and data of a website.
## Why not done?
It will be, eventually.
## How to use?
### Download
Clone a copy of the SimpleCMS repository
   > git clone git://github.com/pkrll/SimpleCMS.git

### Installation
* Set up a virtual host in Apache, pointing to the SimpleCMS directory.
* Create a MySQL database and supply the database constants in the file /library/Config.php with the appropriate values.

### Usage
* Just start creating your controllers (application logic), models (data-access logic) and views and templates (design/design logic) as per the folder structure below.
```
- application/
   - controllers/
     + Add controllers (ExampleController.php).
   - models/
     + Add models (ExampleModel.php).
   - templates/
      + The UI templates resides here, with its own folder structure (ie example/main.tpl).
   - views/
     + Add custom views (ExampleView.php).
- library/
   - core/
      - Bootstrap.php
      - Controller.class.php
      - Model.class.php
      - Router.class.php
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
## License
This project is licensed under the Creative Commons Attribution 3.0 license.
