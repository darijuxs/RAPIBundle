RAPIBundle
============

The RAPIBundle offers possibility to convert database data to JSON response in Symfony2  
It's compatible with Doctrine ODM for Mongo database and ORM for MySQL database.  

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    LICENSE
    
Installation
============

Step 1: Download the Bundle
---------------------------

Open `composer.json` file and add  

```
  "repositories": [
    {
      "type": "vcs",
      "url": "git@bitbucket.org:bungalowsystems/rapibundle.git"
    }
  ],
```

Run command to install required bundle.

```
composer require bs/rapi "1.0.*"
```
  
  
This command requires you to have Composer installed globally, as explained  
in the [installation chapter](https://getcomposer.org/doc/00-intro.md#globally)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new RAPIBundle\RAPIBundle(),
        );

        // ...
    }

    // ...
}
```
  
Documentation
============

Response JSON format
---------------------------

RAPIBundle use custom format to return JSON response
  
```json
{
    "status": {
        "code": 200 //Status code
    },
    "result": {
   
    //Response data
   
    },
    "customResult": {
  
     //Custom response data is used for data that is incompatible with main response
  
     },
    "error": {
        "errors": [
        
        //Information about error that happened
        
        ]
    },
    "info": {
        "total": null,  //Total record
        "page": null,   //Current page
        "limit": null   //How much record display per page
    },
    "profiler": {
  
    //Profiler information
   
    }
}
```

Extending controller
---------------------------

RAPIBundle logic is separated into few services `bs.rapi.request`, `bs.rapi.response`, `bs.rapi.data_mapper`  
To use these services in your controller you can simple extend RAPIBundle controller:
  
```php
<?php
  
namespace AppBundle\Controller;  
  
use RAPIBundle\Controller\RAPIController;  
  
class DefaultController extends RAPIController
{
    public function indexAction()
    {
        $request = $this->getRequest();
    
        $result = $this->getDataMapper()
            ->map($object, null, 0);
    
        return $this->getResponse()
            ->setResult($result)
            ->get();
    }
}
```

Data Mapper
---------------------------
  
RAPIBundle use data mapper object to convert Doctrine data to fit it to response object.  
Data mapper object use doctrine **annotation** to easily convert data to required type.  
It is compatible with Doctrine ORM and ODM. To use it add `@DataMapper\Mapper()` annotation  
to your entity (document) and every "getter" method that return data.

```php
<?php

namespace AppBundle\Entity;  

use Doctrine\ORM\Mapping as ORM;
use RAPIBundle\DataMapper\Annotation as DataMapper;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="user")
 * @DataMapper\Mapper()
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $username;

    /**
     * @DataMapper\String()
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @DataMapper\String()
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
```

Available data mapper types
---------------------------

```
@DataMapper\String()
@DataMapper\Int()
@DataMapper\Float()
@DataMapper\Number()
@DataMapper\Bool()
@DataMapper\Date()
@DataMapper\Time()
@DataMapper\DateTime()
@DataMapper\Timestamp()
@DataMapper\Collection()
@DataMapper\Object()
```

Data types `@DataMapper\Date()`, `@DataMapper\Time()`, `@DataMapper\DateTime()`, `@DataMapper\Timestamp()` require
that PHP object value will be **DateTime** object.

Data types `@DataMapper\DateTime()`, `@DataMapper\Date()`, `@DataMapper\Time()`, `@DataMapper\Number()` support custom parameters. 
`@DataMapper\DateTime()`, `@DataMapper\Date()` and `@DataMapper\Time()` support **format** parameter that uses standard PHP date format.
By default `@DataMapper\Date()` returns date - "Y-m-d", `@DataMapper\Time()` returns time - "H:i:s". Both these methods can return
full date and time like a string if user use **format="Y-m-d H:i:s"**. `@DataMapper\DateTime()` by default return PHP **DateTime** object.
If there is need to return only date and time string user should use optional parameter **object=false**. 
`@DataMapper\Number()` return number as string. It support **decimals**, **separator**, **thousand_separator** parameters. This
method deal with object value same like PHP function *number_format*.  
  
Using profiler
---------------------------

RAPIBundle profiler give you possibility to optimize your code when your developing your application.  
To enable profiler you should edit `web/app_dev.php` file.
  
Change lines   

```php
$response->send();
$kernel->terminate($request, $response);
```
  
to these. Order is important.  
  
  
```php
$kernel->terminate($request, $response);
Profiler::get($kernel->getContainer(), $response);
$response->send();  
```
  
**Remember: use profiler only in development environment!!!**  

Change Log
---------------------------

* Version 1.0.0  
  Init project  
  
* Version 1.0.1  
  Fixed that data mapper will work with Doctrine proxy classes.
  
* Version 1.0.2  
  Moved to bs namespace  
  
* Version 1.0.3  
  Fixed angular js error when come request OPTIONS, now all OPTIONS response code will be 200  
  
* Version 1.0.4  
  Added @request_stact in quates to work with Symfony 3  
  
* Version 1.0.5  
  Added `onKernelException` method that catch all main error and convert these errors to JSON response. Added custom
  parameters to `@DataMapper\DateTime()` (format and object)
  
* Version 1.0.8  
  Fixed request  `get` that values `false` and `0` can be returned.  
  