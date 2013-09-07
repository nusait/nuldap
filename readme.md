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

## Search By Netid:
```php
$ldap->searchNetid($netid);
```
This returns the raw metadata. it is up to the developer to parse the data.
