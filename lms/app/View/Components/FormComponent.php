<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormComponent extends Component
{
    public $action;
    public $method;
    public $title;

    public function __construct($action = '#', $method = 'POST', $title = null)
    {
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->title = $title;
    }

    public function render()
    {
        return view('components.form-component');
    }
}
