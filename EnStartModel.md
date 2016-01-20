<a href='Hidden comment: revision: 1'></a>

We need to create all the models that might be used in our blog application. We can use phpDays' standard _basic models_, as well as we can expand them to fit your requirements. And that is what we'll do.

If you have not read about [models](EnLibDaysModel.md) yet - now it's time to do it. Below we'll create models for our application.

### Creating models for the blog application ###

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

### What we've created ###

We have created a class for models that represent objects of a data storage. The data is stored in a repository and later we can retrieve it and pass it to a user. This way we do not work directly with a data storage but with objects that are automatically converted to a data in the repository.

Notice that we did not declare any specialized data, such as key fields of objects. Key fields are created automatically.

Now it's time to move on to creating [application's controllers](EnStartController.md).