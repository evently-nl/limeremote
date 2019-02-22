# LimeRemote

[![Latest Version on Packagist](https://img.shields.io/packagist/v/evently/limeremote.svg?style=flat-square)](https://packagist.org/packages/evently/limeremote)
[![Build Status](https://img.shields.io/travis/evently/limeremote/master.svg?style=flat-square)](https://travis-ci.org/evently/limeremote)
[![Quality Score](https://img.shields.io/scrutinizer/g/evently/limeremote.svg?style=flat-square)](https://scrutinizer-ci.com/g/evently/limeremote)
[![Total Downloads](https://img.shields.io/packagist/dt/evently/limeremote.svg?style=flat-square)](https://packagist.org/packages/evently/limeremote)

A package to use the Limesurvey Remote Control with PHP, and Laravel in particular. Currently it supports all default remote control actions, and any actions you have added using the fantastic Extended Remote from Denis Chenu (https://gitlab.com/SondagesPro/RemoteControl/extendRemoteControl) using the genericRemoteQuery.  

## Installation

You can install the package via composer:

```bash
composer require evently/limeremote
```

## Usage

### Standard use
``` php
// First create a new remote with your user, password, remote control url and optionally a survey id.
// The plugin creates a new remote and automatically gets a session key to communicate with Limesurvey 
$remote = new LimeRemote('admin', 'password', 'https://www.limesurvey.com/admin/remotecontrol',123456);

// Use any of the functions, optionally passing variables to the remote
$surveys = $remote->listSurveys();

/*
Results in:

array:26 [
  0 => array:5 [
    "sid" => "123456"
    "surveyls_title" => "First Survey"
    "startdate" => null
    "expires" => null
    "active" => "Y"
  ]
  1 => array:5 [
    "sid" => "123457"
    "surveyls_title" => "Second Survey"
    "startdate" => null
    "expires" => null
    "active" => "N"
  ]

*/



// To use the genericRemoteQuery pass the action you want to trigger with the necessary variables
// For instance, the list_participants action accepts start and limit, and optionally an unused boolean, an array of attributes to get and and array of conditions. So:
$participant = $remote->genericRemoteQuery('list_participants', [123456,0,50,true])
// will get the 50 first unused tokens
/*
array:50 [▼
  0 => array:3 [▼
    "tid" => "1"
    "token" => "abcdefghijklmn"
    "participant_info" => array:3 [▼
      "firstname" => "Jane"
      "lastname" => "Doe"
      "email" => "jane.doe@evently.nl"
    ]
  ]
  1 => array:3 [▼
    "tid" => "2"
    "token" => "opqrstuvwxyzab"
    "participant_info" => array:3 [▶]
  ]


*/
```
### Helpers
The package will also come with helpers that make it easier to use several of the remote control options. For now there is only one, to easily get the response timeline for the last X days:

``` php

$timeline = $remote->getLastNumDaysTimeline(8)

/*
will result in 
array:6 [▼
  "2019-01-01" => 23
  "2019-01-02" => 15
  "2019-01-03" => 41
  "2019-01-04" => 28
  "2019-01-05" => 12
  "2019-01-06" => 5
]

*/

```

### Testing

Tests are not yet written but pull requests with test are more than welcome!

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email Stefan@evently.nl instead of using the issue tracker.

## Credits

- [Stefan Verweij](https://github.com/evently)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


[link-packagist]: https://packagist.org/packages/evently/limeremote
[link-downloads]: https://packagist.org/packages/evently/limeremote
[link-travis]: https://travis-ci.org/evently/limeremote
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/evently
[link-contributors]: ../../contributors]
