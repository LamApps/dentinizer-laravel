<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalForm extends Component
{
    public $id;
    public $formName;
    public $content;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$formName,$content)
    {
        $this->id = $id;
        $this->formName = $formName;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modal-form');
    }
}
