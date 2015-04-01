# LEmber

###  Introduction

I have been working quite a bit with Ember recently and I wanted to create Ember Data formatted responses including 
sideloading. This proeject utilizes Fractal's JsonApiSerializer and tweaks it a bit to create json responses that 
are consumable by ember-data.

**This is still a work in progress, so if you have stumbled across this please do not use just yet**

### Example


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
