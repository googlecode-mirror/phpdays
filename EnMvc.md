<a href='Hidden comment: revision: 1'></a>

[MVC](http://en.wikipedia.org/wiki/Model–view–controller) is an architectural solution that allows to separate different parts of an application from each other. Due to this approach, it becomes easier to understand the project and for new members to learn its features.

Start thinking differently and use the following rules when creating a new application:

  * [Controller](EnController.md) - decides what actions to perform. It uses different models to obtain data and then passes the data to the view component.
  * [View](EnView.md) - displays information. It represents a template html page in which data prepared by the controller is inserted
  * [Model](EnModel.md) - retrieves and modifies information in a database