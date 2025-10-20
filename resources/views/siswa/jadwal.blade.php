@extends('layout2.app')
@section('konten')

<style>
    .container-fluid {
        background-color: white;

    }

    h1 {
        font-family: Times, sans-serif;
        margin-left: 60px;
        margin-top:  20px
    }

    .content {
        margin-left: 60px;

    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>JADWAL MATA PELAJARAN</h1>
            <div class="content">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('siswa.index')}}">Home</a></li>
                    <li class="breadcrumb-item"><span class="no-link">My courses</span></li>
                    <li class="breadcrumb-item"><a href="#" >JADWAL MATA PELAJARAN</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
    <br>
        <div class="card">
          <div class="card-header">
            <span class="h5 my-2"><i class="fa-solid fa-list"></i> Jadwal Mengajar Kelas </span>
          </div>
          <div class="card-body">
            <table class="table table-hover" id="datatablesSimple">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Kategori</th>
                  <th scope="col">Jadwal Kelas</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
    @endsection
