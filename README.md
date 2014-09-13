Browser
=========

Browser is PHP port of the popular [jQuery browser](https://github.com/gabceb/jquery-browser-plugin) plugin. It can detect browser name, version and platform. Additionally, mobile and desktop browsers are recognized.

Installation
----

Just include the Browser.php library
```php
require_once 'Browser.php';
```

Usage
-----------
Returns true if the current useragent is some version of Microsoft's Internet Explorer and false otherwise. Supports all IE versions including IE11

```php
Browser::get()->msie;
```

Returns true if the current useragent is some version of a WebKit browser (Safari, Chrome and Opera 15+) and false otherwise.

```php
Browser::get()->webkit;
```

Returns true if the current useragent is some version of Firefox and false otherwise.
```php
Browser::get()->mozilla;
```
Reading the browser verion
    
```php
Browser::get()->version;
```

- Detect Windows, Mac, Linux, iPad, iPhone, Android, Chrome OS, and Windows Phone useragents, in addition to desktop and mobile browsers in the same manner as shown by the examples above.

```php
Browser::get()->ipad
Browser::get()->iphone
Browser::get()->{"windows phone"}
Browser::get()->android
Browser::get()->cros
Browser::get()->win
Browser::get()->mac
Browser::get()->linux
Browser::get()->desktop
Browser::get()->mobile
```
```php
	// User Agent for Firefox on Windows
	User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0
	
	Browser::get()->desktop // Returns true as a boolean
```

```php
	// User Agent for Safari on iPhone
	User-Agent: Mozilla/5.0(iPhone; CPU iPhone OS 7_0_3 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B508 Safari/9537.53
	
	Browser::get()->mobile // Returns true as a boolean
```

- Detect the browser's major version

```php
	// User Agent for Chrome
	// Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1664.3 Safari/537.36
	
	Browser::get()->versionNumber // Returns 32 as a number
```

- Analyze custom user agent (from access logs for example):

```php
	$userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1664.3 Safari/537.36';
	
	Browser::get($userAgent)->name // Returns chrome
```

## Development

- Source hosted at [GitHub](https://github.com/stz184/php-jquery-browser)
- Report issues, questions, feature requests on [GitHub Issues](https://github.com/gabceb/php-jquery-browser/issues) 
- Examples and original implementation on [GitHub](https://github.com/gabceb/jquery-browser-plugin) 
