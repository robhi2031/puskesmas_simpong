"use strict";
//Class Definition
var save_method;
var table;
//Load Datatables Links
const _loadDtLinks = () => {
    table = $('#dt-links').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url+ 'api/manage_relatedlinks/show',
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
            { data: 'name', name: 'name', width: "30%", className: "align-top border px-2" },
            { data: 'link_url', name: 'link_url', width: "25%", className: "align-top border px-2" },
            { data: 'section_position', name: 'section_position', width: "5%", className: "align-top border px-2" },
            { data: 'img_file', name: 'img_file', width: "20%", className: "align-top text-center border px-2", searchable: false },
            // { data: 'is_caption', name: 'is_caption', width: "15%", className: "align-top border px-2" },
            // { data: 'is_social_media', name: 'is_social_media', width: "15%", className: "align-top border px-2" },
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
            $("#search-dtLinks").on("keyup", function () {
                table.search(this.value).draw();
                if ($(this).val().length > 0) {
                    $("#clear-searchDtLinks").show();
                } else {
                    $("#clear-searchDtLinks").hide();
                }
            });
            //Clear Search Table
            $("#clear-searchDtLinks").on("click", function () {
                $("#search-dtLinks").val(""),
                table.search("").draw(),
                $("#clear-searchDtLinks").hide();
            });
            //Custom Table
            $("#dt-links_length select").selectpicker(),
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
    $("#dt-links").css("width", "100%"),
    $("#search-dtLinks").val(""),
    $("#clear-searchDtLinks").hide();
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
//start::Input https://
const _loadInputLink = (inputElement) => {
    $(inputElement).change(function() {
        console.log(this.value.indexOf("mailto:"));
        // console.log(this.value.indexOf("tel:"));
        if (this.value.indexOf("tel:") !== 0 && this.value.indexOf("mailto:") !== 0) {
            if (this.value.indexOf("https://") !== 0) {
                this.value = "https://" + this.value;
            }
        }
    });
}
//end::Input https://
//Close Content Card by Open Method
const _closeCard = (card) => {
    if(card=='form_link') {
        save_method = '';
        _clearFormLink(), $('#card-formLink .card-header .card-title').html('');
    }
    $('#card-formLink').hide(), $('#card-dtLinks').show();
}
//Clear Form Link
const _clearFormLink = () => {
    $("#form-link")[0].reset(), _loadInputLink('#link_url'), $(".selectpicker").selectpicker('val', ''), _changeSectionPosition(''), $('#iGroup-imgFile').hide(), _loadDropifyFile('', '#img_file');
    if (save_method == "" || save_method == "add_link") {
        $('[name="id"]').val(""), $('#iGroup-isPublic').hide();
    } else {
        let idp = $('[name="id"]').val();
        _editLink(idp);
    }
}
//Add Link
const _addLink = () => {
    save_method = "add_link";
    _clearFormLink(),
    $("#card-formLink .card-header .card-title").html(
        `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-window-plus fs-2 text-gray-900 me-2"></i>Form Tambah Link Terkait</h3>`
    ),
    $("#card-dtLinks").hide(), $("#card-formLink").show();
}
//Edit Link
const _editLink = (idp) => {
    save_method = "update_link";
    $('#form-link')[0].reset(), $('#iGroup-isPublic').show();
    let target = document.querySelector("#card-formLink"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    //Ajax load from ajax
    $.ajax({
        url: base_url+ 'api/manage_relatedlinks/show',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: 'GET',
        dataType: 'JSON',
        data: {
            idp,
        },
        success: function (data) {
            blockUi.release(), blockUi.destroy();
            if (data.status == true) {
                $('[name="id"]').val(data.row.id), $('#name').val(data.row.name), $('#link_url').val(data.row.link_url);
                if(data.row.link_target=='_blank') {
                    $('#link_target').prop('checked', true);
                } else {
                    $('#link_target').prop('checked', false);
                }
                //Section Position
                $('#section_position').selectpicker('val', data.row.section_position), _changeSectionPosition(data.row.url_imgFile);
                if(data.row.section_position == 'relatedLinkWithImage') {
                    $('#iGroup-imgFile').show(), _loadDropifyFile(data.row.url_imgFile, '#img_file');
                } else {
                    $('#iGroup-imgFile').hide(), _loadDropifyFile('', '#img_file');
                }
                //is Public
                if (data.row.is_public == 'Y') {
                    $('#is_public').prop('checked', true),
                    $('#iGroup-isPublic .form-check-label').text('AKTIF');
                } else {
                    $('#is_public').prop('checked', false),
                    $('#iGroup-isPublic .form-check-label').text('TIDAK AKTIF');
                }
                $("#card-formLink .card-header .card-title").html(
                    `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-pencil-square fs-2 text-gray-900 me-2"></i>Form Edit Link Terkait</h3>`
                ),
                $("#card-dtLinks").hide(), $("#card-formLink").show();
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
//Change Section Position
const _changeSectionPosition = (urlImgFile) => {
    $('#section_position').change(function() {
        let val = $(this).val();
        if(val == 'relatedLinkWithImage') {
            $('#iGroup-imgFile').show(), _loadDropifyFile(urlImgFile, '#img_file');
        } else {
            $('#iGroup-imgFile').hide(), _loadDropifyFile('', '#img_file');
        }
    });
}
//Save Link by Enter
$("#form-link input").keyup(function (event) {
    if (event.keyCode == 13 || event.key === "Enter") {
        $("#btn-save").click();
    }
});
//Save Link Form
$("#btn-save").on("click", function (e) {
    e.preventDefault();
    $("#btn-save").html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr("disabled", true);
    let name = $('#name'), link_url = $('#link_url'), section_position = $("#section_position");

    if (name.val() == '') {
        toastr.error('Nama link terkait masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        name.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (link_url.val() == '') {
        toastr.error('Url link terkait masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        link_url.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (section_position.val() == '') {
        toastr.error('Posisi link terkait masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-sectionPosition button').removeClass('btn-primary').addClass('btn-danger').stop().delay(1500).queue(function () {
			$(this).removeClass('btn-danger').addClass('btn-primary');
		});
        section_position.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (section_position.val() == 'relatedLinkWithImage') {
        let img_file = $('#img_file'), imgFile_preview = $('#iGroup-imgFile .dropify-preview .dropify-render').html();
        if (imgFile_preview == '') {
            toastr.error('File gambar/ logo link terkait masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
            $('#iGroup-imgFile .dropify-wrapper').addClass('border-2 border-danger').stop().delay(1500).queue(function () {
                $(this).removeClass('border-2 border-danger');
            });
            img_file.focus();
            $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
            return false;
        }
    }

    let textConfirmSave = "Simpan perubahan data sekarang ?";
    if (save_method == "add_link") {
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
            let target = document.querySelector("#card-formLink"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            let formData = new FormData($("#form-link")[0]), ajax_url = base_url+ "api/manage_relatedlinks/store";
            if(save_method == 'update_link') {
                ajax_url = base_url+ "api/manage_relatedlinks/update";
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
                            _closeCard('form_link'), _loadDtLinks();
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
//Update Status Data Link
const _updateStatus = (idp, value) => {
    let textLbl = 'Nonaktifkan';
    if(value=='Y') {
        textLbl = 'Aktifkan';
    }
    let textSwal = textLbl+ ' link terkait sekarang ?';
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
            let target = document.querySelector('#card-dtLinks'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_relatedlinks/update_status",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp, value
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtLinks();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtLinks();
                    });
                }
            });
        }
    });
}
//Delete Data Link
const _deleteLink = (idp) => {
    Swal.fire({
        title: "",
        html: "Hapus link terkait sekarang?",
        icon: "question",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak, Batalkan!"
    }).then(result => {
        if (result.value) {
            let target = document.querySelector('#card-dtLinks'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
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
                        _loadDtLinks();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtLinks();
                    });
                }
            });
        }
    });
}
//Class Initialization
jQuery(document).ready(function() {
    _loadDtLinks();
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