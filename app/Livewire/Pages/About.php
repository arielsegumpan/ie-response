<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class About extends Component
{
    #[Layout('layouts.app')]
    #[Title('About')]
    public function render()
    {
        return view('livewire.pages.about');
    }
}
