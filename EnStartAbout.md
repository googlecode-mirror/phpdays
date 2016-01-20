<a href='Hidden comment: revision: 1'></a>

### Quick Startup Guide ###

First [install the phpDays framework](EnInstall.md) on your server. Learn about phpDays' [coding standard](EnCodingStyle.md) _(this will help you and other project members to understand the code you created even a few years later)_.

### Project Structure ###

Now there are two directories at your disposal: `app` and `public`.

The `public` directory contains one subdirectory `static` which holds images, css, javascript and other static files _(eg, documents or archives)_. Also it has the main file - `index.php` which launches the application from the `app` directory. The `.htaccess` file is auxiliary - no need to change it. The `robots.txt` file is for search engines _(you can read about it on the Internet)_.

#### App - your application's directory ####

The `app` directory contains all the files of our "dynamic" application.

The `system` directory includes working subdirectories : `cache` (cache), `doc` (project's documentation), `log` (error messages), `view` (compiled template files).

The `config` directory contains application's configuration files: `development.yaml` (for an application under development) and `production.yaml` (for a production application).

Now you can see the three most important directories with which we will work constantly: `Model`, `View`, `Controller` (abbreviated as [MVC](EnMvc.md) - read more about it).

### Creating a blog site ###

Where to start? Let's create a simple but very effective example - a blog site. We need users be able to browse articles on the site, register and write their own articles, add comments.

Let's see how quickly and elegantly it can be done in 2 hours. Is it enough time? Then proceed to the next part - [application's models](EnStartModel.md).