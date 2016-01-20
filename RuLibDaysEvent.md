## Общие сведения ##

Класс [Days\_Event](http://code.google.com/p/phpdays/source/browse/trunk/lib/Days/Event.php) реализует шаблон проектирования [Observer](http://ru.wikipedia.org/wiki/Наблюдатель_(шаблон_проектирования)). Позволяет подписаться на определенное событие и производить оповещение подписчиков при наступлении этих событий. На одно событие может быть подписано несколько слушателей и каждый из них будет оповещен о наступлении события.

События бывают системными и пользовательскими.

### Системные события ###

**engine.start** - событие наступает сразу после чтения конфигурационного файла, до начала работы ядра фреймворка.

**controller.start** - событие, отрабатывающее сразу после определения какой контроллер нужно выполнять, перед исполнением самого контроллера.

**controller.post.init** - наступает после отработки метода init() вызываемого контроллера.

**controller.end** - событие после получения контента от контроллера, но до включения его в контент страницы.

**engine.end** - событие завершения работы ядра фреймворка.

**response.send.headers** - событие перед отправкой заголовков сгенерированной страницы.

**response.send.content** - событие перед отправкой контента страницы.

Подписаться на ранние события ядра можно, создав файл `app/Controller/System/Autorun.php` с классом `App_Controller_System_Autorun`, где App - префикс вашего приложения.
```
class App_Controller_System_Autorun {
    /**
     * Defines a list of subscribers to the event
     */
    public static function run() {
        Days_Event::add('engine.start', 'session_start');
    }
}
```

В статическом методе `run()` указываем вызовы `Days_Event::add()` и остальной код, который необходимо выполнить сразу после инициализации ядра фреймворка. Параметр `engine/autorun` в [конфигурационном файле](RuLibDaysConfig.md) приложения должен быть равен `true`.

#### Пример ####

Подписка на событие **engine.end**
```
Days_Event::add('engine.end', array('Days_Log', 'save'));
```

### Пользовательские события ###

В своем приложении Вы можете определять произвольные события. При этом ответственность за оповещение подписчиков о наступлении пользовательских событий ложиться на приложение. Для таких событиях перед названием события указываем префикс приложения.

#### Примеры ####

1) События в классе [Days\_User](RuLibDaysUser.md) фреймворка
```
class Days_User {
  public function login($username, $password) {
    Days_Event::run('user.login.before');
    // process loginning
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

2) Пользовательские события в приложении
```
class App_Model_Rss {
  public function import($path) {
    Days_Event::run('app.rss.import.before');
    // process loginning
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

3) Подписка на пользовательские события в приложении
```
// основное событие Days
Days_Event::add('user.login.success', 'userSuccessLogged');
// функция вызывается при успешном входе пользователя на сайт
function userSuccessLogged() {
  echo 'You logged successfully on site!';
}

// событие Вашего приложения
Days_Event::add('myapp.rss.import.fail', 'rssNotLoaded');
// callback функция (функция обратного вызова)
function rssNotLoaded() {
  echo 'RSS not loaded. Enter correct URL adress';
}
```