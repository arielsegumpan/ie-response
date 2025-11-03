<x-filament-panels::page>

<<<<<<< HEAD
        <x-filament-panels::header>
                <x-slot name="heading">
                    {{ __('') }}
                </x-slot>

                <x-slot name="subheading">
                    {{ __('Update your profile information and email address.') }}
                </x-slot>
        </x-filament-panels::header>

    <div class="space-y-6">
        <x-filament-panels::form wire:submit="save">
            {{ $this->form }}

            <x-filament-panels::form.actions :actions="$this->getFormActions()" />
            {{-- <x-filament-panels::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            /> --}}
        </x-filament-panels::form>
    </div>
=======
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
</x-filament-panels::page>
