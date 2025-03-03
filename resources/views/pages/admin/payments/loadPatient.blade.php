<div class="row">
    <h6 class="fw-bolder">Biodata</h6>
    <div class="col-md">
        <p><strong>Nama Pasien:</strong>
            <br>
            {{ $medicalRecord->patient->name }}
        </p>
        <p><strong>Nomor Rekam Medis:</strong>
            <br>
            {{ $medicalRecord->id }}
        </p>
        <p><strong>Jenis Kelamin:</strong>
            <br>
            {{ $medicalRecord->patient->gender }}
        </p>
    </div>
    <div class="col-md text-md-end">
        <p><strong>Tanggal Lahir:</strong>
            <br>

            {{ \Carbon\Carbon::parse($medicalRecord->patient->dob)->format('d M Y') }}
        </p>
        <p><strong>Alamat:</strong>
            <br>
            {{ $medicalRecord->patient->address }}
        </p>
        <p><strong>Telepon:</strong>
            <br>
            {{ $medicalRecord->patient->phone }}
        </p>
    </div>
</div>
<hr>
<div class="row">
    <h6 class="fw-bolder mb-3">Rekam Medis</h6>
    <div class="col-md">
        <p><strong>Keluhan:</strong>
            <br>
            {{ $medicalRecord->complaint }}
        </p>
        <p><strong>Diagnosis:</strong>
            <br>
            {{ $medicalRecord->diagnosis }}
        </p>
        <p><strong>Pemeriksaan Fisik:</strong>
            <br>
            {{ $medicalRecord->physical_exam }}
        </p>
        <p><strong>Rekomendasi:</strong>
            <br>
            {{ $medicalRecord->recommendation }}
        </p>

    </div>
    <div class="col-md text-md-end">
        <p><strong>Jenis Rawat:</strong>
            <br>
            {{ __('status.' . $medicalRecord->type) }}
        </p>
        <p><strong>Status:</strong>
            <br>
            {{ __('status.' . $medicalRecord->status) }}
        </p>
        <p><strong>Tanggal Dibuat:</strong>
            <br>
            {{ \Carbon\Carbon::parse($medicalRecord->created_at)->format('d M Y H:i') }}
        </p>
    </div>
</div>

<div class="col-12">
    <span class="fw-medium text-heading">Note:</span>
    <span>{{ $medicalRecord->note ?? '-' }}</span>
</div>
