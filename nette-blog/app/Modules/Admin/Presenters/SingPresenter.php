<?php

    namespace App\Modules\Admin\Presenters;

    use Nette\Application\UI\Form;
    use Nette\Security\AuthenticationException;

    class SingPresenter extends BaseAdminPresenter   
    {
        protected function createComponentSingInForm(): Form 
        {
            $form = new Form();
            $form->addText("username", "User name")->setRequired();
            $form->addPassword("password", "Password")->setRequired();
            $form->addSubmit("login", "Login");
            $form->onSuccess[] = [$this, "onSingInFormSuccess"];
            return $form;
        }

        public function onSingInFormSuccess(Form $form, $values)
        {
            try{
                $this->getUser()->login($values["username"], $values['password']);
                $this->redirect('Dashboard:');
            } catch(AuthenticationException $e){
                $form->addError($e->getMessage());
            }
        }
    }
?>