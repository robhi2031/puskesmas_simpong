"use strict";
//Class Definition
var save_method;
var table;
//Load Datatables Study Program
const _loadDtStudyPrograms = () => {
    table = $('#dt-studyPrograms').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url+ 'api/manage_institutionstudyprograms/show',
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
            { data: 'name', name: 'name', width: "50%", className: "align-top border px-2" },
            { data: 'thumb', name: 'thumb', width: "25%", className: "align-top text-center border px-2", searchable: false },
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
            $("#search-dtStudyPrograms").on("keyup", function () {
                table.search(this.value).draw();
                if ($(this).val().length > 0) {
                    $("#clear-searchDtStudyPrograms").show();
                } else {
                    $("#clear-searchDtStudyPrograms").hide();
                }
            });
            //Clear Search Table
            $("#clear-searchDtStudyPrograms").on("click", function () {
                $("#search-dtStudyPrograms").val(""),
                table.search("").draw(),
                $("#clear-searchDtStudyPrograms").hide();
            });
            //Custom Table
            $("#dt-studyPrograms_length select").selectpicker(),
            $('[data-bs-toggle="tooltip"]').tooltip({ 
                trigger: "hover"
            }).on("click", function () {
                $(this).tooltip("hide");
            });
            $('.image-popup').magnificPopup({
                type: 'image', closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                image: {
                    verticalFit: true
                }
            });
        },
    });
    $("#dt-studyPrograms").css("width", "100%"),
    $("#search-dtStudyPrograms").val(""),
    $("#clear-searchDtStudyPrograms").hide();
}
//Load File Dropify
const _loadDropifyFile = (url_file, paramsId) => {
    if (url_file == "") {
        let drEvent1 = $(paramsId).dropify({
            defaultFile: '',
        });
        drEvent1 = drEvent1.data('dropify');
        drEvent1.resetPreview();
        drEvent1.clearElement();
        drEvent1.settings.defaultFile = '';
        drEvent1.destroy();
        drEvent1.init();
    } else {
        let drEvent1 = $(paramsId).dropify({
            defaultFile: url_file,
        });
        drEvent1 = drEvent1.data('dropify');
        drEvent1.resetPreview();
        drEvent1.clearElement();
        drEvent1.settings.defaultFile = url_file;
        drEvent1.destroy();
        drEvent1.init();
    }
}
//begin::Dropify
$('.dropify-upl').dropify({
    messages: {
        'default': '<span class="btn btn-sm btn-secondary">Drag/ drop file atau Klik disini</span>',
        'replace': '<span class="btn btn-sm btn-primary"><i class="fas fa-upload"></i> Drag/ drop atau Klik untuk menimpa file</span>',
        'remove':  '<span class="btn btn-sm btn-danger"><i class="las la-trash-alt"></i> Reset</span>',
        'error':   'Ooops, Terjadi kesalahan pada file input'
    }, error: {
        'fileSize': 'Ukuran file terlalu besar, Max. ( {{ value }} )',
        'minWidth': 'Lebar gambar terlalu kecil, Min. ( {{ value }}}px )',
        'maxWidth': 'Lebar gambar terlalu besar, Max. ( {{ value }}}px )',
        'minHeight': 'Tinggi gambar terlalu kecil, Min. ( {{ value }}}px )',
        'maxHeight': 'Tinggi gambar terlalu besar, Max. ( {{ value }}px )',
        'imageFormat': 'Format file tidak diizinkan, Hanya ( {{ value }} )'
    }
});
//end::Dropify
//Summernote Input
const _loadSummernote = (placeholder, height, cardElement, inputElement) => {
    $(inputElement).summernote({
        placeholder: placeholder,
        height: height, minHeight: null, maxHeight: null, dialogsInBody: false, focus: false,
        callbacks: {
            onImageUpload: function(image) {
                var target = document.querySelector(cardElement), blockUi = new KTBlockUI(target, { message: messageBlockUi });
                blockUi.block(), blockUi.destroy(), _uploadFile_editor(image[0], inputElement), blockUi.release(), blockUi.destroy();
            }
        }
    });
}
//Close Content Card by Open Method
const _closeCard = (card) => {
    if(card=='form_studyProgram') {
        save_method = '';
        _clearFormStudyProgram(), $('#card-formStudyProgram .card-header .card-title').html('');
    }
    $('#card-formStudyProgram').hide(), $('#card-dtStudyPrograms').show();
}
//Clear Form Program Studi
const _clearFormStudyProgram = () => {
    $("#form-studyProgram")[0].reset(), _loadSummernote('Isi deskripsi program studi ...', 450, '#card-formStudyProgram', '#description'), $('#description').summernote('code', ''),
    _loadDropifyFile('', '#thumb');
    if (save_method == "" || save_method == "add_studyProgram") {
        $('[name="id"]').val(""), $('#iGroup-isPublic').hide();
    } else {
        let idp = $('[name="id"]').val();
        _editStudyProgram(idp);
    }
}
//Add Program Studi
const _addStudyProgram = () => {
    save_method = "add_studyProgram";
    _clearFormStudyProgram(),
    $("#card-formStudyProgram .card-header .card-title").html(
        `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-window-plus fs-2 text-gray-900 me-2"></i>Form Tambah Program Studi</h3>`
    ),
    $("#card-dtStudyPrograms").hide(), $("#card-formStudyProgram").show();
}
//Edit Program Studi
const _editStudyProgram = (idp) => {
    save_method = "update_studyProgram";
    $('#form-studyProgram')[0].reset(), _loadSummernote('Isi deskripsi program studi ...', 450, '#card-formStudyProgram', '#description'), $('#description').summernote('code', ''),
    _loadDropifyFile('', '#thumb'), $('#iGroup-isPublic').show();
    let target = document.querySelector("#card-formStudyProgram"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    //Ajax load from ajax
    $.ajax({
        url: base_url+ 'api/manage_institutionstudyprograms/show',
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
                let description = data.row.description;
                $('#description').summernote('code', description);
                _loadDropifyFile(data.row.url_thumb, '#thumb');
                //is Public
                if (data.row.is_public == 'Y') {
                    $('#is_public').prop('checked', true),
                    $('#iGroup-isPublic .form-check-label').text('AKTIF');
                } else {
                    $('#is_public').prop('checked', false),
                    $('#iGroup-isPublic .form-check-label').text('TIDAK AKTIF');
                }
                $("#card-formStudyProgram .card-header .card-title").html(
                    `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-pencil-square fs-2 text-gray-900 me-2"></i>Form Edit Program Studi</h3>`
                ),
                $("#card-dtStudyPrograms").hide(), $("#card-formStudyProgram").show();
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
//Save Program Studi by Enter
$("#form-studyProgram input").keyup(function (event) {
    if (event.keyCode == 13 || event.key === "Enter") {
        $("#btn-save").click();
    }
});
//Save Program Studi Form
$("#btn-save").on("click", function (e) {
    e.preventDefault();
    $("#btn-save").html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr("disabled", true);
    let name = $('#name'), description = $('#description'),
        thumb = $('#thumb'), thumb_preview = $('#iGroup-thumb .dropify-preview .dropify-render').html();

    if (name.val() == '') {
        toastr.error('Nama program studi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        name.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (description.summernote('isEmpty')) {
        toastr.error('Isi deskripsi program studi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        description.summernote('focus');
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (thumb_preview == '') {
        toastr.error('Thumbnail/ gambar program studi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-thumb .dropify-wrapper').addClass('border-2 border-danger').stop().delay(1500).queue(function () {
            $(this).removeClass('border-2 border-danger');
        });
        thumb.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    }

    let textConfirmSave = "Simpan perubahan data sekarang ?";
    if (save_method == "add_studyProgram") {
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
            let target = document.querySelector("#card-formStudyProgram"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            let formData = new FormData($("#form-studyProgram")[0]), ajax_url = base_url+ "api/manage_institutionstudyprograms/store";
            if(save_method == 'update_studyProgram') {
                ajax_url = base_url+ "api/manage_institutionstudyprograms/update";
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
                            _closeCard('form_studyProgram'), _loadDtStudyPrograms();
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
//Update Status Data Program Studi
const _updateStatus = (idp, value) => {
    let textLbl = 'Nonaktifkan';
    if(value=='Y') {
        textLbl = 'Aktifkan';
    }
    let textSwal = textLbl+ ' program studi sekarang ?';
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
            let target = document.querySelector('#card-dtStudyPrograms'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_institutionstudyprograms/update_status",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp, value
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtStudyPrograms();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtStudyPrograms();
                    });
                }
            });
        }
    });
}
//Delete Data Program Studi
const _deleteStudyProgram = (idp) => {
    Swal.fire({
        title: "",
        html: "Hapus program studi sekarang?",
        icon: "question",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak, Batalkan!"
    }).then(result => {
        if (result.value) {
            let target = document.querySelector('#card-dtStudyPrograms'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_institutionstudyprograms/delete",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtStudyPrograms();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtStudyPrograms();
                    });
                }
            });
        }
    });
}
//Class Initialization
jQuery(document).ready(function() {
    _loadDtStudyPrograms();
    //Load Selectpicker
    $(".selectpicker").selectpicker();
    $('#is_public').change(function() {
        if(this.checked) {
            $('#iGroup-isPublic .form-check-label').text('AKTIF');
        }else{
            $('#iGroup-isPublic .form-check-label').text('TIDAK AKTIF');
        }
    });
});