@extends('template.main')
@section('title', 'Tambah User')
@section('content')

    <form action="{{ route('create') }}" method="POST">
      @csrf
        <div class="form-group">
          <label for="tambah_nama">Nama</label>
          <input name="name" type="text" class="form-control  @error('name') is-invalid @enderror" id="tambah_nama" placeholder="Masukkan Nama" required>
          @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="tambah_nim">Nim/Nip</label>
          <input name="nim" type="text" class="form-control  @error('nim') is-invalid @enderror" id="tambah_nim" placeholder="Masukkan Nim" required>
          @error('nim')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="tambah_email">Email</label>
          <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="tambah_email" placeholder="Masukkan email" required>
          @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="tambah_password">Password</label>
          <input name="password" type="password" class="form-control  @error('password') is-invalid @enderror" id="tambah_password" placeholder="Masukkan Password" required>
          @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label>Pilih Role</label>
          <select name="role" id="inputState" class="form-control">
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{$role->name}}</option>
            @endforeach
          </select>
        </div>
        
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection