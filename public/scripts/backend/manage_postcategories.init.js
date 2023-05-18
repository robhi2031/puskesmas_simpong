"use strict";
//Class Definition
var save_method;
var table;
//Load Datatables Categories
const _loadDtCategories = () => {
    table = $('#dt-categories').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url+ 'api/manage_postcategories/show',
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
        },
        destroy: true,
        draw: true,
        deferRender: true,
        responsive: false,
        autoWidth: false,
        LengthChange: true,
        paginate: true,
        pageResize: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', width: "5%", className: "align-top text-center border px-2", searchable: false },
            { data: 'name', name: 'name', width: "55%", className: "align-top border px-2" },
            { data: 'count_post', name: 'count_post', width: "20%", className: "align-top text-center border px-2", searchable: false },
            { data: 'is_public', name: 'is_public', width: "5%", className: "align-top text-center border px-2", searchable: false },
            { data: 'action', name: 'action', width: "15%", className: "align-top text-center border px-2", orderable: false, searchable: false },
        ],
        oLanguage: {
            sEmptyTable: "Tidak ada Data yang dapat ditampilkan..",
            sInfo: "Menampilkan _START_ s/d _END_ dari _TOTAL_",
            sInfoEmpty: "Menampilkan 0 - 0 dari 0 entri.",
            sInfoFiltered: "",
            sProcessing: `<div class="d-flex justify-content-center align-items-center"><span class="spinner-border align-middle me-3"></span> Mohon Tunggu...</div>`,
            sZeroRecords: "Tidak ada Data yang dapat ditampilkan..",
            sLengthMenu: `<select class="mb-2 show-tick form-select-solid" data-width="fit" data-style="btn-sm btn-secondary" data-container="body">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
                <option value="-1">Semua</option>
            </select>`,
            oPaginate: {
                sPrevious: "Sebelumnya",
                sNext: "Selanjutnya",
            },
        },
        //"dom": "<'row'<'col-sm-6 d-flex align-items-center justify-conten-start'l><'col-sm-6 d-flex align-items-center justify-content-end'f>><'table-responsive'tr><'row'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>",
        fnDrawCallback: function (settings, display) {
            $('[data-bs-toggle="tooltip"]').tooltip("dispose"), $(".tooltip").hide();
            //Search Table
            $("#search-dtCategories").on("keyup", function () {
                table.search(this.value).draw();
                if ($(this).val().length > 0) {
                    $("#clear-searchDtCategories").show();
                } else {
                    $("#clear-searchDtCategories").hide();
                }
            });
            //Clear Search Table
            $("#clear-searchDtCategories").on("click", function () {
                $("#search-dtCategories").val(""),
                table.search("").draw(),
                $("#clear-searchDtCategories").hide();
            });
            //Custom Table
            $("#dt-categories_length select").selectpicker(),
            $('[data-bs-toggle="tooltip"]').tooltip({ 
                trigger: "hover"
            }).on("click", function () {
                $(this).tooltip("hide");
            });
        },
    });
    $("#dt-categories").css("width", "100%"),
    $("#search-dtCategories").val(""),
    $("#clear-searchDtCategories").hide();
}
//Close Content Card by Open Method
const _closeCard = (card) => {
    if(card=='form_category') {
        save_method = '';
        _clearFormCategory(), $('#card-formCategory .card-header .card-title').html('');
    }
    $('#card-formCategory').hide(), $('#card-dtCategories').show();
}
//Clear Form Category
const _clearFormCategory = () => {
    $("#form-category")[0].reset();
    if (save_method == "" || save_method == "add_category") {
        $('[name="id"]').val(""), $('#iGroup-isPublic').hide();
    } else {
        let idp = $('[name="id"]').val();
        _editCategory(idp);
    }
}
//Add Category
const _addCategory = () => {
    save_method = "add_category";
    _clearFormCategory(),
    $("#card-formCategory .card-header .card-title").html(
        `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-window-plus fs-2 text-gray-900 me-2"></i>Form Tambah Kategori Postingan</h3>`
    ),
    $("#card-dtCategories").hide(), $("#card-formCategory").show();
}
//Edit Category
const _editCategory = (idp) => {
    save_method = "update_category";
    $('#form-category')[0].reset(), $('#iGroup-isPublic').show();
    let target = document.querySelector("#card-formCategory"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    //Ajax load from ajax
    $.ajax({
        url: base_url+ 'api/manage_postcategories/show',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: 'GET',
        dataType: 'JSON',
        data: {
            idp,
        },
        success: function (data) {
            blockUi.release(), blockUi.destroy();
            if (data.status == true) {
                $('[name="id"]').val(data.row.id), $('#name').val(data.row.name);
                //is Public
                if (data.row.is_public == 'Y') {
                    $('#is_public').prop('checked', true),
                    $('#iGroup-isPublic .form-check-label').text('AKTIF');
                } else {
                    $('#is_public').prop('checked', false),
                    $('#iGroup-isPublic .form-check-label').text('TIDAK AKTIF');
                }
                $("#card-formCategory .card-header .card-title").html(
                    `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-pencil-square fs-2 text-gray-900 me-2"></i>Form Edit Kategori Postingan</h3>`
                ),
                $("#card-dtCategories").hide(), $("#card-formCategory").show();
            } else {
                Swal.fire({title: "Ooops!", text: data.message, icon: "warning", allowOutsideClick: false});
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            blockUi.release(), blockUi.destroy();
            console.log("load data is error!");
            Swal.fire({
                title: "Ooops!",
                text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.",
                icon: "error",
                allowOutsideClick: false,
            });
        },
    });
}
//Save Category by Enter
$("#form-category input").keyup(function (event) {
    if (event.keyCode == 13 || event.key === "Enter") {
        $("#btn-save").click();
    }
});
//Save Category Form
$("#btn-save").on("click", function (e) {
    e.preventDefault();
    $("#btn-save").html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr("disabled", true);
    let name = $('#name');

    if (name.val() == '') {
        toastr.error('Nama kategori postingan masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        name.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    }

    let textConfirmSave = "Simpan perubahan data sekarang ?";
    if (save_method == "add_category") {
        textConfirmSave = "Tambahkan data sekarang ?";
    }

    Swal.fire({
        title: "",
        text: textConfirmSave,
        icon: "question",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.value) {
            let target = document.querySelector("#card-formCategory"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            let formData = new FormData($("#form-category")[0]), ajax_url = base_url+ "api/manage_postcategories/store";
            if(save_method == 'update_category') {
                ajax_url = base_url+ "api/manage_postcategories/update";
            }
            $.ajax({
                url: ajax_url,
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function (data) {
                    $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
                    blockUi.release(), blockUi.destroy();
                    if (data.status == true) {
                        Swal.fire({
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                            allowOutsideClick: false,
                        }).then(function (result) {
                            _closeCard('form_category'), _loadDtCategories();
                        });
                    } else {
                        Swal.fire({
                            title: "Ooops!",
                            html: data.message,
                            icon: "warning",
                            allowOutsideClick: false,
                        });
                    }
                }, error: function (jqXHR, textStatus, errorThrown) {
                    $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({
                        title: "Ooops!",
                        text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.",
                        icon: "error",
                        allowOutsideClick: false,
                    });
                }
            });
        } else {
            $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
        }
    });
});
//Update Status Data Category
const _updateStatus = (idp, value) => {
    let textLbl = 'Nonaktifkan';
    if(value=='Y') {
        textLbl = 'Aktifkan';
    }
    let textSwal = textLbl+ ' kategori postingan sekarang ?';
    Swal.fire({
        title: "",
        html: textSwal,
        icon: "question",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak, Batalkan!"
    }).then(result => {
        if (result.value) {
            let target = document.querySelector('#card-dtCategories'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_postcategories/update_status",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp, value
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtCategories();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtCategories();
                    });
                }
            });
        }
    });
}
/*/Delete Data Category
const _deleteCategory = (idp) => {
    Swal.fire({
        title: "",
        html: "Hapus kategori postingan sekarang?",
        icon: "question",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak, Batalkan!"
    }).then(result => {
        if (result.value) {
            let target = document.querySelector('#card-dtCategories'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_relatedlinks/delete",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtCategories();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtCategories();
                    });
                }
            });
        }
    });
} */
//Class Initialization
jQuery(document).ready(function() {
    _loadDtCategories();
    $('#is_public').change(function() {
        if(this.checked) {
            $('#iGroup-isPublic .form-check-label').text('AKTIF');
        }else{
            $('#iGroup-isPublic .form-check-label').text('TIDAK AKTIF');
        }
    });
});