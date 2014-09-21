# RawDateTime - An DateTime Class Extension [![Build Status](https://travis-ci.org/rawphp/RawDateTime.svg?branch=master)](https://travis-ci.org/rawphp/RawDateTime)

## Package Features
- User to UTC time conversion
- UTC to User time conversion
- Get span between two dates in years, months, weeks, days, hours, minutes and seconds

## Installation

### Composer
RawDateTime is available via [Composer/Packagist](https://packagist.org/packages/rawphp/raw-datetime).

Add `"rawphp/raw-datetime": "0.*@dev"` to the require block in your composer.json and then run `composer install`.

```json
{
        "require": {
            "rawphp/raw-datetime": "0.*@dev"
        }
}
```

You can also simply run the following from the command line:

```sh
composer require rawphp/raw-datetime "0.*@dev"
```

### Tarball
Alternatively, just copy the contents of the RawDateTime folder into somewhere that's in your PHP `include_path` setting. If you don't speak git or just want a tarball, click the 'zip' button at the top of the page in GitHub.

## Basic Usage

```php
<?php

use RawPHP\RawDateTime\DateTime;

// get UTC time from local
$utc = DateTime::getUtcDateTime( new \DateTime( ) );

// get local time from UTC
$local = DateTime::getUserDateTime( $utc );
```

## License
This package is licensed under the [MIT](https://github.com/rawphp/RawDateTime/blob/master/LICENSE). Read LICENSE for information on the software availability and distribution.

## Contributing

Please submit bug reports, suggestions and pull requests to the [GitHub issue tracker](https://github.com/rawphp/RawDateTime/issues).

## Changelog

#### 21-09-2014
- Initial Code Commit