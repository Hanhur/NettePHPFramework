<?php

    namespace App\Modules\Admin\Presenters;

    use Nette\Application\UI\Presenter;

    class BaseAdminPresenter extends Presenter
    {
        public function startup()
        {
            parent::startup();
            $this->layout = 'layout';
        }
    }
?>  