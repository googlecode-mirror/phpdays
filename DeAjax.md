### Die JavaScript Libraries nutzen ###

Wir empfehlen [jQuery](http://jquery.com) zu nutzen - einer einfach zu verstehenden JS Library.

### Für den Client ###

Weitere Informationen gibt es hier: [Ajax in jQuery](http://docs.jquery.com/Ajax/jQuery.ajax#options).

Erstelle eine neue Datei namens `/vaw/www/myblog/public/static/js/global.js` mit folgendem Inhalt:
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

**Hinweis** Es ist wichtig den `dataType: 'json'` auszuwählen, damit das Erscheinungsbild am besten ist.

Binde die Scriptdatei in die Template Seite `/vaw/www/myblog/app/View/layout/inde.html` im **head** Tag ein:
```
  <script type="text/javascript" src="/static/js/jquery.min.js"></script>
  <script type="text/javascript" src="/static/js/global.js"></script>
```

Wenn nun die Seite lädt, wird sich unser JS Script zur `http://localhost/myblog/blog/posts` Seite verbinden und das Ergebniss wird in einem Popup-Fenster ausgegeben. Um dieses Beispiel auszuprobieren, müssen Sie auch den Serverpart beachten.

### Für den Server ###

In Ihrer Anwendung sollten Sie eine Methode definieren mit `AjaxAction` am Namensende anstatt des normalen `Action`. Von dieser Methode erhalten wir Daten, die dem Client als Antwort gesendet werden.

**Hinweis** Um Daten im [JSON](http://en.wikipedia.org/wiki/JSON) Format zu senden, muss das Ergebnis als Array erzeugt werden und dann in JSON konvertiert werden mithilfe der [json\_encode()](http://php.net/json_encode) Funktion.

Erstelle eine neue Datei namens `/vaw/www/myblog/app/Controller/Blog.php` mit einer `postsAjaxAction()` Methode:
```
class Myblog_Controller_Blog extends Days_Controller {
  /** Gib Daten im JSON Format wieder */
  public function postsAjaxAction() {
    // erhalte Records von der Datenbank und gib sie zurück in der Form eines multidimensionalen Arrays
    $data = array('name'=>'Jimmi', 'age'=>23, 'country'=>'USA');
    return json_encode($data);
  }
}
```

Jetzt können Sie probieren http://localhost/myblog aufzurufen um zu sehen, ob es funktioniert. Wenn alles funktioniert sehen Sie eine Nachricht mit den Daten von der `postsAjaxAction` Methode.