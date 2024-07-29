@extends('layouts.app')

@section('content')
<div class="col-12 col-md-4 offset-md-4">
  <div class="card">
    <div class="card-header">
      {{ __('Pengaturan Akun') }}
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
      <form action="{{ route('profile.update') }}" method="post">
        @csrf
        <div class="form-group">
          <label for="name">Nama</label>
          <input type="text" class="form-control" name="name" id="name" value="{{ old('name')??$data->name }}" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" id="email" value="{{ old('email')??$data->email }}"
            required>
        </div>
        <div class="form-group">
          <label for="old_password">Password</label>
          <input type="password" class="form-control" name="old_password" id="old_password"
            placeholder="Masukkan Password Sekarang">
        </div>
        <div class="form-group">
          <label for="password">Password Baru</label>
          <input type="password" class="form-control" name="password" id="password"
            placeholder="Kosongkan jika tidak ingin mengubah password">
        </div>
        <div class="form-group">
          <label for="password_confirmation">Ulang Password Baru</label>
          <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
            placeholder="Kosongkan jika tidak ingin mengubah password">
        </div>
        <div class="form-group">
          <button type="submit" name="simpan" id="simpan" class="btn btn-primary btn-block">SIMPAN</button>
          <a class="btn btn-secondary btn-block" href="{{ route('home') }}">BATAL</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection