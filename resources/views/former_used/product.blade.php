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
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Tambah Produk
                  <a href="" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></a>
                </li>
            </ul>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Kuaci</td>
                    <td>Rp. 5000</td>
                    <td>
                        <div class="btn btn-sm btn-success"><i class="far fa-edit"></i></div>
                        @can('setting')
                          <div class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></div>  
                        @endcan
                        
                    </td>
                  </tr>
                
                </tbody>
              </table>

        </div>
    </div>
</div>
@endsection
