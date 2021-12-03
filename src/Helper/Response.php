<?php

/**
 *
 */
class Response
{
    public static $instance;
    public $time         = 0;
    public $memory       = 0;
    public $exitCode     = 0;
    public $checker_log  = "";
    public $compiler_log = "";

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Response();
        }
        return self::$instance;
    }

    public function cast()
    {
        $castList = [
            'output' => "base64_encode",
            'memory' => "int",
        ];

        $this->checker_log  = $this->clearGarbaseValue($this->checker_log);
        $this->compiler_log = $this->clearGarbaseValue($this->compiler_log);
        $this->output       = $this->clearGarbaseValue($this->output);

        if (isset(request()->program_file)) {
            if (trim($this->compiler_log) != "") {
                $fileName           = explode('.', request()->program_file);
                $fileName           = $fileName[0];
                $this->compiler_log = str_replace($fileName, 'program', $this->compiler_log);
            }
        }

        foreach ($castList as $key => $value) {
            if (isset($this->$key)) {
                if ($value == "base64_encode") {
                    $this->$key = base64_encode($this->$key);
                }
                if ($value == "int") {
                    $this->$key = (int) ($this->$key);
                }
            }
        }
    }

    public function clearGarbaseValue($text)
    {
        $utf8 = array(
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u'  => 'A',
            '/[ÍÌÎÏ]/u'   => 'I',
            '/[íìîï]/u'   => 'i',
            '/[éèêë]/u'   => 'e',
            '/[ÉÈÊË]/u'   => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u'  => 'O',
            '/[úùûü]/u'   => 'u',
            '/[ÚÙÛÜ]/u'   => 'U',
            '/ç/'         => 'c',
            '/Ç/'         => 'C',
            '/ñ/'         => 'n',
            '/Ñ/'         => 'N',
            '/–/'         => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'  => ' ', // Literally a single quote
            '/[“”«»„]/u'  => ' ', // Double quote
            '/ /'         => ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }

    public function json()
    {
        $this->cast();
        echo json_encode(get_object_vars($this));
    }

    public function all()
    {
        return get_object_vars($this);
    }
}

function response()
{
    return Response::getInstance();
}
