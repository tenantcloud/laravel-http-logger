# laravel-http-logger

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

**Note:** Replace ```Ivan Kolodii``` ```ivankolodii``` ```https://github.com/ivankolodii``` ```ivan@tenantcloud.com``` ```tenantcloud``` ```laravel-http-logger``` ```Logger of all http requests with useful information``` with their correct values in [README.md](README.md), [CHANGELOG.md](CHANGELOG.md), [CONTRIBUTING.md](CONTRIBUTING.md), [LICENSE.md](LICENSE.md) and [composer.json](composer.json) files, then delete this line. You can run `$ php prefill.php` in the command line to make all replacements at once. Delete the file prefill.php as well.

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require tenantcloud/laravel-http-logger
```

## Usage
Add middleware to your global kernel
``` php
TenantCloud\LaravelHttpLogger\Middleware\HttpLoggerMiddleware::class
```

Publish config
```bash
php artisan vendor:publish --provider="TenantCloud\LaravelHttpLogger\TenantCloud\LaravelHttpLogger" --tag="config"
```


You need to have `predis/predis` package
and `"guzzlehttp/guzzle": "~6.0"`, to use external api driver

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email ivan@tenantcloud.com instead of using the issue tracker.

## Credits

- [Ivan Kolodii][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/tenantcloud/laravel-http-logger.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/tenantcloud/laravel-http-logger/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/tenantcloud/laravel-http-logger.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/tenantcloud/laravel-http-logger.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tenantcloud/laravel-http-logger.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/tenantcloud/laravel-http-logger
[link-travis]: https://travis-ci.org/tenantcloud/laravel-http-logger
[link-scrutinizer]: https://scrutinizer-ci.com/g/tenantcloud/laravel-http-logger/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/tenantcloud/laravel-http-logger
[link-downloads]: https://packagist.org/packages/tenantcloud/laravel-http-logger
[link-author]: https://github.com/ivankolodii
[link-contributors]: ../../contributors
