# Facebook Test User Manager

With the Graph API and OAuth 2.0 Facebook also introduced special test user accounts which could be created on the fly via the API for your specific application. This app is meant to manage those users making it easier to keep track of which ones you created and executing specific operations on them.

## Installation

Installation is very straight forward:

1. Download [source code](https://github.com/rdohms/facebook-testuser-manager/archives/master)
2. Place source code in your local web server document root
3. [OPTIONAL] Create a local virtualhost, like fum.local (the app can handle not being in root url)
4. [OPTIONAL] Copy config.ini.php.sample to a config.ini.php file and set App ID and Secret
5. Access the User Test Manager folder
6. [OPTIONAL] If the config file was not set, you can click on "Set/Unset Session Vars" to set App ID/Secret via session

## Pre-Requisites

* PHP 5.3
* Apache with mod_rewrite
* Facebook PHP SDK Requisites:
    * [PHP Curl](http://php.net/manual/en/book.curl.php)

## Changelog

### 0.10
* GH-10: Added ability to set App ID/Secret via session, allowing fast switch between apps and hosted version

### 0.9.4
* GH-11: Fixed bug with 32 bits systems and UIDs
* GH-12: README updates

### 0.9.3
* Better error handling
* Image referencing issues

### 0.9.2
* GH-9: Fixing error with invalid responses from facebook

## About Author

**Rafael Dohms** is a PHP Evangelist in Brazil and a very active member of the PHP Community. He helped found two PHP User Groups over the years and currently shares the lead of PHPSP. Developer, gamer and lover of code he also hosts Brazil’s first PHP Podcast: PHPSPCast. 

Currently he works for MIH SWAT Team, a group of experts that provides technical knowledge to the MIH group as well as working on R&D in search of the new and exciting niches of the web. His role as a Senior PHP Developer is to code, train and aid other companies and to have fun doing so.
