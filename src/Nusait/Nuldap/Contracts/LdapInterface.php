<?php namespace Nusait\Nuldap\Contracts;


interface LdapInterface
{
    public function validate($netid, $password);
    public function search($field, $query);
    public function parseUser($ldapUser, TransformerInterface $transformer = null);
}