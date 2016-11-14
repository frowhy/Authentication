# Authentication

## Installation

The preferred method of installation is via [Packagist](https://packagist.org/) and [Composer](https://getcomposer.org/). Run the following command to install the package and add it as a requirement to your project's `composer.json`:

```bash
composer require frowhy/authentication
```

## Examples
```php
use Frowhy\Authentication\Authentication;

require_once __DIR__ . '/vendor/autoload.php';
header('Content-type: application/json');

$str = 'aaa';
$salt = 'bbb';
$make = Authentication::make($str, $salt);
$state = Authentication::verify($make);
$sign = Authentication::get($make, $salt);

echo json_encode(['make' => $make, 'state' => $state, 'sign' => $sign]);
```
