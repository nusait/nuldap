# NuLdap
=============
This is a LDAP package meant for Northwestern University. (But can be extended for other entities)

## New Instance:
```php
$ldap = new Nusait\Nuldap\NuLdap($rdn, $pass, $host, $port);
```
(all parameters are optional);
if you do not put $rdn or $pass, you can still validate, but cannot search by netid.

## Validate:
```php
$ldap->validate($netid, $password);
```
returns a boolean

## Search By Netid:
```
$ldap->searchNetid($netid);
```
This returns the raw metadata. it is up to the developer to parse the data.
