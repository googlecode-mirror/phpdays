### Usare librerie JavaScript ###

Si consiglia l'uso di [jQuery](http://jquery.com), un semplice framework JavaScript.

### Lato Client ###

Per ulteriori informazioni visitare [Ajax in jQuery](http://docs.jquery.com/Ajax/jQuery.ajax#options).

Creare un nuovo file chiamato `/var/www/myblog/public/static/js/global.js` con il seguente codice:

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

**ATTENZIONE** Siate sicuri di specificare `dataType: 'json'` per una migliore visualizzazione.

Includere lo script nella pagina di template `/var/www/myblog/app/View/layout/index.html`
> quindi all'interno dei tag 

&lt;head&gt;

 

&lt;/head&gt;

 inserire:

```
  <script type="text/javascript" src="/static/js/jquery.min.js"></script>
  <script type="text/javascript" src="/static/js/global.js"></script>
```

Ora quando la pagina verrà caricare, il nostro script JS si collegherà a `http://localhost/myblog/blog/posts` e i risultati verranno visualizzati in una finestra popup. Per utilizzare correttamente questo esempio c'è bisogno di implementare la parte di codice Lato Server.

### Lato Server ###

Nella tua applicazione dovrai creare un metodo con un nome che finisce con `AjaxAction` invece del classico `Action`. Da questo metodo ritorneranno i dati che verranno inviati al client.

**ATTENZIONE** Per inviare dati nel formato [JSON](http://en.wikipedia.org/wiki.JSON), i risultati devono essere creati come un array e poi convertiti in JSON usando la funzione [json\_encode()](http://php.net/json_encode).


Creare un nuovo file chiamato `/var/www/myblog/app/Controller/Blog.php` con un metodo chiamato `postsAjaxAction()`.
```
class Myblog_Controller_Blog extends Days_Controller {
  /** Ritorna i dati in JSON */
  public function postsAjaxAction() {
    // Ottiene i records da un database e ritorna in un array multidimensionale.
    $data = array('name'=>'Jimmi', 'age'=>23, 'country'=>'USA');
    return json_encode($data);
  }
}
```

Ora puoi provare a visitare la pagina http://localhost/myblog per vedere se funziona.
Se tutto va a buon fine potrai vedere un messaggio con i dati che sono stati passati dal metodo `postsAjaxAction()`.