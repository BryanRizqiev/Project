@extends('layouts.template')

@section('content')

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/insert" method="POST">
                    @csrf
                    <input type="hidden" id="namaModal" name="nama">
                    <input type="hidden" id="tglLahirModal" name="tanggal_lahir">
                    <input type="hidden" id="noBpjsModal" name="no_bpjs">
                    <input type="hidden" id="ketAktifModal" name="status_bpjs">
                    <input type="hidden" id="noKtpModal" name="no_ktp">
                    <input type="hidden" id="namaProviderModal" name="nama_provider">
                    <div class="form-group mt-3">
                        <input type="text" class="form-control" name="no_rekam_medis" placeholder="No Rekam Medis"
                            required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Aplikasi Rekam Medis BPJS</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal"></a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card white-box p-0">
                    <div class="card-body">
                        <h3 class="box-title">Get Data BPJS</h3>
                        <div id="msgError"></div>
                        <form id="getDataForm" class="form-inline">
                            <div class="input-group">
                                <input type="text" name="no_bpjs" id="no_bpjs" class="form-control"
                                    placeholder="No BPJS">
                                {{-- <input type="text" class="form-control" placeholder="No Rekam Medis"> --}}
                                <button type="button" name="getDataButton" id="getDataButton"
                                    class="btn btn-primary">Get
                                    Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Recent Comments -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- .col -->
            <div class="col-lg-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableData" name="tableData">

                            <tr>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- .col -->
            <div class="col-lg-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <div class="col-md-4 mb-4 d-flex">
                            <form action="/" method="GET" class="d-flex">
                            <input type="text" class="form-control" placeholder="Cari nama..." name="search">
                            <input type="text" class="form-control" placeholder="Cari no_rm..." name="search_rm">
                            <button type="submit" class="btn btn-info ms-2 text-white">Cari</button>
                            </form>
                            <a href="/" class="btn btn-success ms-1 text-white">Reload</a>
                        </div>
                        <table class="table table-striped" name="tableData">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Tanggal lahir</th>
                                <th>No. BPJS</th>
                                <th>Status peserta bpjs</th>
                                <th>No. Ktp</th>
                                <th>Provider</th>
                                <th>No rekam medis</th>
                                <th>Aksi</th>
                            </tr>
                            @foreach ($datas as $data)
                            <tr>
                                <td>{{ ($datas->currentpage()-1) * $datas->perpage() + $loop->index + 1 }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->tanggal_lahir }}</td>
                                <td>{{ $data->no_bpjs }}</td>
                                <td>{{ $data->status_bpjs }}</td>
                                <td>{{ $data->no_ktp }}</td>
                                <td>{{ $data->nama_provider }}</td>
                                <td>{{ $data->no_rekam_medis }}</td>
                                <td>
                                    <form action="/destroy/{{ $data->id }}" method="post"
                                        onsubmit=" return confirm('Apakah anda yakin?') ">
                                        <button class="btn btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    @endsection

    @push('custom-script')
    <script>
        $(document).ready(function () {
            $('#getDataButton').click(function () {
                $('#tableData tr').html('');
                const id = $('#no_bpjs').val();
                $.ajax({
                    method: "GET",
                    url: "/api/bpjs/" + id,
                    dataType: "json",
                    beforeSend: function () {
                        if (id == '') {
                            $('#msgError').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Terjadi kesalahan! Pastikan form terisi
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`);
                        }
                    },
                    success: function (data) {
                        if (data.metaData.code !== 200) {
                            $('#msgError').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Terjadi kesalahan! Pastikan nomor BPJS anda benar
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`);
                        } else {
                            $('#namaModal').val(data.response.nama);
                            $('#tglLahirModal').val(data.response.tglLahir);
                            $('#noBpjsModal').val(data.response.noKartu);
                            $('#ketAktifModal').val(data.response.ketAktif);
                            $('#noKtpModal').val(data.response.noKTP);
                            $('#namaProviderModal').val(data.response.kdProviderPst
                                .nmProvider);
                            $('#tableData tr:last').after(`
                            <tr>
                                <th></th>
                                <th>${data.response.nama}</th>
                                <th>${data.response.tglLahir}</th>
                                <th>${data.response.ketAktif}</th>
                                <th>${data.response.noKTP}</th>
                                <th>${data.response.kdProviderPst.nmProvider}</th>
                                <th><button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Masukkan no. Rekam medis</button></th>
                            </tr>
                            `);
                            $('#msgError').empty();
                            $('#getDataForm')[0].reset();
                        }
                    }
                })
            });
        });
    </script>
    @endpush