@extends('template.main')
@section('title', 'Tambah User')
@section('content')

    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title"></h3>
        </div>

        <form action="{{ route('create') }}" method="POST">
          @csrf
          <div class="card-body">
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
                {{-- <select name="role" class="custom-select">
                  <option value="mahasiswa">Mahasiswa</option>
                  <option value="dosen">Dosen</option>
                </select> --}}
                  <select name="role" id="inputState" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{$role->name}}</option>
                    @endforeach
                </select>
                
              </div>
           
            {{-- <div class="form-group">
              <label for="konfirm_password">Password</label>
              <input name="password_confirmation" type="password" class="form-control" id="konfirm_password" placeholder="Masukkan Password Lagi" required>
            </div> --}}


             {{-- <div class="form-group">
              <label for="tambah_nim">NIM</label>
              <input type="text" class="form-control" id="tambah_nim" placeholder="Masukkan NIM">
            </div> --}}

            {{-- <div class="row">
              <div class="col-sm-6">
                <!-- select -->
                <div class="form-group">
                  <label>Pilih Role</label>
                  <select class="custom-select">
                    <option>Mahasiswa</option>
                    <option>Dosen</option>
                    
                  </select>
                </div>
              </div>
            </div>


            <div class="form-group row">
              <label for="role" class="col-sm-2 col-form-label">Role</label>
              <div class="col-sm-10">
                  <select name="role" id="inputState" class="form-control">
                      @foreach ($roles_all as $role)
                          <option value="{{ $role->id }}">{{ $role->name}}</option>
                      @endforeach
                  </select>
              </div>
          </div> --}}

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          
        </form>
    </div>
@endsection