<?php

namespace App\Presenters;

use App\Model\NewsRepository;
use App\Model\UsersRepository;
use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;

class UserPanel extends Control
{
    /** @var UsersRepository */
    private $usersRepository;

    /** @var NewsRepository */
    private $newsRepository;

    /**
     * UserPanel constructor.
     * @param UsersRepository $usersRepository
     * @param NewsRepository $newsRepository
     */
    public function __construct(UsersRepository $usersRepository, NewsRepository $newsRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->newsRepository = $newsRepository;
    }

    public function render()
    {
        $this->template->user = $this->getPresenter()->getUser();
        $this->template->setFile(__DIR__ . '/templates/userPanel.latte');
        $this->template->render();
    }

    /**
     * @return Form
     */
    protected function createComponentSignInForm(): Form
    {
        $form = new Form();
        $form->addText('username', 'Jméno:')
            ->setHtmlAttribute('class', 'form-control')
            ->setRequired('Je nutné vyplnit uživatelské jméno');

        $form->addPassword('password', 'Heslo:')
            ->setHtmlAttribute('class', 'form-control')
            ->setRequired('Je nutné vyplnit uživatelské heslo');

        $form->addSubmit('submit', 'Přihlásit se')
            ->setHtmlAttribute('class', 'btn btn-primary')
            ->onClick[] = [$this, 'signInFormSucceeded'];

        $form->addSubmit('register', 'Registrovat se')
            ->setHtmlAttribute('class', 'btn')
            ->onClick[] = [$this, 'registerOnClick'];

        return $form;
    }

    /**
     * @return Form
     */
    protected function createComponentChangePassword(): Form
    {
        $form = new Form();

        $form->addPassword('password', 'Nové heslo:')
            ->setHtmlAttribute('class', 'form-control')
            ->setRequired('Je nutné vyplnit uživatelské heslo');

        $form->addSubmit('changePassword', 'Změnit heslo')
            ->setHtmlAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = [$this, 'changePasswordOnSuccess'];

        return $form;
    }

    /**
     * @return Form
     */
    protected function createComponentCreateArticle(): Form
    {
        $form = new Form();

        $form->addText('subject', 'Předmět:')
            ->setHtmlAttribute('class', 'form-control')
            ->setRequired('Je nutné vyplnit předmět');

        $form->addTextArea('message', 'Text článku:')
            ->setHtmlAttribute('class', 'form-control')
            ->setRequired('Je nutné vyplnit uživatelské heslo');

        $form->addSelect('loggedonly', 'Viditelné pouze pro přihlášené', ['Ne', 'Ano'])
            ->setHtmlAttribute('class', 'form-control');

        $form->addSubmit('submit', 'Odeslat článek')
            ->setHtmlAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = [$this, 'sentArticleOnSuccess'];

        return $form;
    }

    /**
     * @param Form $form
     * @param Nette\Utils\ArrayHash $values
     * @throws Nette\Application\AbortException
     */
    public function signInFormSucceeded(Nette\Forms\Controls\SubmitButton $form, Nette\Utils\ArrayHash $values): void
    {
        try {
            $this->getPresenter()->getUser()->login($values->username, $values->password);
            $this->getPresenter()->redirect('Homepage:');

        } catch (Nette\Security\AuthenticationException $e) {
            $this->getPresenter()->flashMessage('Uživatelské jméno/heslo není správné..', 'warning');
            $this->getPresenter()->redrawControl();
        }
    }

    /**
     * @param Nette\Forms\Controls\SubmitButton $form
     * @param Nette\Utils\ArrayHash $values
     * @throws Nette\Application\AbortException
     * @throws Nette\Security\AuthenticationException
     */
    public function registerOnClick(Nette\Forms\Controls\SubmitButton $form, Nette\Utils\ArrayHash $values): void
    {
        if (!$this->usersRepository->userExists($values->username)) {
            $this->usersRepository->registerUser($values->username, $values->password);
            $this->getPresenter()->getUser()->login($values->username, $values->password);
            $this->getPresenter()->redirect('Homepage:');
        } else {
            $this->getPresenter()->flashMessage('Uživatelské jméno již existuje.', 'warning');
            $this->getPresenter()->redrawControl();
        }
    }

    /**
     * @param Form $form
     */
    public function changePasswordOnSuccess(Form $form): void
    {
        $this->usersRepository->changePassword($this->getPresenter()->getUser()->getId(), $form->values->password);
        $this->getPresenter()->flashMessage('Heslo bylo změněno.', 'success');
        $this->getPresenter()->redrawControl();
        $form->setValues([], TRUE);
    }

    /**
     * @param Form $form
     */
    public function sentArticleOnSuccess(Form $form): void
    {
        $this->newsRepository->insertNews($form->values);
        $this->getPresenter()->flashMessage('Příspěvek byl vložen.', 'success');
        $this->getPresenter()->redrawControl();
        $form->setValues([], TRUE);
    }

    /**
     * @throws Nette\Application\AbortException
     */
    public function handleOut(): void
    {
        $this->getPresenter()->getUser()->logout();
        $this->getPresenter()->flashMessage('Odhlášení bylo úspěšné.', 'success');
        $this->getPresenter()->redrawControl();
    }
}

/**
 * Interface IUserPanel
 * @package App\Presenters
 */
interface IUserPanel
{
    /** @return UserPanel */
    public function create();
}