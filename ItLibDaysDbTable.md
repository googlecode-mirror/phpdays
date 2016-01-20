### Informazioni generali ###

[ORM](http://it.wikipedia.org/wiki/Object-relational_mapping) - Ti permette di lavorare con il database usando gli oggetti del linguaggio PHP. Non c'è bisogno di scrive query sql nè per ottenere nè per salvare dati.

ORM ti aiuterà ad accelerare lo svliuppo dell'applicazione e semplificare il processo di aggiornamento di quest'ultima.

### Come funziona ORM ###

Creare una class per la tabella desiderata `blog_category` _(memorizza le categorie dei post)_. Per farlo creare un file in "/var/www/myblog/app/Model/Table/**Blog/Category.php**" con il seguente codice:
```
<?php
class Myblog_Model_Table_Blog_Category extends Days_Db_Table {
    protected $_name = 'blog_category';
}
```

Ottenere l'oggetto di una tabella.
```
$tableBlogCategory = Days_Model::factory('table_blog_category');
```

Ottenere i dati da una tabella:
```
// ottiene informazioni su una categoria
$category = $tableBlogCategory->find('one', array('where'=>array('id'=>10)));
```

```
// Ottenere tutte le categorie
$categories = $tableBlogCategory->find('all');
```
```
// Ottenere 20 subcategorie
$subcategories = $tableBlogCategory->find('all', array(
  // ritorna le sub-categorie con id=10
  'where' => array(
    'pid' = 10
  ),
  // ritorna le prime 20 righe
  'count' => 20
));
```

```
// Ottiene il conto totale delle subcategorie
$countCategories = $tableBlogCategory->find('count', array(
  // return sub-categories with id=10
  'where' => array(
    'pid' = 10
  )
));
```

```
// Ottiene le prime 15 categorie
$firstCaterories = $tableBlogCategory->find('first', array(
  'count' => 15
));
```

```
// Elimina categoria
$category->delete();
```

```
// Rimuove tutte le categorie incluse nel set
$firstCaterories->delete();
```

```
// Crea una nuova riga
$newRow = $subcategories->create();
$newRow->name = 'New subcategory';
// save row
$newRow->save();
```


### Usare Days\_Db\_Table ###

E' una rappresentazione di una vera tabella, e ti permmette di eseguire operazioni su di essa:

  * `find($type, $cond)` - ottiene i risultati in una specifica forma
    * `$type` - in che forma vengono restituiti i risultati
      * `all`: tutte le righe
      * `first`: la prima riga _(свежие записи будут первыми)_
      * `last`: l'ultima riga _(свежие записи будут последними)_
      * `one`: una riga
      * `count`: il numero totale delle righe _(i dati nelle righe non vengono restituiti)_
    * `$cond` - condizione imposta nel risultato
      * `count` _(int)_: conta le righe nel result
      * `page` _(int)_: pagina corrente (parte da 1)
      * `columns` _(array)_: nomi delle colonne
      * `where` _(array)_: come `column=>$value` o `column_with_value`
      * `group` _(array)_: group by columns
      * `order` _(array)_: ordina by columns
  * `create()` - crea un nuovo Rowset vuoto
  * `save(Days_Db_Row $row)` - Salva la specifica riga
  * `delete(Days_Db_Row $row)` - Elimina la specifica riga
  * `join($table)` - Unisce la tabella specifica al risultato

### Usare Days\_Db\_Rowset ###

Rappresenta un set di righe `Days_Db_Row`. Ti permette di cambiare il set di righe.

  * `create(array $data=array())` - crea una nuova riga `Days_Db_Row`
  * `save(Days_Db_Row $row)` - Salva una specifica riga
  * `delete(Days_Db_Row $row)` - Elimina uns specifica riga
  * `count()` - Il numero di righe in un determinato set
  * `toArray()` - Ritorna un set sottoforma di array

Fornisce, inoltre, informazioni sulla riga corrente:
```
// visualizza il nome della prima categoria
echo $categories->name;
```

### Usare Days\_Db\_Row ###

Rappresenta una riga di tabella e ti permette di lavorare con essa:

  * `save()` - salva la linea corrente
  * `delete()` - elimina la linea corrente
  * `toArray()` - ritorna la linea corrente come un array
  * `parent` - prende tutti gli elementi parent _(se hai un column id e pid)_
  * `child` - prende tutti gli elementi childs _(se hai un column id e pid)_
  * `table_name` - Prende i relativi records dalla tabella specifica _(for categories of table `blog_category` object table `blog` need to specify just `category` instead of `blog_category`)_