<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Incident;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

class Incidents extends Component
{
    public ?Incident $incident;

    public function mount($incident_number)
    {
        $this->incident = Incident::query()->with([
            'type:id,inc_name,inc_slug',
            'location',
            'images:id,incident_id,image_path',
            'responses'
        ])
        ->where('incident_number', $incident_number)
        ->firstOrFail();
        $this->incident->formatForView();
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.incidents',[
            'incident' => $this->incident
        ]);
    }
}
