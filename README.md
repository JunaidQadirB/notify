# JeyKeu Notify for PHP

Bootstrap3 notifications for PHP

##Demo

Here's a [Demo](http://notify.junaidqadir.com/) using Native PHP.

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
$notification  new JeyKeu\NotifyNotification();
$notify = new JeyKeu\Notify\Notify();

//Prepare notification
$notification
    ->setHandle($handle)
    ->setViewData($viewData)
    ->setIsDissmissable($bool)
    ->setType($type);

//Add a notification
$notify->add($notification);

//Remove a notification
$notify->remove($handle);

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
