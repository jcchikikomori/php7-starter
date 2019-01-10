# jcsimple-php-app
### A naked PHP micro framework
<i>UPDATE: previously called "MyPHP"</i><br />

### Reminder. This is not recommended for very large & complex projects
Building PHP made more simple over complicated frameworks on the market
This is also my prototype template to easily test my projects before moving onto the real setup

## Features
* Quite & less modular but still easy to learn for newbies, baby!
* OOP Structured & can do CRUD, Login/Register, Pagination (SOON), & REST
* Quite Documented and plenty of comments inside
* Render whether a JSON object or a web page
* Using Medoo for more easier database handling (called DB in Core)

## Additonal Features
* Multi-user login setup like the Google Auth System (disabled by default)
* You can build a function for email using Composer or load your own library in libraries/ dir
* Uses Composer to load external dependencies by loading Composer dependencies (PHPMailer, PHPUnit, etc.) for sure
* NodeJS ready. You can use Bower for load public dependencies such as Bootstrap, JQuery or maybe Foundation too! (You can ignore this if you prefer CDNs)
* Currently using [SB-Admin 2](http://startbootstrap.com/template-overviews/sb-admin-2/) front-end template. You can replace them easily with bower! (Don't forget to check Headers & Footers!)
* .example files might help you in your development!

## Requirements
* Knowledge in PHP 5 or higher
* Familiar in Object-Oriented Programming. This project is frequently used OOP
* Apache-based web servers or any with .htaccess & RewriteEngine support
* PHP 5.6 to PHP 7+
* Supports MYSQL & SQLITE as well, if you are going to MySQL, go install and set it up.
* [Composer](https://getcomposer.org) (PHP Dependency Manager, required and it's available even for Windows with XAMPP, or WAMPS!)

## Installation
### One-way using Composer
`$ composer install`

NOTE: You can add more dependency by using this command

`$ composer require author/dependency_name`

### Database Installation
The database query for this are provided [here](https://gist.github.com/jccultima123/5e10a6d9e549778eff40adb5a3556e4a)

## Known Issues
* Error Handling for REST/JSON (it's up to you to catch it since it's already parsed on JSON format)

## Work to do..
- [x] SQLite Support
- [ ] Email Service
- [x] Forgot Password System
- [x] Error Handling with .htaccess
- [x] Using REST/JSON formats for new API class (for OAuth, Android, etc.)
- [ ] App Deployment like Heroku
- [x] Multi-user
- [ ] Pagination
- [ ] JSON/REST response handling

## Notice
* Again, this is not recommended for large/complex projects
* This project is provided with a handy .htaccess in the views folder that denies direct access to the files within the folder (so that people cannot render the views directly). However, these .htaccess files only work if you have set
`AllowOverride` to `All` in your Apache Virtual Host configs. There are lots of tutorials on the web on how to do this.

## Credits
* This project is from [panique's](https://github.com/panique) code base, so big thanks to him!

## License
Licensed under [MIT](http://www.opensource.org/licenses/mit-license.php). You can use this script for free for any
private or commercial projects.
