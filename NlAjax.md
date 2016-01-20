<a href='Hidden comment: revision: 1'></a>

### Gebruik JavaScript bibliotheken ###

Wij raden het gebruik van [jQuery](http://jquery.com) - een eenvoudige en gemakkelijk te begrijpen JS bibliotheek.

### Client side ###

Voor informatie zie [Ajax in jQuery](http://docs.jquery.com/Ajax/jQuery.ajax#options).

Maak een nieuw bestand genaamd:  `/vaw/www/myblog/public/static/js/global.js` met de volgende inhoud:
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

**LET OP** Zorg ervoor dat specificeren "datatype:" json "" voor het best eruit komt.

Neem het script-bestand in de template pagina `/vaw/www/myblog/app/View/layout/inde.html` in de **head** tag:
```
  <script type="text/javascript" src="/static/js/jquery.min.js"></script>
  <script type="text/javascript" src="/static/js/global.js"></script>
```

Wanneer de pagina wordt geladen, zal onze JS script verbinding maken met de `http://localhost/myblog/blog/posts" pagina en het resultaat zal worden weergegeven in een pop-up venster. Voor het gebruik van dit voorbeeld moet u de server opgedeeld hebben in verschillende grotes

### Server Grote ###

In u applicatie moet u een method maken en moet eindigen op `AjaxAction` van de gebruikelijke `Action`. Waarvan deze methode, keren we terug naar de gegevens die worden verzonden naar de cliënt als een antwoord.

**LET OP** Zend data in de [JSON](http://en.wikipedia.org/wiki/JSON) formaat, het resultaat moet gemaakt worden als een array en dan geconverted worden naar JSON behulp van [json\_encode()](http://php.net/json_encode) function.

Maak een nieuw bestand genaamd `/vaw/www/myblog/app/Controller/Blog.php` met een `postsAjaxAction()` methode:
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
Nu kunt u proberen te bellen http://localhost/myblog om te zien dat het werkt. Als alles goed gaat - u zult een bericht met de gegevens die werden geretourneerd door de methode "postsAjaxAction` te zien.