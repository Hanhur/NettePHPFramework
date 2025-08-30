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
        }

        protected function createComponentCommentForm(): Form
        {
            $form = new Form; // означает Nette\Application\UI\Form

            $form->addText('name', 'Имя:')->setRequired();

            $form->addEmail('email', 'E-mail:');

            $form->addTextArea('content', 'Комментарий:')->setRequired();

            $form->addSubmit('send', 'Опубликовать комментарий');

            return $form;
        }

    }
?>