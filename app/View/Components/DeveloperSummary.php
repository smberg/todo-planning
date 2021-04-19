<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class DeveloperSummary extends Component
{
    /**
     * Developers list
     * @var Collection
     */
    public $developers;

    /**
     * Completion Week
     * @var int
     */
    public $completionWeek;

    /**
     * Completion Time
     * @var int
     */
    public $completionTime;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($developers, $completionWeek, $completionTime)
    {
        $this->developers = $developers;
        $this->completionWeek = $completionWeek;
        $this->completionTime = $completionTime;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.developer-summary');
    }
}
