<?php

namespace App\Application\Actions\Editor;

use App\Application\Log\Logger;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;

class ConvertEditorAction extends Action
{

    public function __construct()
    {
        parent::__construct();
        $this->Logger = new Logger();
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $hjson = (string) $this->resolveArg('in');
        $HjsonToPropelXml = new \HjsonToPropelXml\HjsonToPropelXml($this->Logger);
        $HjsonToPropelXml->process($hjson);
        $response['xml'] = $HjsonToPropelXml->getXml();
        $response['message'] = $this->Logger->getLog();
        return $this->respondWithData($response);
    }
}
