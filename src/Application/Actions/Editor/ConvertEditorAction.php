<?php

namespace App\Application\Actions\Editor;

use Psr\Http\Message\ResponseInterface as Response;
use HjsonToPropelXml;

class ConvertEditorAction extends EditorAction
{

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
        $HjsonToPropelXml = new \HjsonToPropelXml\HjsonToPropelXml();
        $HjsonToPropelXml->convert($obj);

        return $this->respondWithData($HjsonToPropelXml->getXml());
    }
}
