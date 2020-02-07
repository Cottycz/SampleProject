<?php

namespace App\Model;

use Nette;
use Nette\Database\Context;

class UsersRepository
{
    private const TABLE = 'users';

    /** @var Context */
    private $database;

    public function __construct(Context $database)
    {
        $this->database = $database->table(self::TABLE);
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function registerUser(string $username, string $password)
    {
         $this->database->insert(['username' => $username, 'password' => $password]);
    }

    /**
     * @param string $username
     * @return Nette\Database\IRow|Nette\Database\Table\ActiveRow|null
     */
    public function userExists(string $username): ?Nette\Database\Table\ActiveRow
    {
        return $this->database->select('id')->where(['username' => $username])->fetch();
    }

    /**
     * @param int $id
     * @param string $newPassword
     */
    public function changePassword(int $id, string $newPassword)
    {
        $this->database->wherePrimary($id)->update(['password' => $newPassword]);
    }
}