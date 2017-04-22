# MyPHP
### A PHP Naked Mini Framework
Currently using pure and naked PHP7 code

Good for prototyping your app and can do "Hello World", of course

This is also my prototype template to easily test my projects before moving onto the real setup

## Features
* Quite & less modular but still easy to learn for newbies, baby!
* OOP Structured & can do CRUD, Login/Register, Pagination, & REST
* Quite Documented and plenty of comments inside
* Render whether a JSON object or a web page
* Using Medoo for more easier database handling (called DB in Core)
* Using Whoops for more sassy error reporting (using ErrorHandler and PrettyErrorHandler in Core)

## Additonal Features
* Multi-user setup like the Google Auth System (Experimental)
* You can build a function for email using Composer or load your PHP-compatible Mail library in libraries/ dir
* Uses Composer to load external dependencies by loading Composer dependencies in Core (PHPMailer, Captcha-Generator, etc.) for sure
* NodeJS ready. You can use Bower for load public dependencies such as Bootstrap, JQuery or maybe Foundation too! (You can ignore this if you prefer CDNs)
* Currently using [SB-Admin 2](http://startbootstrap.com/template-overviews/sb-admin-2/) front-end template. You can replace them easily with bower! (Don't forget to check Headers & Footers!)
* .example files might help you in your development!

### Reminder. This is not recommended for very large & complex projects

## Requirements
* Basic knowledge in PHP (5 and up)
* Familiar in Object-Oriented Programming
* Apache-based web servers or any with .htaccess & RewriteEngine support
* PHP 5.4 and up until PHP 7!
* Supports MYSQL & SQLITE as well, if you are going to MySQL, it must be installed (version 5.6 and up) by the way.
* [Composer](https://getcomposer.org) (PHP Dependency Manager, required and it's available even for Windows with XAMPP, or WAMPS!)

## Installation
### One-way using Composer [REQUIRED]
`$ composer install`

NOTE: You can add more dependency by using this command

`$ composer require author/dependency_name`

### Database Installation
Create your own. You may use my sample code available [here](https://gist.github.com/jccultima123/5e10a6d9e549778eff40adb5a3556e4a)

## Known Issues
* Error Handling for JSON rendering

## Work to do..
- [x] SQLite Support
- [ ] Email Service
- [ ] Forgot Password System
- [x] Error Handling with .htaccess
- [x] Using REST/JSON formats for new API class (for OAuth, Android, etc.)
- [ ] App Deployment like Heroku
- [x] Multi-user (Currently Experimental)
- [ ] Plain UI version
- [ ] Pagination (Not available yet for REST but it will come shortly)
- [ ] Multiple URL/URI parameters
- [ ] Routing (Optional)

## Notice
* Don't confuse with PHP frameworks like CodeIgniter & CakePHP. It's still different though.
* This script comes with a handy .htaccess in the views folder that denies direct access to the files within the folder (so that people cannot render the views directly). However, these .htaccess files only work if you have set
`AllowOverride` to `All` in your apache vhost configs. There are lots of tutorials on the web on how to do this.

## Credits
* [panique](https://github.com/panique)

## License
Licensed under [MIT](http://www.opensource.org/licenses/mit-license.php). You can use this script for free for any
private or commercial projects.
