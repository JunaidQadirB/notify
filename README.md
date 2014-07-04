# JeyKeu Notify for CodeIgniter

Bootstrap3 notifications for CodeIgniter


## Install

Via Composer

``` json
{
    "require": {
        "jeykeu/notify": "~1.0"
    }
}
```


## Usage

``` php
$notify = new JeyKeu\Notify\Notify();
$notify->add($handle, $viewData, $type, $isVolatile, $isDissmissable, $excludePages);

```


## Testing

``` bash
$ phpunit
```


## Contributing

Please see [CONTRIBUTING](https://github.com/jeykeu/notify/blob/master/CONTRIBUTING.md) for details.


## Credits

- [jeykeu](https://github.com/jeykeu)


## License

The MIT License (MIT). Please see [License File](https://github.com/jeykeu/notify/blob/master/LICENSE) for more information.
