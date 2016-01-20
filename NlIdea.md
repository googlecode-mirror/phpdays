<a href='Hidden comment: revision: 1 '></a>

Op deze pagina hebben we nieuwe ideeën te bespreken voor phpDays. Plaats uw ideeën hieronder in opmerkingen.

## Modellen met controle van de gegevens ##

Ik ben het leren van de Python  taal en haar **Django** kader. Ik ben ook leren over de **Google! AppEngine**.

Ik vind modellen zeer leuk. Wij creëren geen een database en geen beschrijving van een database in bestanden. Wij creëren model klassen met veld-beschrijvingen. Bij de lancering, onze applicatie genereert een database structuur en dat wordt vervolgens weer gebruikt. Dus het is zeer eenvoudig te gebruiken!

Bijvoorbeeld, het creëren van een model klasse _(Kijk voor [voorbeelden](http://code.google.com/p/phpdays/source/browse/#svn/trunk/apps/phpdays.org/app/Model))_:
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

De basis klasse `Days_Model` implementeert uitvalsbasis voor verschillende soorten velden.

Ook de database structuur wordt gegenereerd uit dit bestand (met behulp van reflectie).

### Hoe werkt het ###

Selecteer alle gebruikers, die reacties plaatsen vandaag in blog "Over leven":
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

Vind alle blog posts, waar de huidige gebruikers schrijven:
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

Zoek alle reacties in blogs, eigendom van de gespecificeerde gebruikers alleen:
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

### Ontwikkeling ###

Zie de code [Days\_Model](http://code.google.com/p/phpdays/source/browse/branches/models_like_python/lib/Days/Model.php) class. Deze belangrijkste klasse voor de uitvoering van deze perfecte functionaliteit.

Alsjeblieft, help ons met het inplannen van deze maand. Deze is het belangrijkste voor onze eerste release **phpDays 1.1**.

If user use call `witch(model1, model2, ...)` - than into model processed:
  * Alle modellen worden opgeslagen in een array en waar alle modellen worden beschreven. Zodra dit bestand eenmaal is opgeslagen, worden er klasse gegenereerd.
  * Vindt alle Pathes van het huidige model naar alle gespecificeerde modellen.
  * Join alle modeltabellen en zet "waar" voorwaarden van modellen voorbij.
  * Voor vertegenwoordigen ROW nodig gebruik Days\_Db\_Row klasse _(nodig om het te maken)_
  * Uitvoeren verklaring en vul alle rijen voor huidige model alleen. Deze voeren alleen door eerste gesprek "get ()` _(en equialent)_ methode voor Recive gegevens van model


---


## Validator ##

[Days\_Validate](NlLibDaysValidate.md) - controleer of een variabele door criteria en terugkeer heeft gemaakt en een `echte waarde heeft.
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

[Days\_Event](NlLibDaysEvent.md) - een implementatie van de Observer patroon. Helpt join veel componenten op een systeem zonder wijzigingen in een component.

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

Jou appplicatie events zijn in de [models](NlLibDaysModel.md) _(voeg de naam van uw aanvraag voor een evenement naam)_:
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

Nu hebben we een forum toe te voegen met een gebruiker toestemming aan de site. We gebruiken gebeurtenissen in het forum.
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

[Days\_Form](NlLibDaysForm.md) - proces HTML-formulieren. Als alle gegevens correct worden doorgegeven - dan is de uitvoering van een formulier handler.