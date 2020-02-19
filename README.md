# PHP-wkhtmltox

[![GitHub license](https://img.shields.io/github/license/fawno/PHP-wkhtmltox)](https://github.com/fawno/PHP-wkhtmltox/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/fawno/PHP-wkhtmltox)](https://github.com/fawno/PHP-wkhtmltox/releases)
[![Packagist](https://img.shields.io/packagist/v/fawno/php-wkhtmltox)](https://packagist.org/packages/fawno/php-wkhtmltox)
[![PHP](https://img.shields.io/packagist/php-v/fawno/php-wkhtmltox)](https://php.net)

 PHP/FFI class for wkhtmltox C library
 Render HTML into PDF and various image formats using the Qt WebKit rendering engine.

## Requirements
 - wkhtmltox C library: https://wkhtmltopdf.org/
 - FFI PHP extension (bunded in PHP >= 7.4.0).

## Installation

You can install this plugin into your application using
[composer](https://getcomposer.org):

```
  composer require fawno/php-wkhtmltox
```

## Usage

```php
  require 'vendor/autoload.php';

  use Fawno\PHPwkhtmltox\wkhtmltoimage;

  // Create wkhtmltoimage object (on Windows)
  //$wk = new wkhtmltoimage(__DIR__ . '/bin/wkhtmltox.dll');

  // Create wkhtmltoimage object (on Linux)
  $wk = new wkhtmltoimage('/usr/local/lib/wkhtmltox.so');

  // Set screen Width
  $wk->set_global_setting('screenWidth', '1200');

  // Set url to render
  $wk->set_global_setting('in', 'https://wkhtmltopdf.org/');

  // Set output format to PNG
  $wk->set_global_setting('fmt', 'png');

  // Render url and return image as string
  $data = $wk->convert();

  // Set output filename
  $wk->set_global_setting('out', 'wkhtmltopdf.png');

  // Render url
  $wk->convert();
```
