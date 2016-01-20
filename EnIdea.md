<a href='Hidden comment: revision: 1 '></a>

On this page we discuss new ideas for phpDays. Post your ideas below in comments.

## Models with data checking ##

I am learning the **Python** language and its **Django** framework. I am also learning about the **Google AppEngine**.

I like its models very much. We do not create a database and do not describe a database in files. We create model classes with field descriptions. At launch, our application generates a database structure and then uses it. Very simple to use!

For example, to create a model class _(see [more examples](http://code.google.com/p/phpdays/source/browse/#svn/trunk/apps/phpdays.org/app/Model))_:
```
class Model_Blog extends Days_Model {
    protected $_name    = 'type: String, min: 2, max: 100, required';
    protected $_url     = 'type: String, min: 2, max: 100, required';
    protected $_owner   = 'type: User, required';
    protected $_created = 'type: DateTime, now: create, required';
    protected $_changed = 'type: DateTime, now: always, required';
}

/** Create new model based on Days base model */
class Model_User extends Days_Model_User {
    protected $_firstname = 'type: String, min: 2, max: 50';
    protected $_lastname  = 'type: String, min: 2, max: 50';
    protected $_birthdate = 'type: DateTime, min: 1950-1-1, required';
}
```

The base class `Days_Model` implements base methods for different field types.

Also the database structure is generated from this file (using reflection).

### How it works ###

Select all users, who post comments today in blog "About life":
```
$comments = new Model_BlogComment('created<=:1 AND created>=:2', '2009-12-12 23:59:59', '2009-12-12 00:00:00');
$blogs = new Model_Blog('name=:1', 'About life');
// create user object
$users = new Model_Users();
// add conditions from referenced models
$users->with($comments, $blogs);

// show all users
foreach ($users as $user) {
  echo "{$user->name} wrote today<br>";
}
```

Find all blog posts, where current user write comment:
```
// find user by email
$user = new Model_Users('email=:1', 'Ilove@phpdays.org');
// find all blog comments wroted by current user
$comments = new Model_BlogComment('author=:1', $user);
// find blog posts
$blogPosts = new Model_BlogPost();
$blogPosts->with($comments);

// show all blog posts
foreach ($blogPosts as $blogPost) {
  echo "User {$user->name} wrote in blog post '{$blogPost->name}'<br>";
}

// find all blog posts, where current user is owner
// and wrote one or more comments in this post
$myBlogPosts = new Model_BlogPost();
$myBlogPosts->with($comments, $user);
```

Find all comments in blogs, owned by specified users only:
```
// find users by email
$users = new Model_Users('email=:1',
                         array(
                           'user1@phpdays.org',
                           'user2@phpdays.org',
                           'user3@phpdays.org'
                         ));
// find blogs, owned by users
$blogs = new Model_Blog('owner=:1', $users);
// find comments from this blogs
$comments = new Model_BlogComment('blog=:1', $blogs);
```

### Development ###

See code of [Days\_Model](http://code.google.com/p/phpdays/source/browse/branches/models_like_python/lib/Days/Model.php) class. This main class for implement this perfect functionality.

Please, help us implement this in this month. This need as main goal in release **phpDays 1.1**.

If user use call `witch(model1, model2, ...)` - than into model processed:
  * all models cached in one array where described all models. This file saved once, and regenerated on each change in model classes
  * find all pathes from current model to all specified models. If not find - throw exception
  * join all model tables and set "where" conditions from passed models
  * for represent ROW need use Days\_Db\_Row class _(need to create it)_
  * execute statement and fill all rows for current model only. This execute only by first call `__get()` _(and equialent)_ method for recive data from model


---


## Validator ##

[Days\_Validate](EnLibDaysValidate.md) - check a variable by criteria and return `true` only if its value is valid.

```
$age = 21;
$mail = 'Tom@Jerry.com';
// not good format of criteria
if (Days_Validator::check($age, array('int'=>array('max'=>50, 'min'=>18))))
  echo 'You are full of strength!';
// good format of criteria
if (Days_Validator::check($age, 'int: {max: 50, min: 18}'))
  echo 'You are full of strength!';
// many criterias
if (Days_Validator::check($mail, 'str: {max: 70}, email, required'))
  echo 'Name correct!';
```

Tasks:
  * simplify a criteria format _(good if data passes as string `check($age, 'int: {max: 50, min: 18}')` or similar format)_


---


## Event ([issue #15](https://code.google.com/p/phpdays/issues/detail?id=#15)) ##

[Days\_Event](EnLibDaysEvent.md) - an implementation of the Observer pattern. Helps join many components to one system without changes in any component.

Days library events:
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

Your application events are in the [models](EnLibDaysModel.md) _(add the name of your application before an event name)_:
```
class Myapp_Model_Rss {
  public function import($path) {
    Days_Event::run('myapp.rss.import.before');
    // process loginning
    if (/* data loaded from RSS */) {
      Days_Event::run('myapp.rss.import.success');
      ...
    }
    else {
      Days_Event::run('myapp.rss.import.fail');
      ...
    }
    Days_Event::run('myapp.rss.import.after');
  }
}
```

Now, we have to add a forum with a user authorization to the site. We use events in the forum.
```
// general Days event
Days_Event::add('user.login.success', 'userSuccessLogged');
// function called on success logging
function userSuccessLogged() {
  echo 'You logged successfully on site!';
}
// your application event
Days_Event::add('myapp.rss.import.fail', 'rssNotLoaded');
// callback function
function rssNotLoaded() {
  echo 'RSS not loaded. Enter correct URL adress';
}
```

**See:** [Kohana events](http://docs.kohanaphp.com/general/events), [Zend Observer](http://devzone.zend.com/article/4284-Observer-pattern-in-PHP).


---


## Form ##

[Days\_Form](EnLibDaysForm.md) - process html forms. If all data is passed correctly - execute a form handler.

```
$form = new Days_Form('user_register');
// form sended
if ($form->sended()) {
  // form valid
  if ($form->valid()) {
    // register user
  }
  // incorrect filled form
  else {
    // show form with error messages
    $this->errors = $form->errors();
  }
}
```

Form settings saved into file `app/config/forms.yaml`

```
user_register:
  User.name: {}
  User.email: {}
  User.posts: {disabled}
  User.role: {}
```