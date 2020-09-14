<?php

namespace App\Domain\Editor;

use App\Application\Helper\Html\Assets;
use App\Application\Helper\Html\Html;

class Editor
{

    public function __construct()
    {
    }

    /**
     * @return User[]
     */
    public function show(): string
    {

        $Html = new Html('bootstrap', true);
        $Assets = new Assets(["pipeline" => false]);
        $Assets->add('vendor/components/jquery/jquery.min.js');
        $Assets->add('vendor/twbs/bootstrap/dist/css/bootstrap-reboot.min.css');
        $Assets->add('vendor/twbs/bootstrap/dist/css/bootstrap.min.css');
        $Assets->add('vendor/twbs/bootstrap/dist/js/bootstrap.min.js');
        $Assets->add('public/ace-builds/src-noconflict/ace.js');
        $Assets->add('public/css/main.css');

        $Html->addHead(['style' => $Assets->css(), 'script' => $Assets->js() . $Assets->js()], true);

        $Html
            ->jumbotron(null)
            ->addH1("Use HJSON intead of XML for Propel")
            ->addP("This a simple converter using drez/hjson-to-propel-xml, see https://github.com/drez/hjson-to-propel-xml and http://propelorm.org for documentation.")
            ->addP("This library is part of APIgoat.")
            ->close()
            ->div(null, ['class' => 'card-group'])
            ->div(null, ['class' => 'card'])
            ->div(null, ['class' => 'card-header'])
            ->addSpan("HJSON", ["style" => "display: inline-block;width: 15%;"])
            ->div(null, ["style" => "display: inline-block;width: 34%;text-align: right;"])
            ->addSpan("Load example: ")
            ->addSelect($this->getExampleOptions(), ['id' => 'exampleSelect'])
            ->close()
            ->div(null, ["style" => "display: inline-block;width: 50%;text-align: right;"])
            ->addBut("Convert", ['id' => 'convert', 'type' => 'primary'])
            ->close()
            ->close()
            ->div(null, ['class' => 'card-body'])
            ->addDiv("", ['id' => 'hjson-editor', "style" => "height: 100%; width: 100%"])
            ->close('all', 1)
            ->div(null, ['class' => 'card'])
            ->div(null, ['class' => 'card-header'])
            ->addSpan("Propel XML schema.", ["style" => "display: inline-block;width: 49%;margin: 7px 0px;"])
            ->div(null, ["style" => "display: inline-block;width: 50%;text-align: right;"])
            //->addBut("Download schema", ['id' => 'download', 'type' => 'primary'])
            ->close()
            ->close()
            ->div(null, ['class' => 'card-body'])
            ->addDiv("", ['id' => 'xml-editor', 'addclass' => 'editor', "style" => "height: 100%; width: 100%"])
            ->close('all');

        $script = <<<EOL
var editor = ace.edit("hjson-editor");
editor.setTheme("ace/theme/monokai");
editor.session.setMode("ace/mode/hjson");
$('#hjson-editor').height($(window).height()+'px');
editor.resize();

/*
var changetimeout;
editor.session.on('change', function(delta) {
    clearTimeout(changetimeout);
    changetimeout = setTimeout(function (){
        convert();
    }, 2000);
});
*/

var editor2 = ace.edit("xml-editor");
editor2.setTheme("ace/theme/monokai");
editor2.session.setMode("ace/mode/xml");

$('#convert').click(function (){ convert(); });

editor.setValue($('#exampleSelect>option:selected').val());
$('#exampleSelect').change(function (){
    editor.setValue($('#exampleSelect>option:selected').val());
});

var convert = function(){
    $.post('${_SITE_URL}editor/convert', {in:editor.getValue()}, function (data){
        if(data.data){
            editor2.setValue(data.data);
        }
    }, 'json');
}

EOL;
        $Html->addScript($script);

        $html =  $Html->body(null, ['class' => 'body'])->addContainerFull($Html->getBuffer())->close()->getPage();
        return ($html) ? $html : '';
    }

    private function getExampleOptions(): string
    {
        $choices = $this->getExamples();
        $Html = new Html();
        $Html->preprint($choices);
        foreach ($choices as $name => $value) {
            if (!empty($value))
                $Html->addOption($name, ['value' => \htmlentities($value)]);
        }
        return $Html->getHtml();
    }

    private function getExamples(): array
    {
        $path = _ROOT_DIR . 'vendor/drez/hjson-to-propel-xml/examples/';
        $files = scandir($path);

        foreach ($files as $file) {
            if (strstr($file, '.hjson')) {
                $examples[$file] = implode('', file($path . $file));
            }
        }

        return $examples;
    }
}
