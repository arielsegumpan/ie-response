<?php

use App\Livewire\Pages\Blog;
use App\Livewire\Pages\About;
use App\Livewire\Pages\Isugid;
use App\Livewire\Pages\Contact;
use App\Livewire\Pages\BlogShow;
use App\Livewire\Pages\Incidents;
use App\Livewire\Pages\IndexPage;
use App\Livewire\Pages\Volunteer;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\BlogExtras\TagPosts;
use App\Livewire\Pages\BlogExtras\CategoryPosts;

Route::get('/', IndexPage::class)->name('page.home');
Route::get('/isugid', Isugid::class)->name('page.isugid');
Route::get('/blogs', Blog::class)->name('page.blog');
Route::get('/blogs/{slug}', BlogShow::class)->name('page.blog.show');
Route::get('/about', About::class)->name('page.about');
Route::get('/contact', Contact::class)->name('page.contact');
Route::get('/incidents/{incident_number}', Incidents::class)->name('page.incident.show');
Route::get('/category/{slug}', CategoryPosts::class)->name('page.blog.category');
Route::get('/tag/{slug}', TagPosts::class)->name('page.blog.tag');
Route::get('/respo', Volunteer::class)->name('page.responder');
