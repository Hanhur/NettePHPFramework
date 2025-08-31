<?php
    // Форма входа
    namespace App\Presentation\Sign;

    use Nette;
    use Nette\Application\UI\Form;

    final class SignPresenter extends Nette\Application\UI\Presenter
    {
        protected function createComponentSignInForm(): Form
        {
            $form = new Form;
            $form->addText('username', 'Имя пользователя:')->setRequired('Пожалуйста, введите ваше имя пользователя.');

            $form->addPassword('password', 'Пароль:')->setRequired('Пожалуйста, введите ваш пароль.');

            $form->addSubmit('send', 'Войти');

            $form->onSuccess[] = $this->signInFormSucceeded(...);
            return $form;
        }

        // Callback для входа
        private function signInFormSucceeded(Form $form, \stdClass $data): void
        {
            try {
                $this->getUser()->login($data->username, $data->password);
                $this->redirect('Home:');

            } catch (Nette\Security\AuthenticationException $e) {
                $form->addError('Неверное имя пользователя или пароль.');
            }
        }

        public function actionOut(): void
        {
            $this->getUser()->logout();
            $this->flashMessage('Выход выполнен успешно.');
            $this->redirect('Home:');
        }
    }
?>