@extends('layouts.app')
@section('title',$title)

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <form action="" method="post">
          @csrf
          <div class="card">
            <div class="card-header">
              {{ __('Link Baru') }}
            </div>

            <div class="card-body">
              @if ($errors->any())
                @foreach ($errors->all() as $key => $err)
                  <div class="alert alert-danger notif text-center font-weight-bold">{{ $err }}</div>
                @endforeach
              @endif
              <div class="form-group">
                <label for="name">Nama Link</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" autofocus>
              </div>
              <div class="form-group">
                <label for="shortlink">Short Link</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">{{ url('/') }}/</span>
                  </div>
                  <input type="text" name="shortlink" value="{{ old('shortlink') }}" class="form-control" placeholder="custom-link">
                </div>
              </div>
              <div class="form-group">
                <label for="destination">Link Tujuan</label>
                <textarea name="destination" rows="5" class="form-control">{{ old('destination') }}</textarea>
              </div>
              <div class="form-group">
                <label for="active">Status</label>
                <select class="form-control" name="active">
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">SIMPAN</button>
              <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
