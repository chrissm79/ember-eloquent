# Eloquent-Ember

###  Introduction

I have been working quite a bit with Ember recently and I wanted to create Ember Data formatted responses including 
sideloading. This proeject utilizes Fractal's JsonApiSerializer and tweaks it a bit to create json responses that 
are consumable by ember-data.

**This is still a work in progress, so please use with caution**

### Installation

Install the composer package
```bash
composer require nuwave/eloquent-ember
```

Publish the config file
```bash
php artisan vendor:publish
```

Add the service provider to you app.php file
```php
'NuWave\Serializers\SerializerServiceProvider',
```

Create your model transformers (Fractal)

[Fractal Transformer Guide](http://fractal.thephpleague.com/transformers/)

Edit the config file with your application namespace (optional: you can also add a suffix if your naming convension utilizes it)
```php
// config/ember.php

return [
    /*
    |---------------------------------------------------------------------
    | Transformer Namespace
    |---------------------------------------------------------------------
    |
    | Set the default namespace for your transformer
    |
    */
    'namespace' => 'ExampleNamespace\Translators',

    /*
    |---------------------------------------------------------------------
    | Transformer Suffix
    |---------------------------------------------------------------------
    |
    | Set the suffix for your transformer naming convention.
    |
    | Default value is null
    */
    'suffix' => null
];
```

Add EmberTrait to your controllers (or your base Controller). This will allow you to utilize the emberResponse
method which takes your Model/Collection along with the model name and transforms it into an ember-data
formatted response.
```php
class UserController extends Controller {

  use EmberTrait;

  public function index()
  {
    $users = User::all();
    
    // or
    
    $users = User::paginate(20); // meta data will be included in response
    
    return $this->emberResponse($users, 'User');
  }
  
  // ...
  
  public function show($id)
  {
    $user = User::find($id);
    
    return $this->emberResponse($user, 'User');
  }
}
```
