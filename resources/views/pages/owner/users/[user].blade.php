<?php

use App\Models\User;
use function Livewire\Volt\{state, rules, uses};
use Illuminate\Validation\Rule;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

name('users.edit');

state([
    'name' => fn() => $this->user->name,
    'email' => fn() => $this->user->email,
    'telp' => fn() => $this->user->telp,
    'role' => fn() => $this->user->role,
    'password',
    'user', 
]);

$edit = function () {
    $user = $this->user;

    $validateData = $this->validate([
        'name' => 'required|min:5',
        'email' => 'required|min:5|' . Rule::unique(User::class)->ignore($user->id),
        'password' => 'min:5|nullable',
        'telp' => 'required|digits_between:11,12|' . Rule::unique(User::class)->ignore($user->id),
        'role' => 'required|in:admin,doctor,owner',
    ]);

    $user = $this->user;

    // Jika wire:model password terisi, lakukan update password
    if (!empty($this->password)) {
        $validateData['password'] = bcrypt($this->password);
    } else {
        // Jika wire:model password tidak terisi, gunakan password yang lama
        $validateData['password'] = $user->password;
    }
    $user->update($validateData);

    $this->alert('success', 'Data klinik berhasil diedit!', [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
    ]);

    $this->redirectRoute('users.index', navigate: true);
};

?>

<x-app-layout>
    <x-slot name="title">Tambah Pengguna Baru</x-slot>

    @volt
        <div>
            <x-slot name="header">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
                <li class="breadcrumb-item"><a href="#">Edit {{ $user->name }}</a></li>
            </x-slot>

            <div class="card">
                <div class="card-header">
                    <div class="alert alert-primary" role="alert">
                        <strong>Edit Admin</strong>
                        <p>Pada halaman edit pengguna, kamu dapat mengubah informasi pengguna yang sudah ada, termasuk peran
                            pengguna. Ini memungkinkan kamu untuk memperbarui akses dan izin pengguna sesuai kebutuhan.
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit="edit">
                        @csrf
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        wire:model="name" id="name" aria-describedby="nameId"
                                        placeholder="Enter admin name" autofocus autocomplete="name" />
                                    @error('name')
                                        <small id="nameId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        wire:model="email" id="email" aria-describedby="emailId"
                                        placeholder="Enter admin email" />
                                    @error('email')
                                        <small id="emailId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="telp" class="form-label">Telpon</label>
                                    <input type="number" class="form-control @error('telp') is-invalid @enderror"
                                        wire:model="telp" id="telp" aria-describedby="telpId"
                                        placeholder="Enter admin telp" />
                                    @error('telp')
                                        <small id="telpId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        wire:model="password" id="password" aria-describedby="passwordId"
                                        placeholder="Enter admin password" />
                                    @error('password')
                                        <small id="passwordId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" wire:model='role' name="role" id="role">
                                <option selected>Select one</option>
                                <option value="admin">Admin</option>
                                <option value="doctor">Dokter</option>
                                <option value="owner">Pemilik</option>
                            </select>
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
