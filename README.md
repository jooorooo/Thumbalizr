Thumbalizr
==========

Thumbalizr Class for Laravel 5

Uses API from thumbalizr.com

## Requirements

* Laravel 5.X
* php 5.4+

## Installation

##### Step 1: Install package using [Composer](https://getcomposer.org)

Add simexis/thumbalizr to "require" section of your composer.json

```javascript
"require": {
    "simexis/thumbalizr": ">=1.0"
},
```

Add repository to "repositories" section of your composer.json

```javascript
"repositories": [ {
	"type": "vcs",
	"url": "https://github.com/jooorooo/Thumbalizr.git"
}],
```

Then install dependencies using following command:
```bash    
php composer.phar install
```

##### Step 2: Laravel Setup
Add following line to 'providers' section of app/config/app.php file:
```php
'Simexis\Thumbalizr\ThumbalizrServiceProvider',
```

## Usage

Default configuration is:

```php
$cfg = [
	'api_key'			=>	"", //put your api key here
	'service_url'		=>	"http://api.thumbalizr.com/", // don't change, if you didn't have a special service contract
	'use_local_cache'	=>	TRUE, // TRUE or FALSE for local image cache
	'local_cache_dir'	=>	public_path()."/thumbs", //relative cache directory must exists in install directory and rwx permissions to all (777)
	'local_cache_expire'=>	24*14, // local chache expiration time in hours

	'defaults' 			=> [
        'width'				=>		"400", // image width
		'delay'				=>		"10", // caputre delay useful for flash content 5 - 10 is a good value
		'encoding'			=>		"png", // jpg or png
		'quality'			=>		"90", //image quality 10-90
		'bwidth'			=>		"1280", // browser width
		'mode'				=>		"screen", // screen or page
		'bheight'			=>		"1024" // browser height only for mode=screen
   	]
];
```

#### Basic example

```php
$cfg = [
	'api_key'			=>	"..............", 

	'defaults' 			=> [
        'width'				=>		"250", // image width
   	]
];
echo \Thumbalizr::getThumbSrc('http://google.com',$cfg);
```