<?php
return [
    "rdn" => isset($_ENV['ldap_rdn']) ? $_ENV['ldap_rdn'] : null,
    "password" => $_ENV['ldap_pass'] ? $_ENV['ldap_pass'] : null,
    "host" => isset($_ENV['ldap_host']) ? $_ENV['ldap_host'] : null,
    "port" => isset($_ENV['ldap_port']) ? (int)$_ENV['ldap_port'] : null,
];