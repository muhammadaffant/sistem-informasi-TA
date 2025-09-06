@extends('layouts.stisla')

@section('title', 'Detail Karyawan')

@section('content')
    <div class="section-header">
        <h1>Detail Karyawan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('karyawan.index') }}">Data Karyawan</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Data Karyawan</h4>
                        <div class="card-header-action">
                            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('karyawan.update', $karyawan->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="30%"><strong>NIP</strong></td>
                                                <td width="5%">:</td>
                                                <td>{{ $karyawan->nip }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama</strong></td>
                                                <td>:</td>
                                                <td>{{ $karyawan->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat</strong></td>
                                                <td>:</td>
                                                <td>{{ $karyawan->alamat }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="30%"><strong>Gaji Pokok</strong></td>
                                                <td width="5%">:</td>
                                                <td>{{ $karyawan->formatted_gaji_pokok }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tunjangan Kehadiran</strong></td>
                                                <td>:</td>
                                                <td>{{ $karyawan->formatted_tunjangan_kehadiran }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Utang</strong></td>
                                                <td>:</td>
                                                <td>{{ $karyawan->formatted_uang_lembur }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Gaji Bersih</strong></td>
                                                <td>:</td>
                                                <td class="text-success font-weight-bold">{{ $karyawan->formatted_gaji_bersih }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
