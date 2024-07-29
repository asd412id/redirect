@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          {{ __('Daftar Link') }}
          <span class="float-right">
            <a href="{{ route('link.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Link
              Baru</a>
          </span>
        </div>

        <div class="card-body">
          @if ($errors->any())
          @foreach ($errors->all() as $key => $err)
          <div class="alert alert-danger notif text-center font-weight-bold">{{ $err }}</div>
          @endforeach
          @endif
          @if (session('status'))
          <div class="alert notif alert-success text-center font-weight-bold" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <table class="table table-stripped" id="link-table">
            <thead>
              <th>No</th>
              <th>Nama Link</th>
              <th>Short Link</th>
              <th>Case Sensitive</th>
              <th>Link Tujuan</th>
              <th>Status</th>
              <th>Hits</th>
              <th>Waktu</th>
              <th>Aksi</th>
            </thead>
            <tbody></tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection