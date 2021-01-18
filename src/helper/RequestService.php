<?php
use Rakit\Validation\Validator;

/**
 *
 */
class RequestService
{
    public function __construct()
    {
        $this->decode();
    }

    public function decode()
    {
        $baseDecodeList = [
            'source_code', 'input', 'expected_output', 'output', 'checker',
        ];
        foreach ($baseDecodeList as $key => $value) {
            if (isset(request()->$value)) {
                request()->$value = base64_decode(request()->$value);
            }
        }
    }

}
