@extends('layouts.template')

@section('content')
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
                <h4 class="page-title">Halaman Statistik</h4>
            </div>

            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                    </ol>
                    <form id="updateForm">
                        <button type="button" id="updateButton" name="updateButton"
                            class="btn btn-primary d-none d-md-block pull-right ms-3 hidden-xs hidden-sm waves-effect waves-light text-white">Update
                            semua data
                            <span class="spinner-border text-primary spinner-border-sm d-none" id="loading"
                                role="status" aria-hidden="true"></span></button>
                    </form>
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
        <div class="row justify-content-center">
            <div id="alertMsg"></div>
            <div class="col-lg-4 col-md-12">

                <div class="white-box analytics-info">
                    <h3 class="box-title">Jumlah pasien yang dicek</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        <li>
                            <div id="sparklinedash"><canvas width="67" height="30"
                                    style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                            </div>
                        </li>
                        <li class="ms-auto"><span class="counter text-success">{{ $count }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Jumlah pasien aktif</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        <li>
                            <div id="sparklinedash2"><canvas width="67" height="30"
                                    style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                            </div>
                        </li>
                        <li class="ms-auto"><span class="counter text-purple">{{ $active }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Jumlah pasien nonaktif</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        <li>
                            <div id="sparklinedash3"><canvas width="67" height="30"
                                    style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                            </div>
                        </li>
                        <li class="ms-auto"><span class="counter text-info">{{ $nonactive }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    @endsection

    @push('update')
    <script>
        $(document).ready(function () {
            $('#updateButton').click(function () {
                $.ajax({
                    method: "POST",
                    url: "/updateAll",
                    data: "_token={{ csrf_token() }}",
                    dataType: "JSON",
                    beforeSend: function () {
                        $('#loading').removeClass('d-none');
                        $('#updateButton').attr('disabled', true);
                    },
                    success: function (data) {
                        if(data.success) {
                            $('#alertMsg').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Berhasil update data
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`);
                        } else {
                            $('#alertMsg').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Gagal
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`);
                        }
                        $('#loading').addClass('d-none');
                        $('#updateButton').attr('disabled', false);
                    }
                })
            })
        });

    </script>
    @endpush