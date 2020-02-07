<?php

namespace App;

use Nette\Security as NetteSecurity;
use Nette\Database\Context;

class Authenticator implements NetteSecurity\IAuthenticator
{
    /**
     * @var Context
     */
    public $database;

    function __construct(Context $database, NetteSecurity\Passwords $passwords)
    {
        $this->database = $database->table('users');
        $this->passwords = $passwords;
    }

    /**
     * @param array $credentials
     * @return NetteSecurity\Identity
     * @throws NetteSecurity\AuthenticationException
     */
    public function authenticate(array $credentials): NetteSecurity\IIdentity
    {
        list($username, $password) = $credentials;
        $row = $this->database->where(['username' => $username, 'password' => $password])->fetch();

        if (!$row) {
            throw new NetteSecurity\AuthenticationException('Účet nenalezen.');
        }
        return new NetteSecurity\Identity($row->id, null, ['username' => $row->username]);
    }
}