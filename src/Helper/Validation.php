<?php

class Validation
{
    protected $submissionRoles = [
        'source_code' => 'required',
        'time_limit'  => 'required',
    ];
    protected $checkerRoles = [
        'source_code' => 'required',
        'time_limit'  => 'required',
    ];

    public function __construct()
    {
        $this->validate();
    }

    public function validate()
    {
        $validator  = new Validator;
        $validation = $validator->make(request()->all(), $this->roles());

        $validation->validate();
        if ($validation->fails()) {
            $errors = $validation->errors();
            //new ErrorEx($errors->firstOfAll());
        }
    }

    public function submissionValidation(){
        $error = [];
        

    }

    public function roles()
    {
        if (!isset(request()->api_type)) {
            new ErrorEx(['You can not select api type']);
        }
        return request()->api_type == "submission" ? $this->submissionRoles : $this->checkerRoles;
    }
}
