### allgemeine Informationen ###

Mit [ORM](http://de.wikipedia.org/wiki/Object-Relational_Mapping) können Sie mit Datenbanken arbeiten, als würden Sie mit Objekten von PHP arbeiten. Sie brauchen keine SQL Abfragen zu schreiben, um Daten zu erhalten oder speichern. Anstelle dessen müssen Sie die Methoden benutzen, um Daten zu erhalten.

ORM wird Sie dabei unterstützen, die Entwicklung zu beschleunigen und vereinfacht es, Änderungen in der Zukunft vorzunehmen.

### Wie funktioniert ORM? ###

Erstelle eine Klasse für für die Tabelle `blog_category` _(enthält die Kategorie Posts)_. Dafür erstellen wir eine Datei "/var/www/myblog/app/Model/Table/**Blog/Category.php**" mit der Klassendefinition:
```
<?php
class Myblog_Model_Table_Blog_Category extends Days_Db_Table {
    protected $_name = 'blog_category';
}
```

Ermittle das erforderliche Tabellenobjekt. Das wird folgenderweise gemacht:
```
$tableBlogCategory = Days_Model::factory('table_blog_category');
```

Erhalte die Daten aus der Tabelle:
```
// erhalte Information über eine Kategorie
$category = $tableBlogCategory->find('one', array('where'=>array('id'=>10)));
```

```
// erhalte alle Kategorien
$categories = $tableBlogCategory->find('all');
```

```
// erhalte 20 Unterkategorien
$subcategories = $tableBlogCategory->find('all', array(
  // gib die Unterkategorien mit id=10 zurück
  'where' => array(
    'pid' = 10
  ),
  // gib die ersten 20 Reihen zurück
  'count' => 20
));
```

```
// erhalte die Anzahl an Subkategorien
$countCategories = $tableBlogCategory->find('count', array(
  // gib die Unterkategorien mit id=10 zurück
  'where' => array(
    'pid' = 10
  )
));
```

```
// erhalte die ersten 15 Kategorien
$firstCaterories = $tableBlogCategory->find('first', array(
  'count' => 15
));
```

```
// lösche Kategorie
$category->delete();
```

```
// lösche alle Kategorien des Sets
$firstCaterories->delete();
```

```
// erstelle eine neue Zeile
$newRow = $subcategories->create();
$newRow->name = 'New subcategory';
// speichere Zeile
$newRow->save();
```

### Days\_Db\_Table benutzen ###

Das ist eine Darstellung einer echten Tabelle und ermöglicht Ihnen, Funktionen auf dieser Tabelle auszuführen.

  * `find($type, $cond)` - erhalte das Ergebnis in der vorgegebenen Art
    * `$type` - in welcher Art das Ergebnis ausgegeben werden soll
      * `all`: alle Zeilen
      * `first`: alle Zeilen sortiert nach Datum _(свежие записи будут первыми)_
      * `last`: alle Zeilen sortiert nach Datum _(свежие записи будут последними)_
      * `one`: eine Zeile
      * `count`: Gesamtzahl an Zeilen _(Die Zeilen selbst werden nicht ausgegeben)_
    * `$cond` - Bedingungen die das Ergebnis verändern
      * `count` _(int)_: Anzahl der Zeilen im Ergebnis
      * `page` _(int)_: aktuelle Seitennummer (beginnt bei 1)
      * `columns` _(array)_: Spaltennamen
      * `where` _(array)_: Paare `column=>$value` oder `column_with_value`
      * `group` _(array)_: Gruppe nach Spalten
      * `order` _(array)_: sortieren nach Spalten
  * `create()` - erzeugt eine neue leere Zeile
  * `save(Days_Db_Row $row)` - speichert angegebene Zeile
  * `delete(Days_Db_Row $row)` - löscht angegebene Zeile
  * `join($table)` - fügt die angegebene Tabelle dem Ergebnis hinzu

### Days\_Db\_Rowset benutzen ###

Repräsentiert die Gruppe der Zeilen `Days_Db_Row`. Erlaubt Ihnen diese zu ändern.

  * `create(array $data=array())` - erstelle neue Zeile `Days_Db_Row`
  * `save(Days_Db_Row $row)` - speichert angegebene Zeile
  * `delete(Days_Db_Row $row)` - löscht angegebene Zeile
  * `count()` - Anzahl der Zeilen in der angegebenen Gruppe
  * `toArray()` - gibt eine Gruppe an Zeilen als Array zurück

Enthält auch die Daten der aktuellen Zeile, als würden wir mit dieser Zeile arbeiten.
```
// Gebe den Namen der ersten Kategorie aus
echo $categories->name;
```

### Days\_Db\_Row benutzen ###

Repräsentiert eine Tabellenzeile und erlaubt ihnen, diese zu bearbeiten.

  * `save()` - speichert die aktuelle Zeile
  * `delete()` - löscht die aktuelle Zeile
  * `toArray()` - gibt die aktuelle Zeile als ein Array zurück
  * `parent` - erhalte alle Parent-Elemente _(wenn Sie eine Spalten ID und PID haben)_
  * `child` - erhalte alle Child-Elemente _(wenn Sie eine Spalten ID und PID haben)_
  * `table_name` - erhalte ähnliche Records von der angegebenen Tabelle _(für Kategorien der Tabelle `blog_category` müssen Sie bei der Objekttabelle `blog` nur `category` angeben anstelle von `blog_category`)_