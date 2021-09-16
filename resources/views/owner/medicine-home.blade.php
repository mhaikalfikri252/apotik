<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table table-stripped" id="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Dosis</th>
                            <th>Indikasi</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <button type="button" class="btn btn-info" id="btn-add" data-toggle="modal" data-target="#modal-info">
            Tambah
        </button>
        <!-- /.modal -->

        <div class="modal fade" id="modal-info">
            <div class="modal-dialog">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">Info Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- form isian --}}
                        <form action="{{ route('supplier.store') }}" method="post" id="forms">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputFile">Nama Supplier</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nama Supplier">
                                <input type="text" hidden class="form-control" id="id" name="id" placeholder="Id">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Telpon</label>
                                <input type="text" class="form-control" maxlength="12" id="phone" name="phone"
                                    placeholder="Telpon" onkeypress="return number(event)">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">No. Rekening</label>
                                <input type="text" class="form-control" id="account_number" name="account_number"
                                    placeholder="No. Rekening" onkeypress="return number(event)">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Alamat</label>
                                <textarea name="address" id="address" cols="30" rows="10"
                                    class="form-control"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" name="cancel" id="btn-cancel" class="btn btn-outline-light"
                            data-dismiss="modal">Close</button>
                        <button type="submit" id="save" class="btn btn-outline-light">Save</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</x-app-layout>
@stack('js')
<script src={{asset("plugins/datatables/jquery.dataTables.js") }}></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function () {
        loaddata()
    })

    function loaddata() {
        $('#table').DataTable({
            serverside: true,
            processing: true,
            language: {
                url: "{{ asset('js/bahasa.json') }}"
            },
            ajax: {
                url: "{{ route('supplier.index') }}"
            },
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'dose',
                    name: 'dose'
                },
                {
                    data: 'indication',
                    name: 'indication'
                },
                {
                    data: 'category_id',
                    name: 'category_id'
                },
                {
                    data: 'unit_id',
                    name: 'unit_id'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ]
        })
    }

    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $(document).on('submit', 'form', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            typeData: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (res) {
                console.log(res);
                $('#btn-cancel').click()
                $('#table').DataTable().ajax.reload()
                // alert(res.text)
                toastr.success(res.text, 'Berhasil')
            },
            error: function (xhr) {
                // console.log(xhr);
                toastr.error(xhr.responseJSON.text, 'Gagal!')
            }
        })
    })

    $(document).on('click', '.edit', function () {
        $('#forms').attr('action', "{{ route('supplier.update') }}")
        let id = $(this).attr('id')
        $.ajax({
            url: "{{ route('supplier.edit') }}",
            type: "post",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function (res) {
                console.log(res);
                $('#id').val(res.id)
                $('#name').val(res.name)
                $('#phone').val(res.phone)
                $('#email').val(res.email)
                $('#account_number').val(res.account_number)
                $('#address').val(res.address)
                $('#btn-add').click()
            },
            error: function (xhr) {
                console.log(xhr);
            }
        })
    })

    $(document).on('click', '.delete', function () {
        let id = $(this).attr('id')

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('supplier.delete') }}",
                    type: 'post',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res, status) {
                        if (status = '200') {
                            setTimeout(() => {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Data Berhasil Dihapus',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((res) => {
                                    $('#table').DataTable().ajax.reload()
                                })
                            });
                        }
                    },
                    error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Data Gagal Dihapus!',
                            })
                    }
                })
            }
        })
    })
</script>
