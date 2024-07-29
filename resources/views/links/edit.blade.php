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
              <input type="text" name="name" value="{{ old('name')??$data->name }}" class="form-control" autofocus>
            </div>
            <div class="form-group">
              <label for="shortlink">Short Link</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">{{ url('/') }}/</span>
                </div>
                <input type="text" name="shortlink" value="{{ old('shortlink')??$data->sl }}" class="form-control"
                  placeholder="random">
              </div>
              <div class="form-check mt-1">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="case_sensitive" id="case_sensitive" value="1"
                    {{ old('case_sensitive') ? 'checked' : ($data->cs ? 'checked' : '') }}>
                  Case Sensitive
                </label>
              </div>
              <p class="m-0 text-danger" style="font-size: 0.8rem"><em>(Jika aktif, besar-kecil huruf akan dianggap link
                  yang berbeda.)</em></p>
            </div>
            <div class="form-group">
              <label for="destination">Link Tujuan</label>
              <textarea name="destination" rows="5"
                class="form-control">{{ old('destination')??$data->destination }}</textarea>
            </div>
            <div class="form-group">
              <label for="active">Status</label>
              <select class="form-control" name="active">
                <option {{ $data->act==1?'selected':'' }} value="1">Aktif</option>
                <option {{ $data->act==0?'selected':'' }} value="0">Tidak Aktif</option>
              </select>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('home') }}" class="btn btn-danger">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection