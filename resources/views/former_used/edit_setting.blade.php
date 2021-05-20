@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            {{-- <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>
            </div> --}}
            <form action="{{ url('/edit/' . $user->id) }}" method="POST">
                @csrf
                <div class="form-group row">
                  <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control-plaintext" id="nama" value="{{ $user->name }}" readonly name="nama">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="email" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control-plaintext" id="email" value="{{ $user->email }}" readonly name="email">
                  </div>                  
                </div>

                <div class="form-group row">
                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                        <select name="role" id="inputState" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <label for="role" class="col-sm-2 col-form-label">Permission</label>
                    <div class="col-sm-10">
                        <select name="permission[]" id="inputState" multiple class="form-control">
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div> --}}

                <button type="submit" class="btn btn-success w-100">Submit</button>
              </form>
        </div>
    </div>
</div>
@endsection
