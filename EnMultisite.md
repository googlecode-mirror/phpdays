#summary Multisites.
#labels Lang-En
#sidebar En
<a href='Hidden comment: revision: 1'></a>

If a complex, feature-rich section has to be added to a site, it is best to make it as a separate project. Then the project can be integrated into another site. It gives a semblance of Lego bricks, from which you can build a web site on the basis of other projects.

### Creating a site ###

Suppose that you need to create a complex _forum section_. Create a separate [project](EnInstall.md), and implement only the forum section. The same way deal with the other complex sections of the site _(including a blog, catalog, etc)_.

The project will be located in the `/var/www/forum` directory.

Now prepare your forum for inclusion in another section of the site. Create a new configuration file `/var/www/forum/app/config/myblog_development.yaml`. Edit it to work with a database of your application. Set the `url/base: myblog/forum` option.

Implement all the simple parts of the site the same way as before - by creating a separate [controller](EnController.md).

### Including the Project into the Current Section of the Site ###

Files and the `static` directory are located in the `/var/www/myblog/public` directory.

We have to create a `/var/www/myblog/public/forum` directory for our new forum section. Copy the contents of `/var/www/forum/public` into the new directory.

Edit the file `/var/www/myblog/public/forum/index.php`:
  * set the path to the phpDays library
  * set the path to the forum application
  * change the configuration from `development` to `myblog_development`

### Explanations ###

Now when you go to http://localhost/myblog/forum, you will be redirected to `/var/www/myblog/public/forum` and the appropriate application will be launched. As a result we'll get "a site within a site."

If you have to use a similar forum section in another project, this will save you time. All you'll have to do is to include one project into another.