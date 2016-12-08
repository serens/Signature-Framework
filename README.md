Signature framework
=======================

What is the Signature framework? Signature is a simple and fast MVC framework, written in PHP 7.0. It is designed to make web development easier, faster and more fun.

Requirements
------------

 * An Apache web server with the mod_rewrite module enabled and configured
 * PHP 7.0.x or newer
 * A database like MySQL is highly recommended

Installation
------------

Installing and setting up Signature framework is as simple as possible.

Step 1: Clone
---------------------------

Clone from `git://github.com/serens/Signature-Framework.git` into your document root of your new application, for instance `/websites/signature/`. Your directory structure should like this now:

    /websites/signature/
        /cache
        /modules
            /Application
                /res
                /src
                    /Model
                    /Controller
                        IndexController.php
                    Config.php
                    Module.php
                /tpl
            /Signature
        .htaccess
        index.php
        README.md

Step 2: Set up a virtual host
-----------------------------

Create an Apache virtual host so that `http://signature.local` will serve `index.php` from the document root `/websites/signature/` where you have cloned the repository several minutes before.

Now edit your hosts file so that the host `signature.local` points to `127.0.0.1`.

Step 3: Restart Apache
----------------------

Restart your Apache and open "http://signature.local" in your favorite browser. If your virtual host is set up correctly, you should now see the following screen.

![Congratulation Screen](http://signature-framework.com/images/contratulation.png)

Step 4: Nothing more. You are now ready to go.
----------------------------------------------

Your first Signature framework Application is set up and running. Your next step may be to call http://signature.local/about/config/ to see your current configuration.

![Configuration Screen](http://signature-framework.com/images/aboutconfig.png)

This is one of the configured default routes available after setting up Signature. It is supposed to provide a fast way to inspect your vital settings like routes, loaded modules and persistence status.
