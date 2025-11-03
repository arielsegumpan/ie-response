<x-filament-panels::page>

        {{-- <x-filament-panels::header>
                <x-slot name="heading">
                    {{ __('') }}
                </x-slot>

                <x-slot name="subheading">
                    <h6>{{ __('Update your profile information and email address.') }}</h6>
                </x-slot>
        </x-filament-panels::header> --}}

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
</x-filament-panels::page>
