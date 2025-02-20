<?php

use function Laravel\Folio\name;

name('settings.index');

?>
<x-app-layout>
    <x-slot name="title">Pengaturan Toko</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card overflow-hidden">
                <div class="card-header p-0">
                    <img src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/images/backgrounds/profilebg.jpg"
                        alt="matdash-img" class="img-fluid">
                </div>
                <div class="card-body">
                    @include('pages.owner.settings.profile')
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
