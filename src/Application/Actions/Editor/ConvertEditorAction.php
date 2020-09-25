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
        $hjson = mb_ereg_replace('/\r/', "", $hjson); // make sure we have unix style text regardless of the input
        $parser = new \HJSON\HJSONParser();
        $obj = $parser->parse($hjson, ['assoc' => true]);
        $HjsonToPropelXml = new \HjsonToPropelXml\HjsonToPropelXml($this->Logger);
        $HjsonToPropelXml->convert($obj);

        $response['xml'] = $HjsonToPropelXml->getXml();
        $response['message'] = $this->Logger->getLog();
        return $this->respondWithData($response);
    }
}
