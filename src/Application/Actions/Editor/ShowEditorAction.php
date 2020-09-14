<?php

namespace App\Application\Actions\Editor;

use Psr\Http\Message\ResponseInterface as Response;

class ShowEditorAction extends EditorAction
{

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $editor = $this->Editor->show();

        return $this->respondWithHtml($editor);
    }
}
