[MVC](http://it.wikipedia.org/wiki/Model-View-Controller) è una struttura di programmazione per separare parti differenti di un applicazione dalle altre. Con questo schema diventa facile per i nuovi membri apprendere le funzionalità del progetto stesso.

Segui queste semplici regole quando crei un applicazione:

  * [Controller](ItController.md) - Decide quale azione si deve svolgere. Usa vari modelli per ottenere i dati e li passa al componente View.
  * [View](ItView.md) - Visualizza le informazioni. Rappresenta una pagina html (template) dove i dati vengono passati dal Controller.
  * [Model](ItModel.md) - Riceve e modifica informazioni da un database.