<?php

namespace App\Application\Actions\Editor;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;

class ConvertEditorAction extends Action
{

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $hjson = (string) $this->resolveArg('in');
        $std = mb_ereg_replace('/\r/', "", $hjson); // make sure we have unix style text regardless of the input
        $hjson = $cr ? mb_ereg_replace("\n", "\r\n", $std) : $std;
        $parser = new \HJSON\HJSONParser();
        $obj = $parser->parse($hjson, ['assoc' => true]);
        $HjsonToPropelXml = new \HjsonToPropelXml\HjsonToPropelXml($this->logger);
        $HjsonToPropelXml->convert($obj);

        return $this->respondWithData($HjsonToPropelXml->getXml());
    }
}
