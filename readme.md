# NuLdap
This is a LDAP package meant for Northwestern University. (But can be extended for other entities)

## Installation via Composer
```
composer require nusait/nuldap
```
or manually
```json
require: {
  "nusait/sso-middleware": "~1.0"
}
```
Then update composer
```
composer update
```

## Laravel
This package can be used in Laravel. Include the service provider:

Add the service provider to `app/config/app.php`

```php
'providers' => [
// ...
/*
 * Application Service Providers...
 */
    Nusait\Nuldap\NuLdap::class,
// ...
]
```

To publish the config file, run `php artisan vendor:publish` in your root folder. This will publish a config file to `config/ldap.php`.

## Configuration
The configuration file published `ldap.php` contains some configuration settings:

```php
return [
    "rdn" => isset($_ENV['ldap_rdn']) ? $_ENV['ldap_rdn'] : null,
    "password" => $_ENV['ldap_pass'] ? $_ENV['ldap_pass'] : null,
    "host" => isset($_ENV['ldap_host']) ? $_ENV['ldap_host'] : null,
    "port" => isset($_ENV['ldap_port']) ? (int)$_ENV['ldap_port'] : null,
];
```
* rdn - the relative distinguished name
* password - the password for the rdn
* host - the ldap host url
* port - the ldap port

The configuration will check your `.env` file to load the values, if nothing is found in your `.env` file, then it will populate `null`

## New Instance:
```php
$ldap = new Nusait\Nuldap\NuLdap($rdn, $password, $host, $port);
```
(all parameters are optional);
if you do not put ```$rdn``` or ```$password```, you can still validate, but cannot ```searchNetid```. After instantiating, you can still set the rdn and password with ```setRdn``` and ```setPassword``` respectively.

## Validate:
```php
$ldap->validate($netid, $password);
```
returns a boolean

## Searching:

You can search by netid, email, emplid, or studentid.
```php
$ldap->searchNetid($netid);
$ldap->searchEmail($email);
$ldap->searchEmplid($emplid);
$ldap->searchStudentid($studentid);
```
This returns the raw metadata.

## Parsing User
```php
$ldap->parseUser($raw_ldap [, $transformer ]);
```
You can parse the raw metadata of a user to create an associative array of the user. You can pass your own transformer into the array. The transformer should be an array of key:value pairs -- the key should be the key you want in the parsedUser result array and the value should be the associated key in the ldap metadata.

The default transforms maps the following keys and value:

```php
$transformer = [
    'phone'       => 'telephonenumber',
    'email'       => 'mail',
    'title'       => 'title',
    'first_name'  => 'givenname',
    'last_name'   => 'sn',
    'netid'       => 'uid',
    'displayname' => 'displayname',
    'emplid'      => 'employeenumber',
    'studentid'   => 'nustudentnumber'
];
```