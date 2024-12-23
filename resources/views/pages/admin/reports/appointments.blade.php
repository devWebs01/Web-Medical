<?php

use App\Models\Appointment;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed, state, usesPagination, uses};

uses([LivewireAlert::class]);

name('reports.appointments');

state([
    'appointments' => fn () => Appointment::query()->latest()->get(),
]);
?>

<x-app-layout>
    <div>
        @include('layouts.table-print')

        <x-slot name="title">Data Antrian Pasien</x-slot>
        <x-slot name="header">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Antrian Pasien</a></li>
        </x-slot>

        @volt
            <div>
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-center text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Dokter</th>
                                        <th>Pasien</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $no => $appointment)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>{{ $appointment->doctor->name }}</td>
                                            <td>{{ $appointment->patient->name }}</td>
                                            <td>
                                                <span
                                                    class="badge p-2 bg-primary">{{ __('status.' . $appointment->status) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endvolt

    </div>
</x-app-layout>
