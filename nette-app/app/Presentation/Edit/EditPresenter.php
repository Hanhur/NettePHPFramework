<?php
    namespace App\Presentation\Edit;

    use Nette;
    use Nette\Application\UI\Form;

    // Новый презентер
    final class EditPresenter extends Nette\Application\UI\Presenter
    {
        public function __construct(private Nette\Database\Explorer $database) 
        {
        }

        // Форма для сохранения постов
        protected function createComponentPostForm(): Form
        {
            $form = new Form;
            $form->addText('title', 'Заголовок:')->setRequired();
            $form->addTextArea('content', 'Содержимое:')->setRequired();

            $form->addSubmit('send', 'Сохранить и опубликовать');
            $form->onSuccess[] = $this->postFormSucceeded(...);

            return $form;
        }

        // Сохранение нового поста из формы, и редактировать уже существующую статью
        private function postFormSucceeded(array $data): void
        {
            $id = $this->getParameter('id');

            if ($id) {
                $post = $this->database->table('posts')->get($id);
                $post->update($data);

            } else {
                $post = $this->database->table('posts')->insert($data);
            }

            $this->flashMessage('Пост был успешно опубликован.', 'success');
            $this->redirect('Post:show', $post->id);
        }

        // Редактирование постов
        public function renderEdit(int $id): void
        {
            $post = $this->database->table('posts')->get($id);

            if (!$post) {
                $this->error('Post not found');
            }

            $this->getComponent('postForm')->setDefaults($post->toArray());
        }

        // Защита презентеров
        public function startup(): void
        {
            parent::startup();

            if (!$this->getUser()->isLoggedIn()) {
                $this->redirect('Sign:in');
            }
        }
    }
?>