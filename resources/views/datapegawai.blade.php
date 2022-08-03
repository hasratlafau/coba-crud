@extends('layout.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Data Pegawai</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    </div>

    <div class="container ml-4">
    <a href="/tambahpegawai"  type="button" class="btn btn-success">Tambah +</a>

    {{-- //ambil session halaman yang sedang aktif --}}
    {{-- {{ Session::get('halaman_akhir') }} --}}
            
    <div class="row g-3 align-items-center mt-2">
        <div class="col-auto">
            <form action="/pegawai" method="GET">
                <input type="search" id="inputPassword6" name="search" class="form-control" aria-describedby="passwordHelpInline" placeholder="Search...">
            </form>
        </div>
        <div class="col-auto">
            <a href="/exportpdf" class="btn btn-info">Export PDF</a>
        </div>     
        <div class="col-auto">
            <a href="/exportexcel" class="btn btn-success">Export Excel</a>
        </div>

        <div class="col-auto">
                    <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Import Data
            </button>
        </div>

                            
                
    
    <!-- Modal Import Data -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/importexcel" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" name="file" required>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </form>
        </div>
    </div>            


    </div>

    <div class="row mb-4 mt-3">
        {{-- @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
        @endif --}}
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Nama</th>
                <th scope="col">Foto</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">No Telp</th>
                <th scope="col">dibuat</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            {{-- @php
                $no = 1;
            @endphp     --}}

            @foreach($data as $index => $row)
            <tr>
                <td scope="row">{{ $index + $data->firstItem() }}</td>
                <td>{{ $row->nama }}</td>
                <td>
                    <img src="{{ asset('fotopegawai/'.$row->foto) }}" alt="" style="width:30px;">
                </td>                      
                <td>{{ $row->jenkel }}</td>
                <td>0{{ $row->notlp }}</td>
                <td>{{ $row->created_at->format('D M Y') }}</td>
                <td>
                    <a href="/tampildata/{{ $row->id }}"  class="btn btn-info">Edit</a>
                    <a href="#" class="btn btn-danger delete" data-nama="{{ $row->nama }}" data-id="{{ $row->id }}">Delete</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
</div>

</div>


@endsection

@push('scripts')
    
{{-- sweetAlert --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
{{-- //jQueryCDN --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

{{-- //toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- script modal bootstraps --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</body>    
<script>

$('.delete').click( function(){
var pegawaiid = $(this).attr('data-id');
var nama = $(this).attr('data-nama');
swal({
title: "Yakin?",
text: "Anda akan menghapus data dengan nama "+nama+" ",
icon: "warning",
buttons: true,
dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {
    window.location = "/delete/"+pegawaiid+""
    swal("Data berhasil dihapus!", {
    icon: "success",
    });
} else {
    swal("Data tidak jadi dihapus!");
}
});


});
</script>

<script>
@if(Session::has('success'))
toastr.success("{{ Session::get('success') }}");
@endif
</script>

@endpush