<a href='Hidden comment: revision: 1'></a>

If you've become familiar with the project and feel confident and interested in the participating in it, then read the following guidelines.

### Joining the phpDays team ###

  * leave your request to join the team as a comment on the [Discussions](EnAnswers.md) page or send it to [project support group](http://groups.google.com/group/phpdays-en)
  * in your message state a role you would like to take on _(php developer, web designer, documentation translator, typesetter, JavaScript developer)_ and include your Gmail address _(your Gmail username is enough)_
  * after some consideration you'll receive an email with our decision about including you in the project _(if you don't get the response in three days, send your request again)_
  * if everything goes well, you'll become a member of the project and will be able to do more than a non-member can _(you'll be able to change the project's code, documentation and tasks)_
  * also you will be added to [the project's member list](http://code.google.com/p/phpdays/people/list) _(don't forget to add this link to your resume)_

### General Information about the Site ###

  * [Downloads](http://code.google.com/p/phpdays/downloads/list) - Download page, where the project's working copies are available, intended for the end user
  * [Wiki](http://code.google.com/p/phpdays/w/list) - project's documentation
  * [Issues](http://code.google.com/p/phpdays/issues/list) - list of issues and tasks
  * [Source](http://code.google.com/p/phpdays/source/list) - information about the project's SVN repository and change log history

### Uploading the Project's working copy ###

  * download and install an SVN client to work with the project's files
  * download a project's working copy _(for more information see [Checkout](http://code.google.com/p/phpdays/source/checkout))_
  * if you haven't worked with Subversion before, take your time to learn it

### Guidelines for Applying Changes _(SVN commit)_ ###

For comments follow the format listed below

  * `Fix #1234: The name of the bug` - for a fix of the error number `1234`. If the bug is not in the [Issues](http://code.google.com/p/phpdays/issues/list), then you should add the issue first and only then make a `SVN commit`
  * write each bug/issue in a separate line. Put a dot at the end of line.

### Test Yourself ###

Set up [PHPUnit](http://blogs.sun.com/netbeansphp/entry/recent_improvements_in_phpunit_support). This will allow you to create unit tests to ensure that a new fix in code will not break something else. Only after this should you run `SVN commit`.

### Write Better Code ###

Read about the [coding style](EnCodingStyle.md) adopted in our project. Following uniform style allows all developers to communicate in a single, comprehensible language.