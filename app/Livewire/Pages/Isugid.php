<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Livewire\Component;
use App\Models\Incident;
use Illuminate\Support\Str;
use App\Models\IncidentType;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use App\Models\IncidentLocation;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Isugid extends Component
{
    use WithFileUploads;

    public $latitude = '', $longitude = '';
    public $first_name, $last_name, $email, $phone;
    public $description;
    public string $priority = 'medium';
    public $incident_type_id;
    public array $involved = [['name' => '']];
    public array $incident_images = [['image_path' => '']];

    // public $incidentTypes;

    #[Computed()]
    public function incidentTypes(){
        return IncidentType::query()->get();
    }

    protected function rules(): array
    {
        return [
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'regex:/^(09|\+639)\d{9}$/'],
            'description' => ['required', 'string', 'max:2000'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'incident_type_id' => ['required', 'exists:incident_types,id'],
            'involved' => ['array'],
            'involved.*.name' => ['string', 'max:180'],
            'involved.*.injury' => ['string', 'max:300'],
            'incident_images' => ['array'],
            'incident_images.*.image_path' => ['nullable', 'file', 'max:5024', 'mimes:jpg,jpeg,png'],
        ];
    }

    protected function messages()
    {
        return [
            'phone.regex' => 'The phone number must start with 09 or +639 and be 11 digits long.',
            'incident_images.*.image_path.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
            'incident_images.*.image_path.max' => 'The image may not be greater than 5MB.',
            'involved.*.name.max' => 'The name may not be greater than 255 characters.',
            'involved.*.name.string' => 'The name must be a string.',
            'involved.*.name.required' => 'The name field is required.',
            'involved.*.injury.max' => 'The injury may not be greater than 300 characters.',
            'involved.*.injury.string' => 'The injury must be a string.',
            'incident_images.*.image_path.file' => 'The image must be a file.',
            'incident_type_id.exists' => 'The selected incident type is invalid.',
        ];
    }


    public function addPerson()
    {
        $this->involved[] = ['name' => null, 'injury' => null];
    }

    public function addImage()
    {
        $this->incident_images[] = ['image_path' => null];
    }

    public function removePerson($index)
    {
        unset($this->involved[$index]);
        $this->involved = array_values($this->involved);
    }

    public function removeImage($index)
    {
        unset($this->incident_images[$index]);
        $this->incident_images = array_values($this->incident_images);
    }

    public function submit()
    {
        $validated = $this->validate();

        $validated['first_name'] = strip_tags($validated['first_name']);
        $validated['last_name'] = strip_tags($validated['last_name']);
        $validated['email'] = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
        $validated['phone'] = preg_replace('/[^0-9+]/', '', $validated['phone']);
        $validated['description'] = htmlspecialchars(strip_tags($validated['description']));

        // dd($validated);
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => ucfirst($validated['first_name']) . ' ' . ucfirst($validated['last_name']),
                'email' => $validated['email'],
                'password' => bcrypt(Str::random(16)),
            ]);

            // Create Profile
            $user->profile()->create([
                'first_name' => ucfirst($validated['first_name']),
                'last_name' => ucfirst($validated['last_name']),
                'phone' => $validated['phone'],
            ]);

            // Create Incident
            $incident = Incident::create([
                'reporter_id' => Auth::id(),
                'incident_type_id' => $validated['incident_type_id'],
                'incident_number' => 'INC-NUM' . '-' . strtoupper(Str::random(6)) . '-' . rand(500, 9999),
                'involved' => array_map(
                    fn ($item) =>
                    [
                        'name' => strip_tags(ucwords($item['name'])),
                        'injury' => strip_tags(ucfirst($item['injury']))
                    ],
                    $validated['involved']
                ),
                'description' => $validated['description'],
                'priority' => $validated['priority'],
                'status' => 'reported',
            ]);

            // Store Location
            IncidentLocation::create([
                'incident_id' => $incident->id,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            // Store Uploaded Images
            foreach ($this->incident_images as $imageItem) {
                if (!empty($imageItem['image_path'])) {
                    $uploadedFile = $imageItem['image_path'];
                    $extension = $uploadedFile->getClientOriginalExtension();
                    $filename = strtoupper(Str::random(26)) . '.' . $extension;

                    // Store the file
                    $img_path = $uploadedFile->storeAs('incident_images', $filename, 'public');

                    $incident->images()->create([
                        'image_path' => $img_path,
                    ]);
                }
            }

            DB::commit();
            $this->reset();
            session()->flash('success', 'Incident reported successfully!');
            return redirect()->route('page.isugid');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error
            logger()->error('Incident submission failed: ' . $e->getMessage());

            session()->flash('error', 'Something went wrong. Please try again.');
            return null;
        }
    }


    #[Layout('layouts.app')]
    #[Title('Isugid')]
    public function render()
    {
        return view('livewire.pages.isugid');
    }
}
