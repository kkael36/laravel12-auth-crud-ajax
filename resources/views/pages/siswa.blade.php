@extends('layouts.app')

@section('title', $title)

@push('style')
    <!-- CSS Libraries -->
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endpush

@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-right">
                        <a class="btn btn-primary btn-insert" href="javascript:void(0);">
                            <i class="ti ti-plus"></i>
                            Tambah
                        </a>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="example2" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6"></div>
                            <div class="col-sm-12 col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="list_data" class="table table-bordered table-vcenter  table-hover"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Jk</th>
                                            <th>Kelas_id</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="modal fade" id="modalForm">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Tambah</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="formDataModal">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label>NISN</label>
                                <input type="text" name="nisn" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jk" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <select name="kelas_id" class="form-control">
                                    <option value="">Pilih kelas</option>
                                    <option value="3">XI PPLG 3</option>
                                    <option value="2">XI PPLG 2</option>
                                    <option value="1">XI PPLG 1</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal" id="deleteModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah anda yakin?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="confirmDelete">
                    <div class="modal-body">
                        Data yang dihapus tidak dapat dikembalikan!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <script>
        // alert
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function alert_message(status, message) {
            Toast.fire({
                icon: status,
                title: message
            })
        };
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // DataTable initialization
            let table = $('#list_data').DataTable({
                order: [],
                fixedHeader: true,
                columnDefs: [
                    { className: 'text-center', targets: 0 },
                    { orderable: false, className: 'text-center', targets: 5 }
                ],
                pagingType: 'simple_numbers',
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": true,
                "responsive": true,
                "scrollX": true,
                ajax: {
                    url: "{{ $url_menu['url_json'] }}",
                    dataSrc: function(json) {
                        // DataTables expects array of arrays for data
                        return json.data;
                    }
                }
            });

            $('.btn-insert').on('click', function() {
                $('#formDataModal')[0].reset(); // Reset form
                $('#modalLabel').text('Tambah Siswa');
                $('#formDataModal').attr('action', "{{ $url_menu['url'] . '/tambah' }}");
                $('#formDataModal').attr('method', "POST");
                $('#formDataModal').find('.is-invalid').removeClass('is-invalid');
                $('#formDataModal').find('.invalid-feedback').text('');
                $('#modalForm').modal('show');
            });

            $('#list_data').on('click', '.btn-edit', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ $url_menu['url'] }}/show/" + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#formDataModal')[0].reset(); // Reset form
                        $('#modalLabel').text('Edit Siswa');
                        $('#formDataModal [name="nisn"]').val(response.data.nisn);
                        $('#formDataModal [name="nama"]').val(response.data.nama);
                        $('#formDataModal [name="jk"]').val(response.data.jk);
                        $('#formDataModal [name="kelas_id"]').val(response.data.kelas_id);
                        $('#formDataModal').attr('action', "{{ $url_menu['url'] }}/edit/" + id);
                        $('#formDataModal').attr('method', "PUT");
                        $('#formDataModal').find('.is-invalid').removeClass('is-invalid');
                        $('#formDataModal').find('.invalid-feedback').text('');
                        $('#modalForm').modal('show');
                    },
                    error: function(xhr) {
                        alert_message('error', xhr.statusText);
                    }
                });
            });

            $('#list_data').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                $('#confirmDelete').attr('action', "{{ $url_menu['url'] }}/hapus/" + id);
                $('#confirmDelete').attr('method', "DELETE");
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        table.ajax.reload();
                        alert_message('success', response.message);
                    },
                    error: function(xhr) {
                        alert_message('error', xhr.statusText);
                    }
                });
            });

            $('#formDataModal').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#modalForm').modal('hide');
                        table.ajax.reload();
                        alert_message('success', response.message);
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.message;
                        $('#modalForm').find('.is-invalid').removeClass('is-invalid');
                        $('#modalForm').find('.invalid-feedback').text('');

                        if (errors && typeof errors === 'object' && errors !== null && !Array.isArray(errors)) {
                            Object.entries(errors).forEach(([key, val]) => {
                                $('[name="' + key + '"]').addClass('is-invalid');
                                $('[name="' + key + '"]').next('.invalid-feedback').text(val[0]);
                            });
                        } else {
                            alert_message('error', xhr.statusText);
                        }
                    }
                });
            });

        })
    </script>
@endpush