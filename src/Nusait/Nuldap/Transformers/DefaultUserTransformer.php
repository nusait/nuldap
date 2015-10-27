<?php namespace Nusait\Nuldap\Transformers;

class DefaultUserTransformer extends AbstractTransformer
{
    public function transform($ldapUser)
    {
        return [
            'netid'       => $this->getSetValueOrNull($ldapUser, 'uid'),
            'phone'       => $this->getSetValueOrNull($ldapUser, 'telephonenumber'),
            'email'       => $this->getSetValueOrNull($ldapUser, 'mail'),
            'title'       => $this->getSetValueOrNull($ldapUser, 'title'),
            'first_name'  => $this->getSetValueOrNull($ldapUser, 'givenname'),
            'last_name'   => $this->getSetValueOrNull($ldapUser, 'sn'),
            'displayname' => $this->getSetValueOrNull($ldapUser, 'displayname'),
            'emplid'      => (int) $this->getSetValueOrNull($ldapUser, 'employeenumber'),
            'studentid'   => (int) $this->getSetValueOrNull($ldapUser, 'nustudentnumber')
        ];
    }
}