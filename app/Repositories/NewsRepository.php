<?php

namespace App\Model;

use Nette;
use Nette\Database\Context;

class NewsRepository
{
    private const TABLE = 'news';

    /** @var Context */
    private $database;

    public function __construct(Context $database)
    {
        $this->database = $database->table(self::TABLE);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array|Nette\Database\Table\IRow[]
     */
    public function getNews(int $limit, int $offset): ?Array
    {
        return $this->database->select('*')->limit($limit, $offset)->order('system_created DESC')->fetchAll();
    }

    /**
     * @param $values
     */
    public function insertNews($values)
    {
        $this->database->insert($values);
    }

    /**
     * @return int
     */
    public function getNewsCount(bool $logged = false): int
    {
        if ($logged) {
            return $this->database->count('id');
        }
        return $this->database->where('loggedonly', 0)->count('id');
    }

    /**
     * @param int $articleId
     */
    public function deleteArticle(int $articleId)
    {
        $this->database->wherePrimary($articleId)->delete();
    }
}