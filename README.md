# tree_structure_testing

## Installing: navigate to project root folder and

```
compose init
```

## Web url should be directed to public folder index.php-file

```
../public/index.php
```

## routes can be set in ../public/index.php file and there in routes section. 

## Routes understands this:

## first parameter
if web url is ...index.php?route=index, this route will recognize it:
Routes::get('index', 'LandingPageController@index');

if web url is ...index.php?route=api/index, this route will recognize it:
Routes::get('api/index', 'PostController@index');

in current verion there are no any wildcards.

## second parameter 
this is where you spesify the controller and the method to call in that controller

## controller service and model
In this implemention Controller uses Services and Service uses Models. Controllers, services and models can be found from app folder in corresponding folders.
Naming convention for controllers is **ClassNameController**
Naming convention for services is **ClassNameService**
Naming convention for Models is **ClassNameModel**

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

Base class Controller for class ClassNameController loads corresponding Service in class member $this->Service
Base class Service for class ClassNameService loads corresponding Model in class member $this->ClassName

##### Controller name should be same as database table name with *s* 
Controller: **ClassName** -> database table: **classnames**
