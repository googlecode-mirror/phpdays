<a href='Hidden comment: revision: 1'></a>

### Using JavaScript libraries ###

We recommend using [jQuery](http://jquery.com) - a simple and easy to understand JS library.

### Client side ###

For more information see [Ajax in jQuery](http://docs.jquery.com/Ajax/jQuery.ajax#options).

Create a new file named `/vaw/www/myblog/public/static/js/global.js` with the following content:
```
$(document).ready(function(){

  $.ajax({
    url: 'http://localhost/myblog/blog/posts',
    dataType: 'json',
    success: function(data) {
      alert(data);
    }
  });

});
```

**ATTENTION** Be sure to specify `dataType: 'json'` for best appearance.

Include the script file in the template page `/vaw/www/myblog/app/View/layout/inde.html` within the **head** tag:
```
  <script type="text/javascript" src="/static/js/jquery.min.js"></script>
  <script type="text/javascript" src="/static/js/global.js"></script>
```

Now when the page loads, our JS script will connect to the `http://localhost/myblog/blog/posts` page and the result will be displayed in a popup window. To use this example you have to implement the server side part.

### Server side ###

In your application, you should create a method with a name ending with `AjaxAction` instead of the usual `Action`. From this method, we return data that will be sent to the client as a response.

**ATTENTION** To send data in the [JSON](http://en.wikipedia.org/wiki/JSON) format, the result must be created as an array and then converted to JSON using the [json\_encode()](http://php.net/json_encode) function.

Create a new file named `/vaw/www/myblog/app/Controller/Blog.php` with a `postsAjaxAction()` method:
```
class Controller_Blog extends Days_Controller {
  /** Return data in JSON */
  public function postsAjaxAction() {
    // obtain records from the database and return in the form of a multidimensional array
    $data = array('name'=>'Jimmi', 'age'=>23, 'country'=>'USA');
    return json_encode($data);
  }
}
```

Now you can try to call http://localhost/myblog to see that it works. If all goes well - you'll see a message with the data that were returned by the method `postsAjaxAction`.