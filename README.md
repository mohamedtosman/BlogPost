# Blog Post Application - Mohamed Osman

## Introduction
This is a simple application that represents a blog post where a user can view 
all posts on a single page. User can also edit an existing post and delete if 
they wish.

## Technologies/Pre-requisites
MySQL 8.0.9

Apache 2.4

Composer

PHP 7.3

Doctrine

ZendFramework3

HTML

## Installation
Run composer to install ZendFramework and Doctrine dependencies from the root path of the
folder.

`php composer.php install`

Enable composer development mode

`php composer.php development-mode`

## Database
Locate "configuration/autoload/local.php" and enter database 
credentials (username, password, database name).

Login to MySQL

`mysql -u root -p`

Create the database and a user with privileges

`create database blog
CREATE USER 'blog'@'localhost' IDENTIFIED BY '<password>';
GRANT ALL PRIVILEGES ON blog.* TO 'blog'@'localhost' WITH GRANT OPTION;`

Create a table and enter 3 initial posts

```use blog
create table `post` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `title` text NOT NULL,
    `content` text NOT NULL,
    `date_created` datetime NOT NULL
    );
    
INSERT INTO post(`title`, `content`, `date_created`) VALUES('This is a title',
    -> "This is an example for my first post's content",
    -> '2020-08-09 14:19');

INSERT INTO post(`title`, `content`, `date_created`) VALUES('Second title',
        -> "More content",
        -> '2020-08-09 18:19');

INSERT INTO post(`title`, `content`, `date_created`) VALUES('Third title',
            -> "Even more content",
            -> '2020-08-09 22:19');
```

## Apache
Create a virtual host for Apache to execute the app locally. Fill in username with your path.

```
<VirtualHost *:80>

     DocumentRoot "/Users/<username>/Sites/blog/public"
     
     <Directory "/Users/<username>/Sites/blog/public">
     
         DirectoryIndex index.php
         
         AllowOverride All
         
         Options Indexes MultiViews FollowSymLinks
         
         Require all granted
         
     </Directory>
     
 </VirtualHost>
 ```
 
Restart Apache server and you should be able to view the app at "http://localhost/".

## API
`/posts/add` - This will view a page where user can create a new post.
It requires them to enter a title and content then press "Create" button.

`/posts/edit/<id>` - This will view a page where a user can edit an existing
post by editing current title and content.

`/posts/edit/<id>` - This will delete an existing post and redirect to main page.

## Unit Testing
I didn't really have time to dive deep into testing as all these technologies are much
new to me (ZendFramework, Doctrine) but I included two bases tests that you can run using:

`./vendor/bin/phpunit --testsuite blog`


BELOW THE ASTERISKS, YOU CAN FIND MORE HELPFUL INFORMATION WITH THE README
THAT CAME PREPARED WITH ZENDFRAMEWORK UPON INSTALLATION.


****************
****************
****************
****************
****************
****************
****************
****************
****************
****************
****************
****************




# ZendSkeletonApplication

> ## Repository abandoned 2019-12-31
>
> This repository has moved to laminas/laminas-skeleton-installer.

## Introduction

This is a skeleton application using the Zend Framework MVC layer and module
systems. This application is meant to be used as a starting place for those
looking to get their feet wet with Zend Framework.

## Installation using Composer

