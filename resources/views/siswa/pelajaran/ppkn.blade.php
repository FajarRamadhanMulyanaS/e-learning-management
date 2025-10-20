@extends('siswa.layout.app')
@section('konten')
    <style>
        .container-fluid {
            background-color: white;

        }

        h1 ,h2{
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
                <h1>PENDIDIKAN PANCASILA DAN KEWARGANEGARAAN</h1>
                <div class="content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('siswa.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><span class="no-link">My courses</span></li>
                        <li class="breadcrumb-item"><a href="#" >PENDIDIKAN PANCASILA DAN KEWARGANEGARAAN</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>TUGAS </h2>
                <div class="content">

                </div>
            </div>
        </div>
    </div>

    @endsection
