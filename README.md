# tree_structure_testing

## Installing: navigate to project root folder and

```
composer init
```

## Web url should be directed to public folder index.php-file

```
../public/index.php
``` 

## Routes understands this:
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
controller@method
```

##### Method takes $request as a parameter
```
public function method($request) {}
```
## $request variable content:
$_GET array content
```
$request->input():array
$request->input($key):string|''
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
Views are located in app/View folder. Referring a view file uses a dot notation. For instance above, viev.php file path is 
```
../app/View/view/index.php
```
## Controller, Service and Model
In this implemention Controller uses Services and Service uses Models. Controllers, services and models can be found from **app** folder in corresponding folders.
Naming convention for controllers is **ClassNameController**. Naming convention for services is **ClassNameService**, Naming convention for Models is **ClassNameModel**.

## important files
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

##### Base class Controller for class ClassNameController loads corresponding Service in class member $this->Service
##### Base class Service for class ClassNameService loads corresponding Model in class member $this->ClassName

##### Controller name should be same as database table name with *s* 
Controller: **ClassName** -> database table: **classnames**

## About
- Model base class uses database and has no usecases at all. Basically it gets all roes from  corresponding table. and there is Collection class that needs to be developed to help usages of arrays. There are no middlewarews or any authentication logig.
- This is inspirated by Laravel MVC. This is just a test version that is wery limitedt in usecases in my own projects when ajax api is needed and don't want to go trought a heavy setup process.
