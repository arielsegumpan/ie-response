<div>

    <!-- Card Blog -->
    @if($this->featuredPost)
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Grid -->
        <div class="grid sm:grid-cols-2 sm:items-center gap-8">
            <div class="sm:order-2">
                <div class="relative pt-[50%] sm:pt-[100%] rounded-lg">
<<<<<<< HEAD
                    <img class="size-full absolute top-0 start-0 object-cover rounded-[2rem] lg:h-[550px]" src="{{ asset(Storage::url($this->featuredPost->featured_img)) ?? 'https://via.placeholder.com/560x550' }}" alt="{{ $this->featuredPost->title }}">
=======
                    <img class="size-full absolute top-0 start-0 object-cover rounded-[2rem] lg:h-[550px]" src="{{ asset(Storage::url($this->featuredPost->featured_img)) ?? 'https://via.placeholder.com/560x550' }}" alt="Blog Image">
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
                </div>
            </div>

            <div class="sm:order-1">
                <p class="mb-5 inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-gray-100 text-gray-800 dark:bg-neutral-800 dark:text-neutral-200">
                    {{ $this->featuredPost->categories->first()->cat_name ?? 'Uncategorized' }}
                </p>

                <h2 class="text-2xl font-bold md:text-3xl lg:text-4xl lg:leading-tight xl:text-5xl xl:leading-tight text-gray-800 dark:text-neutral-200">
                    <a class="hover:text-red-600 focus:outline-hidden focus:text-red-600 dark:text-neutral-300 dark:hover:text-white dark:focus:text-white" href="{{ route('page.blog.show', $this->featuredPost->slug) }}">
                        {{ $this->featuredPost->title }}
                    </a>
                </h2>

                <!-- Avatar -->
                <div class="mt-6 sm:mt-10 flex items-center">
                    <div class="shrink-0">
                        <img class="size-10 sm:h-14 sm:w-14 rounded-full" src="{{ $this->featuredPost->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . $this->featuredPost->user->name . '&background=f44336&color=fff' }}" alt="{{ $this->featuredPost->user->name }}">
                    </div>

                    <div class="ms-3 sm:ms-4">
                        <p class="sm:mb-1 font-semibold text-gray-800 dark:text-neutral-200">
                            {{ $this->featuredPost->user->name ?? 'Unknown Author' }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-neutral-500">
                            {{ $this->featuredPost->author_role ?? 'Contributor' }}
                        </p>
                    </div>
                </div>

                <div class="mt-5">
                    <a class="inline-flex items-center gap-x-1.5 text-red-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-red-500" href="{{ route('page.blog.show', $this->featuredPost->slug) }}">
                        {{ __('Read more') }}
                        <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- End Card Blog -->


    <!-- Card Blog -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Grid -->
        <div class="grid lg:grid-cols-2 gap-6">
            @foreach ($this->blogs as $post)
                <!-- Card -->
                <a wire:key="blog-{{ $post->id }}" class="group relative block rounded-xl focus:outline-hidden" href="{{ route('page.blog.show', $post->slug) }}">

                    <div class="shrink-0 relative rounded-xl overflow-hidden w-full h-87.5 before:absolute before:inset-x-0 before:z-1 before:size-full before:bg-linear-to-t before:from-gray-900/70">
                        <img class="size-full absolute top-0 start-0 object-cover"
                            src="{{ asset(Storage::url($post->featured_img)) }}"
                            alt="{{ $post->title }}">
                    </div>

                    <div class="absolute top-0 inset-x-0 z-10">
                        <div class="p-4 flex flex-col h-full sm:p-6">
                            <!-- Avatar -->
                            <div class="flex items-center">
                                <div class="shrink-0">
                                    <img class="size-11 border-2 border-white rounded-full" src="{{ $post->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . $post->user->name . '&background=f44336&color=fff' }}" alt="{{ $post->user->name }}">
                                </div>
                                <div class="ms-2.5 sm:ms-4">
                                    <h4 class="font-semibold text-white">{{ $post->author }}</h4>
                                    <p class="text-xs text-white/80">{{ $post->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <!-- End Avatar -->
                        </div>
                    </div>

                    <div class="absolute bottom-0 inset-x-0 z-10">
                        <div class="flex flex-col h-full p-4 sm:p-6">
                            <h3 class="text-lg sm:text-3xl font-semibold text-white group-hover:text-white/80 group-focus:text-white/80">
                                {{ $post->title }}
                            </h3>
                            <p class="mt-2 text-white/80">
                                {{ $post->strip_content }}
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
    @if ($this->blogs->hasPages())
    <nav class="flex justify-between items-center gap-x-1 mt-6" aria-label="Pagination">
        {{-- Previous Page --}}
        <button
            wire:click="previousPage"
            wire:loading.attr="disabled"
            @class([
                'min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg',
                'text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10',
                'disabled:opacity-50 disabled:pointer-events-none' => !$this->blogs->onFirstPage()
            ])
            @disabled($this->blogs->onFirstPage())
            aria-label="Previous"
        >
            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M15 18L9 12l6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="hidden sm:block">Previous</span>
        </button>

        {{-- Page Numbers --}}
        <div class="flex items-center gap-x-1">
            @foreach ($this->blogs->getUrlRange(1, $this->blogs->lastPage()) as $page => $url)
                <button
                    wire:click="gotoPage({{ $page }})"
                    @class([
                        'min-h-9.5 min-w-9.5 flex justify-center items-center py-2 px-3 text-sm rounded-lg',
                        'text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10',
                        'bg-gray-200 dark:bg-neutral-600' => $page === $this->blogs->currentPage()
                    ])
                    aria-current="{{ $page === $this->blogs->currentPage() ? 'page' : 'false' }}"
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
                'disabled:opacity-50 disabled:pointer-events-none' => !$this->blogs->hasMorePages()
            ])
            @disabled(!$this->blogs->hasMorePages())
            aria-label="Next"
        >
            <span class="hidden sm:block">Next</span>
            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 6l6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </nav>
    @endif
    <!-- End Pagination -->

</div>
