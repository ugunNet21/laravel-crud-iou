// resources/views/pendaftaran/datatables.blade.php

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Data Pendaftaran</h1>

        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">Tambah Pendaftaran Baru</a>
            </div>
        </div>

        <table class="table table-bordered" id="pendaftaran-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#pendaftaran-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("pendaftaran.index") }}',
                columns: [
                    {data: 'nama', name: 'nama'},
                    {data: 'telepon', name: 'telepon'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush
