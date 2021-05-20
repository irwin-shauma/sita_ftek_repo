@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            {{-- <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    

                </div>
            </div> --}}
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Daftar User
                </li>
            </ul>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()[0] }}</td>
                            <td>
                                <a href="{{ url('/edit/' . $user->id) }}" class="btn btn-sm btn-success"><i class="far fa-edit"></i></a>
                                <div class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></div>
                            </td>
                        </tr>
                    @endforeach
                 
                
                </tbody>
              </table>

        </div>
    </div>
</div>
@endsection
