<?php

use App\Models\model;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed, state, usesPagination, uses};

uses([LivewireAlert::class]);

name('models.index');

state(['search'])->url();
usesPagination(theme: 'bootstrap');

$models = computed(function () {
    if ($this->search == null) {
        return model::query()->latest()->paginate(10);
    } else {
        return model::query()
            ->where(function ($query) {
                // isi
                $query->whereAny([' '], 'LIKE', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);
    }
});

$destroy = function (model $model) {
    try {
        $model->delete();
        $this->alert('success', 'Data model berhasil dihapus!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    } catch (\Throwable $th) {
        $this->alert('error', 'Data model gagal dihapus!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
};

?>

<x-app-layout>
    <div>
        <x-slot name="title">model</x-slot>
        <x-slot name="header">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('models.index') }}">model</a></li>
        </x-slot>

        @volt
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('models.create') }}" class="btn btn-primary">Tambah
                                    model</a>
                            </div>
                            <div class="col">
                                <input wire:model.live="search" type="search" class="form-control" name=""
                                    id="search" aria-describedby="helpId" placeholder="Masukkan nama pengguna" />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive border rounded px-3">
                            <table class="table text-center text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telp</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->models as $no => $model)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>{{ $model->name }}</td>
                                            <td>{{ $model->email }}</td>
                                            <td>{{ $model->telp }}</td>
                                            <td>
                                                <div class="">
                                                    <a href="{{ route('models.edit', ['model' => $model->id]) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <button wire:loading.attr='disabled'
                                                        wire:click='destroy({{ $model->id }})'
                                                        wire:confirm="Apakah kamu yakin ingin menghapus data ini?"
                                                        class="btn btn-sm btn-danger">
                                                        {{ __('Hapus') }}
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            {{ $this->models->links() }}
                        </div>

                    </div>
                </div>
            </div>
        @endvolt

    </div>
</x-app-layout>