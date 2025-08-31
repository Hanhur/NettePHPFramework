<?php
    namespace App\Presentation\Post;

    use Nette;
    use Nette\Application\UI\Form;

    final class PostPresenter extends Nette\Application\UI\Presenter
    {
        public function __construct(private Nette\Database\Explorer $database) 
        {
        }

        public function renderShow(int $id): void
        {
            $post = $this->database->table('posts')->get($id);

            if (!$post) 
            {
                $this->error('Страница не найдена');
            }

            $this->template->post = $post;
            $this->template->comments = $post->related('comments', 'post_id')->order('created_at');
        }

        protected function createComponentCommentForm(): Form
        {
            $form = new Form; // означает Nette\Application\UI\Form

            $form->addText('name', 'Имя:')->setRequired();

            $form->addEmail('email', 'E-mail:');

            $form->addTextArea('content', 'Комментарий:')->setRequired();

            $form->addSubmit('send', 'Опубликовать комментарий');

            $form->onSuccess[] = $this->commentFormSucceeded(...);

            return $form;
        }

        private function commentFormSucceeded(\stdClass $data): void
        {
            $id = $this->getParameter('id');

            $this->database->table('comments')->insert([
                'post_id' => $id,
                'name' => $data->name,
                'email' => $data->email,
                'content' => $data->content,
            ]);

            $this->flashMessage('Спасибо за комментарий', 'success');
            $this->redirect('this');
        }
    }
?>