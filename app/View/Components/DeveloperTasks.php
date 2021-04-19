<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class DeveloperTasks extends Component
{
    /**
     * Developers list
     * @var Collection
     */
    public $developers;

    /**
     * List id
     * @var int
     */
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $developers)
    {
        $this->id = $id;
        $this->developers = $developers;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.developer-tasks');
    }
}
