
<div>
    <!-- Contact Us -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="max-w-2xl lg:max-w-5xl mx-auto">
            <!--Alert-->
            @if (session()->has('success'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    x-transition="fade"

                    class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30 mb-6" role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
                        <div class="flex">
                            <div class="shrink-0">
                                <!-- Icon -->
                                <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                                </span>
                                <!-- End Icon -->
                            </div>
                            <div class="ms-3">
                                <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
                                    {{ __('Successfully Reported.') }}
                                </h3>
                                <p class="text-sm text-gray-700 dark:text-neutral-400">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                </div>
            @endif
            <!-- End of Alert -->

            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl dark:text-white">
                    <span class="text-red-500">{{ __('Isugid') }}</span>{{ __(' Mo!') }}
                </h1>
                <p class="mt-1 text-gray-600 dark:text-neutral-400">
                    {{ __(" We'd love to help. Report any incidents or issues") }}
                </p>
            </div>

            <div class="pt-10 lg:pt-14">
                <!-- Features -->
                <div class="max-w-6xl mx-auto" wire:ignore>
                    <div id="hs-pin-leaflet" class="h-[350px] hs-leaflet z-10 rounded-[1rem] ring-1 ring-neutral-600 dark:ring-neutral-500"></div>
                </div>
                <!-- End Features -->
            </div>

            <form wire:submit.prevent="submit">
                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 lg:gap-x-8 mt-10 lg:mt-14">
                    <div class="border-b border-neutral-800 pb-10 mb-10 md:border-b-0 md:pb-0 md:mb-0">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Input -->
                                <div class="relative">
                                    <input type="text" wire:model='latitude' id="latitude" name="latitude" class="peer p-3 sm:p-4 block w-full bg-neutral-200 dark:bg-neutral-800 border-transparent rounded-lg sm:text-sm text-nutral-500 dark:text-white placeholder:text-transparent focus:outline-hidden focus:ring-0 focus:border-transparent disabled:opacity-50 disabled:pointer-events-none
                                        focus:pt-6
                                        focus:pb-2
                                        not-placeholder-shown:pt-6
                                        not-placeholder-shown:pb-2
                                        autofill:pt-6
                                        autofill:pb-2" placeholder="Latitude" readonly="" required>
                                    <label for="latitude" class="absolute top-0 start-0 p-3 sm:p-4 h-full text-neutral-400 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                        peer-focus:text-xs
                                        peer-focus:-translate-y-1.5
                                        peer-focus:text-neutral-400
                                        peer-not-placeholder-shown:text-xs
                                        peer-not-placeholder-shown:-translate-y-1.5
                                        peer-not-placeholder-shown:text-neutral-400">Latitude</label>
                                    @error('latitude')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Input -->

                                <!-- Input -->
                                <div class="relative">
                                    <input type="text" wire:model='longitude' id="longitude" name="longitude" class="peer p-3 sm:p-4 block w-full bg-neutral-200 dark:bg-neutral-800 border-transparent rounded-lg sm:text-sm text-nutral-500 dark:text-white placeholder:text-transparent focus:outline-hidden focus:ring-0 focus:border-transparent disabled:opacity-50 disabled:pointer-events-none
                                        focus:pt-6
                                        focus:pb-2
                                        not-placeholder-shown:pt-6
                                        not-placeholder-shown:pb-2
                                        autofill:pt-6
                                        autofill:pb-2" placeholder="Longitude" readonly="" required>
                                        <label for="longitude" class="absolute top-0 start-0 p-3 sm:p-4 h-full text-neutral-400 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                        peer-focus:text-xs
                                        peer-focus:-translate-y-1.5
                                        peer-focus:text-neutral-400
                                        peer-not-placeholder-shown:text-xs
                                        peer-not-placeholder-shown:-translate-y-1.5
                                        peer-not-placeholder-shown:text-neutral-400">Longitude</label>
                                    @error('longitude')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Input -->

                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Input -->
                                <div class="relative">
                                    <input type="text" wire:model.blur='first_name' id="first_name" name="first_name" class="peer p-3 sm:p-4 block w-full bg-neutral-200 dark:bg-neutral-800 border-transparent rounded-lg sm:text-sm text-nutral-500 dark:text-white placeholder:text-transparent focus:outline-hidden focus:ring-0 focus:border-transparent disabled:opacity-50 disabled:pointer-events-none
                                        focus:pt-6
                                        focus:pb-2
                                        not-placeholder-shown:pt-6
                                        not-placeholder-shown:pb-2
                                        autofill:pt-6
                                        autofill:pb-2" placeholder="First Name">
                                    <label for="first_name" class="absolute top-0 start-0 p-3 sm:p-4 h-full text-neutral-400 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                        peer-focus:text-xs
                                        peer-focus:-translate-y-1.5
                                        peer-focus:text-neutral-400
                                        peer-not-placeholder-shown:text-xs
                                        peer-not-placeholder-shown:-translate-y-1.5
                                        peer-not-placeholder-shown:text-neutral-400">First Name</label>
                                    @error('first_name')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Input -->

                                <!-- Input -->
                                <div class="relative">
                                    <input type="text" wire:model.blur='last_name' id="last_name" name="last_name" class="peer p-3 sm:p-4 block w-full bg-neutral-200 dark:bg-neutral-800 border-transparent rounded-lg sm:text-sm text-nutral-500 dark:text-white placeholder:text-transparent focus:outline-hidden focus:ring-0 focus:border-transparent disabled:opacity-50 disabled:pointer-events-none
                                        focus:pt-6
                                        focus:pb-2
                                        not-placeholder-shown:pt-6
                                        not-placeholder-shown:pb-2
                                        autofill:pt-6
                                        autofill:pb-2" placeholder="Last Name">
                                    <label for="last_name" class="absolute top-0 start-0 p-3 sm:p-4 h-full text-neutral-400 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                        peer-focus:text-xs
                                        peer-focus:-translate-y-1.5
                                        peer-focus:text-neutral-400
                                        peer-not-placeholder-shown:text-xs
                                        peer-not-placeholder-shown:-translate-y-1.5
                                        peer-not-placeholder-shown:text-neutral-400">Last Name</label>
                                    @error('last_name')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Input -->
                            </div>

                            <!-- Input -->
                            <div class="relative">
                                <input type="email" wire:model.blur='email' id="email" name="email" class="peer p-3 sm:p-4 block w-full bg-neutral-200 dark:bg-neutral-800 border-transparent rounded-lg sm:text-sm text-nutral-500 dark:text-white placeholder:text-transparent focus:outline-hidden focus:ring-0 focus:border-transparent disabled:opacity-50 disabled:pointer-events-none
                                focus:pt-6
                                focus:pb-2
                                not-placeholder-shown:pt-6
                                not-placeholder-shown:pb-2
                                autofill:pt-6
                                autofill:pb-2" placeholder="Email">
                                <label for="email" class="absolute top-0 start-0 p-3 sm:p-4 h-full text-neutral-400 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                peer-focus:text-xs
                                peer-focus:-translate-y-1.5
                                peer-focus:text-neutral-400
                                peer-not-placeholder-shown:text-xs
                                peer-not-placeholder-shown:-translate-y-1.5
                                peer-not-placeholder-shown:text-neutral-400">Email</label>
                                @error('email')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- End Input -->

                            <!-- Input -->
                            <div class="relative">
                                <input type="text" wire:model.blur='phone' id="phone" name="phone" class="peer p-3 sm:p-4 block w-full bg-neutral-200 dark:bg-neutral-800 border-transparent rounded-lg sm:text-sm text-nutral-500 dark:text-white placeholder:text-transparent focus:outline-hidden focus:ring-0 focus:border-transparent disabled:opacity-50 disabled:pointer-events-none
                                focus:pt-6
                                focus:pb-2
                                not-placeholder-shown:pt-6
                                not-placeholder-shown:pb-2
                                autofill:pt-6
                                autofill:pb-2" placeholder="Phone">
                                <label for="phone" class="absolute top-0 start-0 p-3 sm:p-4 h-full text-neutral-400 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                peer-focus:text-xs
                                peer-focus:-translate-y-1.5
                                peer-focus:text-neutral-400
                                peer-not-placeholder-shown:text-xs
                                peer-not-placeholder-shown:-translate-y-1.5
                                peer-not-placeholder-shown:text-neutral-400">Phone</label>
                                @error('phone')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- End Input -->

                            <!-- Floating Select -->
                            <div class="relative">

                                <div class="w-full dark:text-white" wire:ignore>
                                    <select
                                    wire:model.defer="incident_type_id"
                                    id="incident_type_id"
                                    name="incident_type_id"
                                    class="bg-white dark:bg-neutral-900 border border-gray-300 dark:border-neutral-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:text-white"
                                    data-hs-select='{
                                        "hasSearch": true,

                                        "searchLimit": 5,

                                        "searchPlaceholder": "Search incident type...",

                                        "placeholder": "Select incident type",

                                        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",

                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-red-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",

                                        "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",

                                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",

                                        "searchClasses": "block w-full sm:text-sm border-gray-200 rounded-lg focus:border-red-500 focus:ring-red-500 before:absolute before:inset-0 before:z-1 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-1.5 sm:py-2 px-3",
                                        "searchWrapperClasses": "sticky top-0 z-10 bg-white p-2 dark:bg-neutral-800",

                                        "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",

                                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                    }'
                                    >
                                    <option value="">Select incident type</option>
                                    @foreach ($this->incidentTypes as $type)
<<<<<<< HEAD
                                        <option wire:key="{{ $type->id }}" value="{{ $type->id }}">{{ $type->inc_name }}</option>
=======
                                        <option value="{{ $type->id }}">{{ $type->inc_name }}</option>
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
                                    @endforeach
                                    </select>
                                    @error('incident_type_id')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- End Floating Select -->
                            <!-- Textarea -->
                            <div class="relative">
                                <textarea wire:model.blur='description' rows="6" id="description" name="description" class="peer p-3 sm:p-4 block w-full bg-neutral-200 dark:bg-neutral-800 border-transparent rounded-lg sm:text-sm text-nutral-500 dark:text-white placeholder:text-transparent focus:outline-hidden focus:ring-0 focus:border-transparent disabled:opacity-50 disabled:pointer-events-none
                                focus:pt-6
                                focus:pb-2
                                not-placeholder-shown:pt-6
                                not-placeholder-shown:pb-2
                                autofill:pt-6
                                autofill:pb-2" placeholder="Description" data-hs-textarea-auto-height></textarea>
                                <label for="description" class="absolute top-0 start-0 p-3 sm:p-4 h-full text-neutral-400 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                peer-focus:text-xs
                                peer-focus:-translate-y-1.5
                                peer-focus:text-neutral-400
                                peer-not-placeholder-shown:text-xs
                                peer-not-placeholder-shown:-translate-y-1.5
                                peer-not-placeholder-shown:text-neutral-400">Description</label>

                                @error('description')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- End Textarea -->
                            </div>

                            <div class="mt-5 lg:mt-8">
                                <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                    {{ __('Priority') }}
                                </h2>
                                @php
                                    $priorities = [
                                        'low' => [
                                            'label' => 'Low',
                                            'svg' => '<svg class="size-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" /></svg>'
                                        ],
                                        'medium' => [
                                            'label' => 'Medium',
                                            'svg' => '<svg class="size-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>'
                                        ],
                                        'high' => [
                                            'label' => 'High',
                                            'svg' => '<svg class="size-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" /></svg>'
                                        ],
                                        'critical' => [
                                            'label' => 'Critical',
                                            'svg' => '<svg class="size-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>'
                                        ],
                                    ];
                                @endphp

                                <div class="grid sm:grid-cols-2 gap-2">
                                    @foreach ($priorities as $value => $data)
                                        <label
                                            wire:key="priority-{{ $value }}"
                                            class="flex items-center p-3 w-full border rounded-lg text-sm cursor-pointer transition-all
                                                {{ $priority === $value ? 'bg-neutral-200 dark:bg-neutral-800' : 'bg-white dark:bg-neutral-900' }}
                                                border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-neutral-300"
                                        >
                                            <input
                                                type="radio"
                                                wire:model.live="priority"
                                                value="{{ $value }}"
                                                class="sr-only shrink-0 mt-0.5 border-gray-200 rounded-full text-red-600 focus:ring-red-500 checked:border-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-red-500 dark:checked:border-red-500 dark:focus:ring-offset-gray-800"
                                            >

                                            <span class="flex items-center gap-2">
                                                {!! $data['svg'] !!}
                                                {{ $data['label'] }}
                                            </span>
                                        </label>

                                        @error('priority')
                                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs text-red-600 italic">
                                    All fields are required*
                                </p>
                            </div>
                        </div>

                    <div>
                        <!-- Repeater -->
                        <div class="space-y-14">
                            <!-- Card -->
                            <div class="flex flex-col border border-gray-200 rounded-xl p-4 sm:p-6 lg:p-8 dark:border-neutral-700">
                                <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                {{ __("Person's Involved") }}
                                </h2>
                                <div class="grid gap-4">
                                    @foreach ($involved as $index => $person)
                                    <!-- Input -->
                                    <div wire:key="involved-{{ $index }}" class="relative">
                                        <div class="flex flex-row gap-x-3">
                                            <div class="relative flex-1">
                                                <input type="text" wire:model.blur="involved.{{ $index }}.name" id="{{ $index }}.name" name="{{ $index }}.name" class="peer p-3 sm:p-4 block w-full bg-neutral-200 dark:bg-neutral-800 border-transparent rounded-lg sm:text-sm text-nutral-500 dark:text-white placeholder:text-transparent focus:outline-hidden focus:ring-0 focus:border-transparent disabled:opacity-50 disabled:pointer-events-none
                                                    focus:pt-6
                                                    focus:pb-2
                                                    not-placeholder-shown:pt-6
                                                    not-placeholder-shown:pb-2
                                                    autofill:pt-6
                                                    autofill:pb-2" placeholder="Name">
                                                <label for="{{ $index }}.name" class="absolute top-0 start-0 p-3 sm:p-4 h-full text-neutral-400 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                                    peer-focus:text-xs
                                                    peer-focus:-translate-y-1.5
                                                    peer-focus:text-neutral-400
                                                    peer-not-placeholder-shown:text-xs
                                                    peer-not-placeholder-shown:-translate-y-1.5
                                                    peer-not-placeholder-shown:text-neutral-400">{{ __("Name") }}
                                                </label>
                                            </div>

                                            <div class="relative flex-1">
                                                <input type="text" wire:model.blur="involved.{{ $index }}.injury" id="{{ $index }}.injury" name="{{ $index }}.injury" class="peer p-3 sm:p-4 block w-full bg-neutral-200 dark:bg-neutral-800 border-transparent rounded-lg sm:text-sm text-nutral-500 dark:text-white placeholder:text-transparent focus:outline-hidden focus:ring-0 focus:border-transparent disabled:opacity-50 disabled:pointer-events-none
                                                    focus:pt-6
                                                    focus:pb-2
                                                    not-placeholder-shown:pt-6
                                                    not-placeholder-shown:pb-2
                                                    autofill:pt-6
                                                    autofill:pb-2" placeholder="Injury">
                                                <label for="{{ $index }}.injury" class="absolute top-0 start-0 p-3 sm:p-4 h-full text-neutral-400 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                                    peer-focus:text-xs
                                                    peer-focus:-translate-y-1.5
                                                    peer-focus:text-neutral-400
                                                    peer-not-placeholder-shown:text-xs
                                                    peer-not-placeholder-shown:-translate-y-1.5
                                                    peer-not-placeholder-shown:text-neutral-400">{{ __("Injury") }}
                                                </label>
                                            </div>

                                            <button type="button" wire:click="removePerson({{ $index }})"
                                                class="py-3 px-4 mx-auto inline-flex items-center align-middle text-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                                                <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>

                                            </button>
                                        </div>
                                    </div>

                                    @error('involved.{{ $index }}.name')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                    <!-- End Input -->
                                    @endforeach

                                    <button type="button" wire:click="addPerson" class="py-2 px-3 mx-auto inline-flex items-center align-middle text-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                                        <svg class="shrink-0 size-4"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        {{ __('Add another person') }}
                                    </button>
                                </div>
                                <!-- End Grid -->
                            </div>
                            <!-- End Card -->
                        </div>
                        <!-- End Repeater -->

                        <!-- INCIDENT PHOTO -->
                        <div class="mt-8">
                            <div class="max-w-full">
                                <!-- Card -->
                                <div class="flex flex-col border border-gray-200 rounded-xl p-4 sm:p-6 lg:p-8 dark:border-neutral-700">
                                    <div class="flex flex-row gap-x-3 justify-between items-center align-middle mb-5 lg:mb-7 ">

                                        <div>
                                            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                                {{ __('Incident Photo') }}
                                            </h2>
                                        </div>

                                        <div>
                                            <button type="button" wire:click="addImage" class="py-2 px-3 mx-auto inline-flex items-center align-middle text-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                                                <svg class="shrink-0 size-4"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                                {{ __('Add image') }}
                                            </button>
                                        </div>
                                    </div>

                                    @foreach ($incident_images as $index => $upIncidentImage)
                                    <div wire:key="image-{{ $index }}" class="flex flex-row justify-between mt-4">

                                        <div>
                                            <label class="block">
                                                <span class="sr-only">Choose incident photo</span>
                                                <input type="file" wire:model.blur="incident_images.{{ $index }}.image_path" id="{{ $index }}.image_path" name="{{ $index }}.image_path" class="block w-full text-sm text-gray-500
                                                file:me-4 file:py-2 file:px-4
                                                file:rounded-lg file:border-0
                                                file:text-sm file:font-semibold
                                                file:bg-red-600 file:text-white
                                                hover:file:bg-red-700
                                                file:disabled:opacity-50 file:disabled:pointer-events-none
                                                dark:text-neutral-500
                                                dark:file:bg-red-600
                                                dark:hover:file:bg-red-600
                                                ">
                                            </label>

                                        </div>
                                        <div>
                                            <button type="button" wire:click="removeImage({{ $index }})"
                                                    class="py-2 px-2 mx-auto inline-flex items-center align-middle text-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                                                    <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                            </button>
                                        </div>
                                    </div>

                                    @error('incident_images.{{ $index }}.image_path')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                    @endforeach

                                </div>
                                <!-- End Card -->
                            </div>
                        </div>
                        <!-- End INCIDENT PHOTO -->
                    </div>
                </div>
                <!-- End Grid -->

                <p class="mt-5">
                    <button type="submit" class="group inline-flex items-center gap-x-2 py-3 px-4 bg-red-600 font-medium text-sm text-neutral-800 rounded-lg focus:outline-hidden text-white hover:bg-red-700 focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                        {{ __('Submit') }}
                        <svg class="shrink-0 size-4 transition group-hover:translate-x-0.5 group-hover:translate-x-0 group-focus:translate-x-0.5 group-focus:translate-x-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </p>
            </form>
        </div>
    </div>
    <!-- End Contact Us -->

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            (function () {
                const mapContainer = document.getElementById('hs-pin-leaflet');
                if (!mapContainer || mapContainer.dataset.mapInitialized === 'true') return;

                // Initialize map with default location
                const map = L.map('hs-pin-leaflet', {
                    center: [10.902693, 123.072609],
                    zoom: 15
                });

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    minZoom: 2,
                    attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                let singleMarker;

                // Try to get the current device location
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            // Center the map to the current location
                            map.setView([lat, lng], 16);

                            // Add a marker at the user's location
                            L.marker([lat, lng])
                                .addTo(map)
                                .bindPopup(`<strong>Your Location</strong><br>${lat.toFixed(5)}, ${lng.toFixed(5)}`)
                                .openPopup();

                            // Optional: update hidden inputs if you have them
                            const latInput = document.getElementById('latitude');
                            const lngInput = document.getElementById('longitude');
                            if (latInput && lngInput) {
                                latInput.value = lat.toFixed(5);
                                lngInput.value = lng.toFixed(5);
                                latInput.dispatchEvent(new Event('input', { bubbles: true }));
                                lngInput.dispatchEvent(new Event('input', { bubbles: true }));
                            }
                        },
                        (error) => {
                            console.warn("Geolocation error:", error.message);
                            alert("Unable to retrieve your location. Please allow location access or set manually.");
                        }
                    );
                } else {
                    alert("Geolocation is not supported by your browser.");
                }

                // Handle map click to manually set location
                map.on('click', function (e) {
                    const { lat, lng } = e.latlng;

                    document.getElementById('latitude').value = lat.toFixed(5);
                    document.getElementById('longitude').value = lng.toFixed(5);

                    const latInput = document.getElementById('latitude');
                    const lngInput = document.getElementById('longitude');

                    latInput.value = lat.toFixed(5);
                    lngInput.value = lng.toFixed(5);

                    latInput.dispatchEvent(new Event('input', { bubbles: true }));
                    lngInput.dispatchEvent(new Event('input', { bubbles: true }));

                    const popupContent = `You clicked at:<br><strong>${lat.toFixed(5)}, ${lng.toFixed(5)}</strong>`;

                    if (singleMarker) {
                        singleMarker.setLatLng([lat, lng])
                            .setPopupContent(popupContent)
                            .openPopup();
                    } else {
                        singleMarker = L.marker([lat, lng])
                            .addTo(map)
                            .bindPopup(popupContent)
                            .openPopup();
                    }
                });

                // Prevent re-initializing if already done
                mapContainer.dataset.mapInitialized = 'true';
            })();
        });
        </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            (function () {
                const mapContainer = document.getElementById('hs-pin-leaflet');
                if (!mapContainer || mapContainer.dataset.mapInitialized === 'true') return;

                const map = L.map('hs-pin-leaflet', {
                    center: [10.902693, 123.072609],
                    zoom: 15
                });

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    minZoom: 2,
                    attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                let singleMarker;

                map.on('click', function (e) {
                    const { lat, lng } = e.latlng;

                    document.getElementById('latitude').value = lat.toFixed(5);
                    document.getElementById('longitude').value = lng.toFixed(5);


                    const latInput = document.getElementById('latitude');
                    const lngInput = document.getElementById('longitude');

                    latInput.value = lat.toFixed(5);
                    lngInput.value = lng.toFixed(5);

                    latInput.dispatchEvent(new Event('input', { bubbles: true }));
                    lngInput.dispatchEvent(new Event('input', { bubbles: true }));

                    const popupContent = `You clicked at:<br><strong>${lat.toFixed(5)}, ${lng.toFixed(5)}</strong>`;

                    if (singleMarker) {
                        singleMarker.setLatLng([lat, lng])
                            .setPopupContent(popupContent)
                            .openPopup();
                    } else {
                        singleMarker = L.marker([lat, lng])
                            .addTo(map)
                            .bindPopup(popupContent)
                            .openPopup();
                    }
                });

                // Prevent re-initializing if already done
                mapContainer.dataset.mapInitialized = 'true';
            })();
        });
    </script> --}}
    @endpush



</div>