The easiest way to create a new Zend Framework project is to use
[Composer](https://getcomposer.org/).  If you don't have it already installed,
then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

To create your new Zend Framework project:

```bash
$ composer create-project -sdev zendframework/skeleton-application path/to/install
```

Once installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public
# OR use the composer alias:
$ composer run --timeout 0 serve
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://localhost:8080/
- which will bring up Zend Framework welcome page.

**Note:** The built-in CLI server is *for development only*.

## Development mode

The skeleton ships with [zf-development-mode](https://github.com/zfcampus/zf-development-mode)
by default, and provides three aliases for consuming the script it ships with:

```bash
$ composer development-enable  # enable development mode
$ composer development-disable # disable development mode
$ composer development-status  # whether or not development mode is enabled
```

You may provide development-only modules and bootstrap-level configuration in
`config/development.config.php.dist`, and development-only application
configuration in `config/autoload/development.local.php.dist`. Enabling
development mode will copy these files to versions removing the `.dist` suffix,
while disabling development mode will remove those copies.

Development mode is automatically enabled as part of the skeleton installation process. 
After making changes to one of the above-mentioned `.dist` configuration files you will
either need to disable then enable development mode for the changes to take effect,
or manually make matching updates to the `.dist`-less copies of those files.

## Running Unit Tests

To run the supplied skeleton unit tests, you need to do one of the following:

- During initial project creation, select to install the MVC testing support.
- After initial project creation, install [zend-test](https://zendframework.github.io/zend-test/):

  ```bash
  $ composer require --dev zendframework/zend-test
  ```

Once testing support is present, you can run the tests using:

```bash
$ ./vendor/bin/phpunit
```

If you need to make local modifications for the PHPUnit test setup, copy
`phpunit.xml.dist` to `phpunit.xml` and edit the new file; the latter has
precedence over the former when running tests, and is ignored by version
control. (If you want to make the modifications permanent, edit the
`phpunit.xml.dist` file.)

## Using Vagrant

This skeleton includes a `Vagrantfile` based on ubuntu 16.04 (bento box)
with configured Apache2 and PHP 7.0. Start it up using:

```bash
$ vagrant up
```

Once built, you can also run composer within the box. For example, the following
will install dependencies:

```bash
$ vagrant ssh -c 'composer install'
```

While this will update them:

```bash
$ vagrant ssh -c 'composer update'
```

While running, Vagrant maps your host port 8080 to port 80 on the virtual
machine; you can visit the site at http://localhost:8080/

> ### Vagrant and VirtualBox
>
> The vagrant image is based on ubuntu/xenial64. If you are using VirtualBox as
> a provider, you will need:
>
> - Vagrant 1.8.5 or later
> - VirtualBox 5.0.26 or later

For vagrant documentation, please refer to [vagrantup.com](https://www.vagrantup.com/)

## Using docker-compose

This skeleton provides a `docker-compose.yml` for use with
[docker-compose](https://docs.docker.com/compose/); it
uses the `Dockerfile` provided as its base. Build and start the image using:

```bash
$ docker-compose up -d --build
```

At this point, you can visit http://localhost:8080 to see the site running.

You can also run composer from the image. The container environment is named
"zf", so you will pass that value to `docker-compose run`:

```bash
$ docker-compose run zf composer install
```

## Web server setup

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

```apache
<VirtualHost *:80>
    ServerName zfapp.localhost
    DocumentRoot /path/to/zfapp/public
    <Directory /path/to/zfapp/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_authz_core.c>
        Require all granted
        </IfModule>
    </Directory>
</VirtualHost>
```

### Nginx setup

To setup nginx, open your `/path/to/nginx/nginx.conf` and add an
[include directive](http://nginx.org/en/docs/ngx_core_module.html#include) below
into `http` block if it does not already exist:

```nginx
http {
    # ...
    include sites-enabled/*.conf;
}
```


Create a virtual host configuration file for your project under `/path/to/nginx/sites-enabled/zfapp.localhost.conf`
it should look something like below:

```nginx
server {
    listen       80;
    server_name  zfapp.localhost;
    root         /path/to/zfapp/public;

    location / {
        index index.php;
        try_files $uri $uri/ @php;
    }

    location @php {
        # Pass the PHP requests to FastCGI server (php-fpm) on 127.0.0.1:9000
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_param  SCRIPT_FILENAME /path/to/zfapp/public/index.php;
        include fastcgi_params;
    }
}
```

Restart the nginx, now you should be ready to go!

## QA Tools

The skeleton does not come with any QA tooling by default, but does ship with
configuration for each of:

- [phpcs](https://github.com/squizlabs/php_codesniffer)
- [phpunit](https://phpunit.de)

Additionally, it comes with some basic tests for the shipped
`Application\Controller\IndexController`.

If you want to add these QA tools, execute the following:

```bash
$ composer require --dev phpunit/phpunit squizlabs/php_codesniffer zendframework/zend-test
```

We provide aliases for each of these tools in the Composer configuration:

```bash
# Run CS checks:
$ composer cs-check
# Fix CS errors:
$ composer cs-fix
# Run PHPUnit tests:
$ composer test
```
