<?php

use App\Models\room;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use function Livewire\Volt\{state, rules, uses};
use function Laravel\Folio\name;

uses([LivewireAlert::class]);

name('rooms.create');

state(['room_number', 'price', 'availability']);

rules([
    'room_number' => 'required|string|max:1000',
    'price' => 'required|integer',
    'availability' => 'required|string|in:available,occupied',
]);

$create = function () {
    $validateData = $this->validate();

    room::create($validateData);

    $this->reset();

    $this->alert('success', 'Data berhasil ditambahkan!', [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
    ]);

    $this->redirectRoute('rooms.index', navigate: true);
};

?>

<x-app-layout>
    <x-slot name="title">Tambah Kamar Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Kamar</a></li>
        <li class="breadcrumb-item"><a href="#">Tambah Kamar</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="alert alert-primary" role="alert">
                        <strong>Tambah Kamar</strong>
                        <p>Pada halaman tambah Kamar, kamu dapat memasukkan informasi dari Kamar baru yang akan disimpan ke
                            sistem.
                        </p>
                    </div>
                </div>

                <div class="card-body">
                    <form wire:submit="create">
                        @csrf

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="room_number" class="form-label">Nomor Kamar</label>
                                    <input type="text" class="form-control @error('room_number') is-invalid @enderror"
                                        wire:model="room_number" id="room_number" aria-describedby="room_numberId"
                                        placeholder="Enter room number" autofocus autocomplete="room_number" />
                                    @error('room_number')
                                        <small id="room_numberId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga</label>
                                    <input type="text" class="form-control @error('price') is-invalid @enderror"
                                        wire:model="price" id="price" aria-describedby="priceId"
                                        placeholder="Enter room price" />
                                    @error('price')
                                        <small id="priceId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="availability" class="form-label">Status</label>
                            <select class="form-select" wire:model="availability" name="availability" id="availability">
                                <option selected>Select one</option>
                                <option value="available">Tersedia</option>
                                <option value="occupied">Terisi</option>
                            </select>
                            @error('availability')
                            <small id="priceId" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                        </div>



                        <div class="row mb-3">
                            <div class="col-md">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                            <div class="col-md align-self-center text-end">
                                <span wire:loading class="spinner-border spinner-border-sm"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
