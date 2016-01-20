<a href='Hidden comment: revision: 1'></a>

Alle modellen die gebruikt worden, worden verwerkt in onze blog applicatie. We kunnen gebruik maken van standaard basis phpDays 'modellen, we kunnen ze uitbreiden naar uw wensen en het beste wat bij u past. En dat is wat wij doen.

Als u nog niets gelezen heeft over de de modellen? dan is het tijd om dat te doen. Hieronder wij maken modellen [models](NlLibDaysModel.md) voor onze toepassing.

### Het creëren van modellen voor de blog toepassing ###

In the directory `app/Model` create the following files:
  * `Blog.php` - represents a specific blog. There can be several blogs and each of them has its own subject.
```
<?php
class Model_Blog extends Days_Model {
    protected $_name = 'type: String, min: 2, max: 100, required';
    protected $_url = 'type: String, min: 2, max: 100, required';
    protected $_owner = 'type: User, required';
    protected $_created = 'type: DateTime, now: create, required';
    protected $_changed = 'type: DateTime, now: always, required';
}
```
  * `BlogPost.php` - represents an article in the blog. Comments can be added to an article.
```
<?php
class Model_BlogPost extends Days_Model {
    protected $_name = 'type: String, min: 2, max: 100, required';
    protected $_url = 'type: String, min: 2, max: 100, required, unique';
    protected $_title = 'type: String, max: 255, required';
    protected $_content = 'type: Text, min: 100, required';
    protected $_blog = 'type: Blog, required';
    protected $_category = 'type: BlogCategory';
    protected $_tags = 'type: + BlogTag';
    protected $_author = 'type: User, required';
    protected $_created = 'type: DateTime, now: create, required';
    protected $_media = 'type: + String';
}
```
  * `BlogCategory.php` - is a message category _(music, news, misc, etc.)_
```
<?php
class Model_BlogCategory extends Days_Model {
    protected $_name = 'type: String, min: 2, max: 50, required';
    protected $_url = 'type: String, min: 2, max: 50, required';
}
```
  * ` BlogTag.php `- tags used to mark an article
```
<?php
class Model_BlogTag extends Days_Model {
    protected $_name = 'type: String, min: 2, max: 70, required, unique';
    protected $_url = 'type: String, min: 2, max: 70, required, unique';
}
```
  * `BlogComment` - comments on an article. We'll extend the standard Comment model.
```
<?php
class Model_BlogComment extends Days_Model_Comment {
    protected $_title = 'type: String, required';
    protected $_author = 'type: User, required';
    protected $_post = 'type: BlogPost, required';
    protected $_created = 'type: DateTime, now: create';
}
```
  * `User.php` - a site's user. We'll extend the standard User model.
```
<?php
class Model_User extends Days_Model_User {
    protected $_firstname = 'type: String, min: 2, max: 50';
    protected $_lastname = 'type: String, min: 2, max: 50';
    protected $_birthdate = 'type: DateTime, min: 1950-1-1, required';
}
```

### Wat we hebben gemaakt ###


We hebben een klasse voor modellen die objecten voor een data-opslag. De gegevens worden opgeslagen in een repository en later kunnen we die ophalen en doorgeven aan een gebruiker. Op deze manier doen we niet direct werken met een data-opslag, maar met objecten die automatisch worden geconverteerd naar een data in de repository.

Wat we opmerkte is dat we niet kunnen verklaren over eventuele specialistische gegevens, zoals de belangrijkste gebieden van objecten. Key velden worden automatisch aangemaakt.

Nu is het tijd om verder te gaan tot het creëren [application's controllers](NlStartController.md) van controllers applicaties.