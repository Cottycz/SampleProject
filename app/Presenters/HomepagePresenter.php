<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\NewsRepository;
use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var IUserPanel
     * @inject
     */
    public $userPanel;

    /** @var NewsRepository */
    private $newsRepository;

    /**
     * HomepagePresenter constructor.
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param int $page
     */
    public function renderDefault(int $page = 1): void
    {
        $newsCount = $this->newsRepository->getNewsCount($this->getUser()->loggedIn);

        $paginator = new Nette\Utils\Paginator();
        $paginator->setItemCount($newsCount);
        $paginator->setItemsPerPage(5);
        $paginator->setPage($page);

        $this->template->paginator = $paginator;
        $this->template->user = $this->getPresenter()->getUser();
        $this->template->news = $this->newsRepository->getNews($paginator->getLength(), $paginator->getOffset());
    }

    /**
     * @return UserPanel
     */
    protected function createComponentUserPanel(): UserPanel
    {
        return $this->userPanel->create();
    }

    /**
     * @param int $articleId
     */
    public function handleremoveArticle(int $articleId)
    {
        $this->newsRepository->deleteArticle($articleId);
        $this->flashMessage('Novinka smazána.', 'success');
        $this->getPresenter()->redirect('Homepage:');
    }

}
