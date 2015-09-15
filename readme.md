# NuLdap
This is a LDAP package meant for Northwestern University. (But can be extended for other entities)

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
$ldap->parseUser($raw_ldap);
```
You can parse the raw metadata of a user to create an associative array of the user. You can pass your own transformer into the array. The transformer should be a list of key:value pairs -- the key should be the key you want in the parsedUser result and the value should be the associated key in the ldap metadata.
