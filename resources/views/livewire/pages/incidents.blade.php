<div>
    <!-- Invoice -->
    <div class="max-w-[85rem] px-4 lg:px-8 mx-auto my-4 sm:my-10">
        <div class="sm:w-11/12 lg:w-3/4 mx-auto">
        <!-- Card -->
        <div class="flex flex-col p-4 sm:p-10 bg-white shadow-md rounded-xl dark:bg-neutral-800">

            <div class="flex flex-row justify-between items-center align-middle w-full">
                <h1 class=" mb-3
                mb-2 text-2xl md:text-3xl font-semibold
                py-1 px-5 inline-flex items-start bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500
                ">{{ $incident->incident_number }}</h1>

                <a class="inline-flex flex-row items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline dark:text-red-500" href="{{ route('page.home') }}">
                    <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"><path d="m15 18-6-6 6-6"/></svg>
                    {{ __('Back to Home') }}
                </a>
            </div>


            <!-- Grid -->
            <div class="flex flex-col md:flex-row md:inline-flex w-full gap-x-5 gap-y-5 md:gap-y-0">
                <div>
                    <div id="hs-pin-leaflet" class="h-70 md:h-60 lg:h-100 hs-leaflet z-10 md:w-[250px] lg:w-[500px] rounded-[1rem] ring-1 ring-neutral-600 dark:ring-neutral-500"></div>
                </div>
            <!-- Col -->

                <div class="text-start my-auto">
                    @php
                        switch ($incident?->status) {
                            case 'Reported':
                                $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-600';
                                $iconSVG = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                </svg>
                                ';
                                break;
                            case 'Verified':
                                $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-600';
                                $iconSVG = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                ';
                                break;
                            case 'In Progress':
                                $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-600';
                                $iconSVG = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                ';
                                break;
                            case 'Resolved':
                                $statusClass = 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-600';
                                $iconSVG = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                ';
                                break;
                            case 'Closed':
                                $statusClass = 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-600';
                                $iconSVG = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                ';
                                break;
                            default:
                                $statusClass = 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-600';
                        }
                    @endphp

                    <span class="inline-flex items-center gap-x-1.5 py-1.5 mb-2 px-3 rounded-lg text-xs font-medium {{ $statusClass }}">
                        {!! $iconSVG !!}
                        {{ $incident?->status }}
                    </span>



                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 dark:text-neutral-200">{{ $incident->type?->inc_name }}</h2>
                    <span class="mt-1 block text-gray-500 dark:text-neutral-500">{{ $incident->formatted_created_at }}</span>

                    @php
                        switch ($incident?->priority) {
                            case 'LOW':
                                $priorityClass = 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-600';
                                $prioIcon = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                                </svg>';
                                break;
                            case 'MEDIUM':
                                $priorityClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-600';
                                $prioIcon = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                </svg>';
                                break;
                            case 'HIGH':
                                $priorityClass = 'bg-orange-100 text-orange-800 dark:bg-orange-500/20 dark:text-orange-600';
                                $prioIcon = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                                </svg>';
                                break;
                            case 'CRITICAL':
                                $priorityClass = 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-600';
                                $prioIcon = '<svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                                ';
                                break;
                            default:
                                $priorityClass = 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-600';
                        }
                    @endphp
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 mt-2 px-3 rounded-lg text-xs font-medium {{ $priorityClass }}">
                        {!! $prioIcon !!}
                        {{ $incident?->priority }}
                    </span>

                    <address class="mt-4 not-italic text-gray-800 dark:text-neutral-200">
                        <small class="text-gray-500 dark:text-neutral-500">
                            {{ __('lat, lng : ') }}
                            {{ $incident->location?->latitude }}, {{ $incident->location?->longitude }}
                        </small>
                    </address>

                    <dl class="flex flex-col gap-x-3 mt-4">
                        <dt class="font-semibold text-gray-800 dark:text-neutral-200">Incident date:</dt>
                        <dd class="text-gray-500 dark:text-neutral-500">{{ $incident->created_at->format('F j, Y, g:i a') }}</dd>
                    </dl>
                </div>
            <!-- Col -->
            </div>
            <!-- End Grid -->


            <!-- Table -->
            <div class="mt-6">
                <div class="border border-gray-200 p-4 rounded-lg space-y-4 dark:border-neutral-700">
                    <div class="hidden sm:grid sm:grid-cols-5">
                        <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Persons Involved</div>
                        <div class="text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Injury</div>
                    </div>

                    @foreach ($incident->involved as $key => $involved)
                        <div wire:key="involved-{{ $key }}" class="hidden sm:block border-b border-gray-200 dark:border-neutral-700"></div>

                        <div wire:key="involved-{{ $key }}" class="grid grid-cols-3 sm:grid-cols-5 gap-2">

                            <div class="col-span-full sm:col-span-2">
                                <p class="font-medium text-gray-800 dark:text-neutral-200">{{ $involved['name'] }}</p>
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <p class="text-gray-800 dark:text-neutral-400">{{ $involved['injury'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End Table -->

            <div class="mt-8 sm:mt-12 text-lg text-gray-800 dark:text-neutral-200">
                {!! str($incident->description)->sanitizeHtml() !!}
            </div>

            <div class="mt-5 lg:mt-10">
                <!-- Slider -->
                <div data-hs-carousel='{
                    "loadingClasses": "opacity-0",
                    "isInfiniteLoop": true,
                    "slidesQty": 1
                }' class="relative">
                    <div class="hs-carousel relative overflow-hidden w-full min-h-96 bg-white rounded-lg">
                    <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                        @foreach ($incident->images as $image)
                        <div class="hs-carousel-slide">
                            <div class="flex justify-center h-full bg-gray-100 p-6 dark:bg-neutral-900">
                                <img wire:key="image-{{ $image->id }}" src="{{ asset(Storage::url($image->image_path)) }}" alt="{{ $image->incident?->type?->inc_name }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    </div>

                    <button type="button" class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-s-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                    <span class="text-2xl" aria-hidden="true">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                        </svg>
                    </span>
                    <span class="sr-only">Previous</span>
                    </button>
                    <button type="button" class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-e-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                    <span class="sr-only">Next</span>
                    <span class="text-2xl" aria-hidden="true">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </span>
                    </button>

                    <div class="hs-carousel-info inline-flex justify-center px-4 absolute bottom-3 start-[50%] -translate-x-[50%] bg-white rounded-lg">
                    <span class="hs-carousel-info-current me-1">0</span>
                    /
                    <span class="hs-carousel-info-total ms-1">0</span>
                    </div>
                </div>
                <!-- End Slider -->
            </div>
        </div>
        <!-- End Card -->

        </div>
    </div>
    <!-- End Invoice -->
</div>

@push('scripts')
<script>
    window.incident = @json($incident);
    window.addEventListener('load', () => {
        (function () {
            const map = L.map('hs-pin-leaflet', {
                center: [10.901002750609775, 123.07139009929351],
                zoom: 18,
                maxBounds: [
                    [10.83, 122.98],
                    [10.94, 123.17]
                ],
                maxBoundsViscosity: 0.4
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                minZoom: 2,
                attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            if (window.incident && window.incident.location && window.incident.location.latitude && window.incident.location.longitude) {
                const lat = parseFloat(window.incident.location.latitude);
                const lng = parseFloat(window.incident.location.longitude);
                L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(createPopupContent())
                    .openPopup();

                map.setView([lat, lng], 18);
            } else {
                console.error("Latitude/Longitude not found in incident.location object.");
            }


            function createPopupContent() {
                return `
                    <h3 class="font-semibold text-lg text-red-600">Incident Location</h3>
                `;
            }
        })();
    });
</script>
@endpush
