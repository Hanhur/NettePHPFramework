<?php

namespace App\Modules\Admin\Presenters;

use Nette\Application\UI\Presenter;

class BaseAdminPresenter extends Presenter
{
    public function startup()
    {
        parent::startup();
        // $appDir = $this->context->getParameters()['appDir'];
        $this->layout = 'layout';
    }
}

?>