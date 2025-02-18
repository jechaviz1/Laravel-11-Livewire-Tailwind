<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Invoices;

Route::get('invoices', Invoices::class);
Route::redirect('/', '/invoices');


