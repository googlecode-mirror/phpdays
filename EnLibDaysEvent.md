<a href='Hidden comment: revision: 1'></a>

## Overview ##

The [Days\_Event](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Event.php) class implements an [Observer](http://en.wikipedia.org/wiki/Observer_pattern) design pattern. It allows to subscribe to a specific event and be notified upon the occurrence of the event. One event can have several listeners and each one of them will be notified when the event occurs.

Events can be system or user events.

### System Events ###

**engine.start** - this event occurs immediately after reading the configuration file, prior to the framework core's start up.

**controller.start** - this event occurs immediately after a controller has been chosen but before the execution of the controller.

**controller.post.init** - this event occurs after a controller's init() method.

**controller.end** - this event occurs after receiving content from a controller, but before including it in the page's content.

**engine.end** - this event occurs when the framework core is finished.

**response.send.headers** - this event occurs before sending headers of a generated page.

**response.send.content** - this event occurs before sending the page's content.

You can subscribe to the earlier system events by creating a `app/Controller/System/Autorun.php` file with a `App_Controller_System_Autorun class`, where App is a prefix of your application.
```
class App_Controller_System_Autorun {
    / **
     * Defines a list of subscribers to the event
     */
    public static function run() {
        Days_Event::add('engine.start', 'session_start');
    }
}
```

In the static method `run()`, call `Days_Event::add` and the rest of the code that must be executed immediately after the framework's core initialization. The `engine/autorun` parameter in the application's [configuration file](EnLibDaysConfig.md) must be equal to `true`.

#### An Example ####

Subscribing to the **engine.end** event
```
Days_Event:: add('engine.end', array('Days_Log', 'save'));
```

### User Events ###

In your application, you can define your own custom events. In this case, your application is responsible for notifying subscribers when a custom event occurs. Start names of the custom events with your application's prefix.

#### Examples ####

1) Events from the framework's [Days\_User](EnLibDaysUser.md) class
```
class Days_User {
  public function login($username, $password) {
    Days_Event::run('user.login.before');
    // Process logging
    if (/* logged well */) {
      Days_Event::run('user.login.success');
      ...
    }
    else {
      Days_Event::run('user.login.fail');
      ...
    }
    Days_Event::run('user.login.after');
  }
...
```

2) A custom event in the annex
```
class App_Model_Rss {
  public function import($path) {
    Days_Event::run('app.rss.import.before');
    // Process logging
    if (/* data loaded from RSS */) {
      Days_Event::run('app.rss.import.success');
      ...
    }
    else {
      Days_Event::run('app.rss.import.fail');
      ...
    }
    Days_Event::run('app.rss.import.after');
  }
}
```

3) Subscribing to user events in the annex
```
// Main Event Days
Days_Event::add('user.login.success','userSuccessLogged');
// Function called when the user logs on to a successful site
function userSuccessLogged() {
  echo 'You logged successfully on site!';


// Event of your application
Days_Event::add('myapp.rss.import.fail', 'rssNotLoaded');
// Callback function (callback)
function rssNotLoaded() {
  echo 'RSS not loaded. Enter correct URL adress';
}
```