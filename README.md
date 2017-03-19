# MyPHP
The easiest way to learn PHP! Good for prototyping your app.
Want to build your own app soon, but you don't know PHP? And also getting to know frameworks which is frustrating & overwhelming to learn?
Why don't you try this one? MyPHP!!

This is also my prototype template to easily test my projects before moving onto the real setup

## Features
* Quite & less modular but still easier for newbies, baby!
* Using the modern and official PHP password hashing functions!
* OOP Structured Codebase
* Can do CRUD, Login/Register, Pagination, & REST
* Quite Documented and plenty of comments inside!
* Can do Hello World, of course!
* Learn API calls all of them in Core class
* Using Medoo for more easier database handling (called DB in Core)
* Using Whoops for more sassy error reporting (using ErrorHandler and PrettyErrorHandler in Core)

## Additonal Features
* You can build a function for email using Composer or load your PHP-compatible Mail library in libraries/ dir
* Uses Composer to load external dependencies by loading Composer dependencies in Core (PHPMailer, Captcha-Generator, etc.) for sure
* NodeJS ready!! (Managing 3rd party web dependencies. Recommended: Bower)
* You can use Bower for load public dependencies such as Bootstrap, JQuery or maybe Foundation too! (You can ignore this if you prefer CDNs)
* Currently using [SB-Admin 2](http://startbootstrap.com/template-overviews/sb-admin-2/) front-end template. You can replace them easily with bower! (Don't forget to check Headers & Footers!)
* .example files might help you in your development!

### This is not recommended for very large projects
### You may use this on your small projects or test your skills, etc.

## Requirements
* Apache-based web servers or any with .htaccess & RewriteEngine support
* PHP 5.4 and up until PHP 7!
* Supports MYSQL & SQLITE as well, if you are going to MySQL, it must be installed (version 5.6 and up) by the way.
* [Composer](https://getcomposer.org) (PHP Dependency Manager, required and it's available even for Windows with XAMPP, or WAMPS!)

## Installation
### One-way using Composer [REQUIRED]
`$ composer install`
NOTE: You can add more dependency by using `$ composer require author/dependency_name`
### Database Installation
Create your own. You may use my sample code available [here](https://gist.github.com/jccultima123/5e10a6d9e549778eff40adb5a3556e4a)

## Known Issues
* Error Handling (hugely affects for API building)

## Coming Soon!
* Email Service
* Forgot Password System
* Error Handling with .htaccess
* Using JSON formats for new API class (for OAuth, Android, etc.)
* One-way installation script (compatible with Heroku)

## Contribute Us
Contribute here, fork and submit your pull requests to us!

## Credits
* Some codes are done and credited to [panique](https://github.com/panique)-kun! Follow him also and.. Arigatou!!

## Notice
* Don't confuse with PHP frameworks like CodeIgniter & CakePHP. It's still different though.
* This script comes with a handy .htaccess in the views folder that denies direct access to the files within the folder (so that people cannot render the views directly). However, these .htaccess files only work if you have set
`AllowOverride` to `All` in your apache vhost configs. There are lots of tutorials on the web on how to do this.

## License
Licensed under [MIT](http://www.opensource.org/licenses/mit-license.php). You can use this script for free for any
private or commercial projects.
