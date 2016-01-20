Wenn Sie sich mit dem Projekt vertraut gemacht haben und sich daran beteiligen möchten, dann sollten Sie sich die folgenden Punkte durchlesen.

### Dem phpDays Team beitreten ###

  * Erstellen Sie eine Beitrittsanfrage als Kommentar auf der [Diskussionsseite](DeAnswers.md) oder senden diese der [project support group](http://groups.google.com/group/phpdays-ru) (russisch)
  * Beschreiben Sie in der Mitteilung, welche Aufgabe Sie übernehmen möchten _(PHP Entwickler, Webdesigner, Dokumentations-Übersetzer, Schriftsetzer (typesetter), JavaScript Entwickler)_ und teilen Sie uns ihre Gmail-Adresse mit _(der Gmail Benutzername reicht aus)_
  * Wir werden uns dann Gedanken über Ihre Aufnahme machen und Ihnen unsere Entscheidung in spätestens drei Tagen mitteilen _(haben wir uns bis dahin immer noch nicht gemeldet, so senden Sie Ihre Anfrage bitte noch einmal)_
  * Wenn alles gut geht, werden Sie ein Mitglied des Projekts und erhalten einige Berechtigungen, die Nichtmitglieder nicht haben _(Sie können dann den Code und die Dokumentation des Projekts ändern und Verbesserungsvorschläge anbringen)_
  * Außerdem werden Sie zur [Mitgliederliste](http://code.google.com/p/phpdays/people/list) hinzugefügt _(Vergessen Sie nicht diesen Link, Sie könnten ihn für Ihren Lebenslauf brauchen)_

### Grundsätzliche Informationen über diese Seite ###

  * [Downloads](http://code.google.com/p/phpdays/downloads/list) - Downloadseite, hier können die funktionierenden Versionen des Projekts heruntergeladen werden, gedacht für die Endbenutzer
  * [Wiki](http://code.google.com/p/phpdays/w/list) - die Dokumentation
  * [Issues](http://code.google.com/p/phpdays/issues/list) - Liste von Fehlern und Verbesserungsvorschlägen
  * [Source](http://code.google.com/p/phpdays/source/list) - Informationen über das SVN Projektarchiv und der dazugehörige Changelog

### Uploaden der Arbeitskopie ###

  * Downloaden und installieren Sie einen SVN Client um mit den Projektdateien arbeiten zu können
  * Downloaden Sie dann die Arbeitskopie _(weitere Informationen gibt es hier: [Checkout](http://code.google.com/p/phpdays/source/checkout))_
  * Wenn Sie noch nie mit einer Subversion gearbeitet haben, sollten Sie sich Zeit nehmen dies zu erlernen

### Richtlinien für das Vornehmen von Änderungen _(SVN Commit)_ ###

Kommentare sollten in folgender Weise formatiert werden:

  * `Fix #1234: Name des Fehlers` - wenn Fehlernummer `1234` gefixt wurde. Wenn der Fehler nicht in der [Issues-Liste](http://code.google.com/p/phpdays/issues/list) ist, sollten Sie ihn hinzufügen und erst dann ein `SVN Commit` machen.
  * Schreiben Sie bitte jeden Fehler in eine extra Zeile und beenden Sie jede Zeile mit einem Punkt.

### Die Veränderungen zuerst testen ###

Richten Sie [PHPUnit](http://blogs.sun.com/netbeansphp/entry/recent_improvements_in_phpunit_support) ein. Damit können Sie einen Unittest machen, um sicherzugehen, dass der veränderte Code nicht an einer anderen Stelle zu Fehlern führt. Sie sollten immer erst einen Unittest vor dem `SVN Commit` durchführen.

### besseren Code schreiben ###

Lesen Sie sich den [Coding Style](DeCodingStyle.md) unseres Projekts durch. Nutzen alle Coder den gleichen Style, so vereinfacht es das für alle, den Code nachzuvollziehen.