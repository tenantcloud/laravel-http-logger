# laravel-http-logger

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

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
php artisan vendor:publish --provider="TenantCloud\LaravelHttpLogger\LaravelHttpLoggerServiceProvider" --tag="config"
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
[ico-downloads]: https://img.shields.io/packagist/dt/tenantcloud/laravel-http-logger.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/tenantcloud/laravel-http-logger
[link-downloads]: https://packagist.org/packages/tenantcloud/laravel-http-logger
[link-author]: https://github.com/ivankolodii
[link-contributors]: ../../contributors
