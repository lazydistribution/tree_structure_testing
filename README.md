# tree_structure_testing

## Table of contents
- [Installing](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#installing)
- [Base url](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#base-url)
- [Routes](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#routes)
- [Request](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#request)
- [Views](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#views)
- [Controller, Service and Model](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#controller-service-and-model)
- [Important files](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#important-files)
- [Database](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#database)
- [Shells](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#shells)
- [Important files](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#important-files)
- [Custom files and folders](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#custom_files_and_folders)
- - [Custom files and folders](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#custom_files_and_folders)
- - [Custom files and folders](https://github.com/lazydistribution/tree_structure_testing/blob/main/README.md#custom_files_and_folders)

## Installing
Just download the project and you are ready to go 

If you want to use [fzaninotto/Faker](https://github.com/fzaninotto/Faker) type in console:
```
composer init
```
If you want to use build in shell project RandomTreeShell you need that God damn faker.


## Base url
should be directed to public folder index.php file
```
../public/index.php
``` 

## Routes
routes can be set in ../public/index.php file and there in routes section.


##### First parameter
if web url is ...index.php?route=index, this route will recognize it:
```
Routes::get('index', 'LandingPageController@index');
```
if web url is ...index.php?route=api/index, this route will recognize it:
```
Routes::get('api/index', 'PostController@index');
```

There is only **get** routes implemented, but post requests can be send to get endpoints also because this uses just url guery params as route information. In current verion there aren't any wildcards.

##### Second parameter 
this is where you spesify the controller and the method to call in that controller
```
controllerName@methodName
```

##### Method takes $request as a parameter
```
class ControllerName extends Controller
{
    public function methodName($request)
    {
    }
}
```
## Request 
##### $request variable content in Controller
$_GET array content
```
$request->input():array
$request->input($key):string
```
$_POST array content
```
$request->post():array
$request->post($key):string|''
```
## Response
If route has an **api/** prefix controller should return an array with two parameters msg parameter has payload and second is status
```
return ['msg' => $request->input('route'), 'status' => 200];
```
If route has no **api/** prefix controller should return a view
```
return HTML::view('index.index', [ 'base_url' => base_url() ]);
```
## Views
Views are located in app/View folder. 
##### view usage
Referring a view file uses a dot notation and views should be php files. 

##### First parameter should be vief file path:
```
HTML::view('index.index', [ 'base_url' => base_url() ])
```
For instance above **index.index**, file path is:
```
../app/View/view/index.php
```
##### Second parameter
seconf parameter should be an associative array where key is name of a php variable in view file and value its corresponding value.

## Controller, Service and Model
In this implemention Controller uses Services and Service uses Models. Controllers, services and models can be found from **app** folder in corresponding folders.
Naming convention for controllers is **ClassNameController**. Naming convention for services is **ClassNameService**, Naming convention for Models is **ClassNameModel**.

## Important files
ClassNameController-contoller should extend Controller
```
class ClassNameController extends Controller 
{
}
```

ClassNameService-service should extend Service
```
class ClassNameService extends Service 
{
}
```

ClassNameModel-model should extend Model
```
class ClassNameModel extends Model 
{
}
```

- Base class Controller for class ClassNameController loads corresponding Service in class member $this->Service
- Base class Service for class ClassNameService loads corresponding Model in class member $this->ClassName

##### Controller name should be same as database table name with *s* 
Controller: **ClassName** -> database table: **classnames**. 

## Database
database structure for current setup can be found from **posts_table.sql** file. Model base class should use database byt basically it just gets all rows from corresponding table now. And there is Collection class in this context that needs to be developed to help usages of arrays.

## Shells
crontab runs etc. can be run with from Console folder such as
```
../app/Console> php shell CustomShell <argv>
```
where CustomShell should extend Console base class
```
class CustomShell extends Shell
{
}
```
Custom Sehe lsould implement main method that takes args array as its parameter. $args contains parameters given in console line after custom shell name.
```
class CustomShell extends Shell
{
    public function main($args)
    {
        ...
    }
}
```
## Custom files and folders
**autoloader.php** file in root folder loads classess in folders in **app** folder where file name is same as class name. Autoload for vendor files can be found **vendor** folder if you have installed any third paret libraries. If not you don't need it. If yoou have installed third part libraries autoloader.php should be able to load vendor autoload.php-file also. Third part libaries aren't mandatory for basic usege but if you need to use build in shell project **RandomTreeShell** then you need to **composer init** to get [fzaninotto/Faker](https://github.com/fzaninotto/Faker).

## About
This is inspirated by Laravel MVC. This is strongly limitedt ..in progress.. project for usecases in my own projects when I need simple ajax api for testing my own javascript projects without too heavy setting process. There are no middlewarews or any authentication logic in current setup.

## License
At the moment this can be used anyway you like except for Faker. For usage of Faker you need to look its licensing policy in [fzaninotto/Faker](https://github.com/fzaninotto/Faker).
