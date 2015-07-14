# Helium
## What is it?
Helium is a web application (written in PHP5, JavaScript/jQuery) for managing content and data, simply speaking, a CMS.
## Why not done?
It will be, eventually.
## Will it really?
Maybe. Probably. Maybe.
## How to use?
### Download
Clone a copy of the Helium repository
   > git clone git://github.com/pkrll/Helium.git

### Installation
* Set up a virtual host in Apache, pointing to the Helium directory.
* Create a MySQL database and supply the database constants in the file /library/Config.php with the appropriate values.
*** The database should have the following tables: Users, Roles, Resources ... (More details to come).

### Usage
* Just start creating your controllers (application logic), models (data-access logic) and views and templates (design) as per the folder structure below.
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
This project is licensed under the GNU General Public License v2.0. All fonts and font icons in this project are licensed under the SIL Open Font License 1.1. The font Numans was created by Jovanny Lemonad. The font Dosis was created by Pablo Impallari. Fonts icons were created by Dave Gandy and Daniel Bruce.
