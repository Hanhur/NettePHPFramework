<?php

namespace App\Modules\Admin\Presenters;

use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Tracy\Debugger;


class SignPresenter extends BaseAdminPresenter
{
    protected function createComponentsSingInForm(): Form 
    {
        $form = new Form();
        $form->addText('username', 'Uaer name')->setRequired();
        $form->addPassword('password', 'Password')->setRequired();
        $form->addSubmit('login', 'Login');
        $form->onSuccess[] = [$this, 'onSingInFormSuccess'];
        return $form;
    }

    public function onSingInFormSuccess(Form $form, $values)
    {
        try {
            $this->getUser()->login($values['username'], $values['password']);
            $this->redirect('Dashboard:');
        } catch (AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

    public function actionOut()
    {
        $this->getUser()->logout(true);
        $this->flashMessage('You have successfully finished working with the system as an administrator.');
        $this->redirect(':Front:Homepage:');
    }
}

?>