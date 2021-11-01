@extends('layouts.app')

@push('css')
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush
@section('title')
    ADMIN LAYANAN
@endsection
@section('content')
<br/>
<div class="row">
    <div class="col-12">
        <a href="/superadmin/admin/create" class="btn btn-sm bg-gradient-purple"><i class="fas fa-plus"></i> Tambah</a>
        <br/><br/>
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Admin Layanan</h3>
            <div class="card-tools">
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-sm">
            <thead>
                <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
                </tr>
            </thead>
            @php
                $no =1;
            @endphp
            <tbody>
            @foreach ($data as $key => $item)
                    <tr style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
                    <td>{{$no++}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->username}}</td>
                    <td>{{$item->roles->first()->name}}</td>
                    <td>
                        
                    <form action="/superadmin/admin/{{$item->id}}" method="post">
                        <a href="/superadmin/admin/{{$item->id}}/edit" class="btn btn-xs btn-success"><i class="fas fa-edit"></i> Edit</a>
                        @csrf
                        @method('delete')
                        {{-- <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('yakin Di Hapus?');"><i class="fas fa-trash"></i> Delete</button>      --}}
                    </form>

                    </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        </div>
        {{$data->links()}}
    </div>
</div>

@endsection

@push('js')
@endpush