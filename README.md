# MyPHP Plus ("Plus", 'coz not only PHP!)

## Introduction
The easiest and better way to learn PHP!
Hard building up foundation for your web development? Want to build up with Laravel soon but you don't know PHP?
Why don't you try this one! It could be better for you! MyPHP!!

## Features
* The difference is, this is structured (unlike building your own from scratch) to lessen maintenance, and errors
* Quite but less modular but still easier for newbies, baby!
* OOP Structured Codebase
* Using the modern and official PHP password hashing functions!
* Can do login / register essentials
* Can do CRUD Functions
* Can do Paginations
<!-- * ~~Can do AJAX or build this as API!~~ (Issued on #2) -->
* Can do AJAX or build this as API!
* Can load external libraries (I'd prefer using Composer though unless it's critically important)
* Documented and plenty of comments inside!
* Bug-free? (depending on your projects, LOL)
* Can do Hello World, of course!
* Almost all basic functions already here!

## Additonal Features (Plus!)
* You can build a function for email using Composer or load your PHP-compatible Mail library in libraries/ dir
* Uses Composer to load external dependencies by loading Composer dependencies in Core (PHPMailer, Captcha-Generator, etc.) for sure
* NodeJS ready!! (Managing 3rd party web dependencies. Recommended: Bower)
* You can use Bower for load public dependencies such as Bootstrap, JQuery or maybe Foundation too! (You can ignore this if you prefer CDNs)
* Currently using [SB-Admin 2](http://startbootstrap.com/template-overviews/sb-admin-2/) front-end template. You can replace them easily with bower! (Don't forget to check Headers & Footers!)
* .example files might help you handle 3rd-party assets (config.php is included in Installation)

### This is not recommended for very large projects, you may use this on your small projects like a portfolio website, etc.

## Requirements
* Apache-based web servers or any with .htaccess & RewriteEngine support
* PHP 5.3.7+ (PHP 7 Support still ongoing for development. Currently checking deprecated syntaxes)
* MySQL 5 database (please use a modern version of MySQL (5.5, 5.6, 5.7) as very old versions have a exotic bug that
[makes injections possible](http://stackoverflow.com/q/134099/1114320).
* Activated mysqli (last letter is an "i") extension (activated by default on most server setups)
* [Composer](https://getcomposer.org) (PHP Dependency Manager, required for installing 3rd party class)
* [NodeJS 1.10.*](https://nodejs.org) or at least stable and [Bower](http://bower.io) package manager (optional / if you don't want to use UI)

## Installation
### One-way installation script coming soon!

Do these commands (Currently Linux command but you can do this on Windows)

`$ cp config.php.example config.php`

### Bower Installation (bower.json sample provided.)
Beware, bower dir will not be included for push/pull!

`$ bower install`

### Composer Installation (composer.json provided)
`$ composer install`
You can add more by using `$ composer require author/dependency_name`

### Database Installation
Create your own. You may use my sample code available [here](https://gist.github.com/jccultima123/5e10a6d9e549778eff40adb5a3556e4a)

## Known Issues
* Prone to Injections (for mysqli)
* Error Handling (hugely affects for API building)

## Rolling up new features
- [ ] Email Service
- [ ] Forgot Password System
- [ ] Error Handling with .htaccess
- [ ] API Samples including JSON actions
<!-- - [ ] Leave Composer as an option -->
- [ ] Provision script for application deployment like Heroku, etc.
- [ ] One-way installation script

## Contribute Us
Contribute here, fork and submit your pull requests to us!

## Credits
* Some codes are done from [panique](https://github.com/panique)-sensei! Thanks to him

## Notice
* Don't confuse with CodeIgniter. It's still different though.
* This script comes with a handy .htaccess in the views folder that denies direct access to the files within the folder (so that people cannot render the views directly). However, these .htaccess files only work if you have set
`AllowOverride` to `All` in your apache vhost configs. There are lots of tutorials on the web on how to do this.

## Useful links (thanks to panique)
* [A little guideline on how to use the PHP 5.5 password hashing functions and its "library plugin" based PHP 5.3 & 5.4 implementation](http://www.dev-metal.com/use-php-5-5-password-hashing-functions/)
* [How to setup latest version of PHP 5.5 on Ubuntu 12.04 LTS](http://www.dev-metal.com/how-to-setup-latest-version-of-php-5-5-on-ubuntu-12-04-lts/). Same for Debian 7.0 / 7.1:
* [How to setup latest version of PHP 5.5 on Debian Wheezy 7.0/7.1 (and how to fix the GPG key error)](http://www.dev-metal.com/setup-latest-version-php-5-5-debian-wheezy-7-07-1-fix-gpg-key-error/)
* [Notes on password & hashing salting in upcoming PHP versions (PHP 5.5.x & 5.6 etc.)](https://github.com/panique/php-login/wiki/Notes-on-password-&-hashing-salting-in-upcoming-PHP-versions-%28PHP-5.5.x-&-5.6-etc.%29)
* [Some basic "benchmarks" of all PHP hash/salt algorithms](https://github.com/panique/php-login/wiki/Which-hashing-&-salting-algorithm-should-be-used-%3F)

## License
Licensed under [MIT](http://www.opensource.org/licenses/mit-license.php). You can use this script for free for any
private or commercial projects.
