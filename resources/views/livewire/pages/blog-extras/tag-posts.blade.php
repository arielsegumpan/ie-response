<div>
    @push('meta')
        <title>{{ $tag->tag_name }}</title>
    @endpush

    <!-- Title -->
    <div class="max-w-2xl text-center mx-auto mb-10 lg:mb-8 mt-6 md:mt-8 lg:mt-14">
        <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">{{ $tag->tag_name }}</h2>
        <p class="mt-1 text-gray-600 dark:text-neutral-400">{{ $tag->tag_desc ?? '' }}</p>
    </div>
    <!-- End Title -->

    <!-- Card Blog -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Grid -->
        <div class="grid lg:grid-cols-2 gap-6">
            @foreach ($this->postsTags as $postsTag)
                <!-- Card -->
                <a wire:key="blog-{{ $postsTag->id }}" class="group relative block rounded-xl focus:outline-hidden" href="{{ route('page.blog.show', $postsTag->slug) }}">

                    <div class="shrink-0 relative rounded-xl overflow-hidden w-full h-87.5 before:absolute before:inset-x-0 before:z-1 before:size-full before:bg-linear-to-t before:from-gray-900/70">
                        <img class="size-full absolute top-0 start-0 object-cover"
                            src="{{ asset(Storage::url($postsTag->featured_img)) }}"
                            alt="{{ $postsTag->title }}">
                    </div>

                    <div class="absolute top-0 inset-x-0 z-10">
                        <div class="p-4 flex flex-col h-full sm:p-6">
                            <!-- Avatar -->
                            <div class="flex items-center">
                                <div class="shrink-0">
                                    <img class="size-11 border-2 border-white rounded-full" src="{{ $postsTag->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . $postsTag->user->name . '&background=f44336&color=fff' }}" alt="{{ $postsTag->user->name }}">
                                </div>
                                <div class="ms-2.5 sm:ms-4">
                                    <h4 class="font-semibold text-white">{{ $postsTag->author }}</h4>
                                    <p class="text-xs text-white/80">{{ $postsTag->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <!-- End Avatar -->
                        </div>
                    </div>

                    <div class="absolute bottom-0 inset-x-0 z-10">
                        <div class="flex flex-col h-full p-4 sm:p-6">
                            <h3 class="text-lg sm:text-3xl font-semibold text-white group-hover:text-white/80 group-focus:text-white/80">
                                {{ $postsTag->title }}
                            </h3>
                            <p class="mt-2 text-white/80">
                                {{ $postsTag->content }}
                            </p>
                        </div>
                    </div>
                </a>
                <!-- End Card -->
            @endforeach
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Card Blog -->

    <!-- Pagination -->
    @if ($this->postsTags->hasPages())
    <nav class="flex justify-between items-center gap-x-1 mt-6" aria-label="Pagination">
        {{-- Previous Page --}}
        <button
            wire:click="previousPage"
            wire:loading.attr="disabled"
            @class([
                'min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg',
                'text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10',
                'disabled:opacity-50 disabled:pointer-events-none' => !$postsTag->onFirstPage()
            ])
            @disabled($postsTag->onFirstPage())
            aria-label="Previous"
        >
            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M15 18L9 12l6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="hidden sm:block">{{__('Previous')}}</span>
        </button>

        {{-- Page Numbers --}}
        <div class="flex items-center gap-x-1">
            @foreach ($postsTag->getUrlRange(1, $postsTag->lastPage()) as $page => $url)
                <button
                    wire:click="gotoPage({{ $page }})"
                    @class([
                        'min-h-9.5 min-w-9.5 flex justify-center items-center py-2 px-3 text-sm rounded-lg',
                        'text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10',
                        'bg-gray-200 dark:bg-neutral-600' => $page === $postsTag->currentPage()
                    ])
                    aria-current="{{ $page === $postsTag->currentPage() ? 'page' : 'false' }}"
                >
                    {{ $page }}
                </button>
            @endforeach
        </div>

        {{-- Next Page --}}
        <button
            wire:click="nextPage"
            wire:loading.attr="disabled"
            @class([
                'min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg',
                'text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10',
                'disabled:opacity-50 disabled:pointer-events-none' => !$postsTag->hasMorePages()
            ])
            @disabled(!$postsTag->hasMorePages())
            aria-label="Next"
        >
            <span class="hidden sm:block">{{ __('Next') }}</span>
            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 6l6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </nav>
    @endif
    <!-- End Pagination -->
</div>
