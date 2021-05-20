<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SITA-FTEK | Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>SITA</b>FTEK</a>
    </div>
    <div class="card-body">


      <p class="login-box-msg">Registrasi Mahasiswa</p>

      <form action="{{ route('register') }}" method="POST">
        @csrf
        
    
        <div class="input-group mb-3">
          <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full name" required autocomplete="name" autofocus value="{{ old('name') }}" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
            @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>

        <div class="input-group mb-3">
          <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required autocomplete="email" value="{{ old('email') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
            @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="input-group mb-3">
          <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="new-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>

        <div class="input-group mb-3">
          <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Retype password" required autocomplete="new-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>


        <div class="row">
          
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="row mt-3">
        <div class="col-4">
          <a href="{{ route('login') }}" class="text-center">Login</a>
        </div>
      </div>
      
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
