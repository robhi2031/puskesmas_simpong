"use strict";
//Class Definition
var save_method;
var table;
//Load Datatables Slides
const _loadDtSlides = () => {
    table = $('#dt-slides').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url+ 'api/manage_bannerslides/show',
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
            { data: 'file_name', name: 'file_name', width: "65%", className: "align-top text-center border px-2", searchable: false },
            { data: 'section_position', name: 'section_position', width: "5%", className: "align-top border px-2" },
            { data: 'is_link', name: 'is_link', width: "5%", className: "align-top text-center border px-2" },
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
            $("#search-dtSlides").on("keyup", function () {
                table.search(this.value).draw();
                if ($(this).val().length > 0) {
                    $("#clear-searchDtSlides").show();
                } else {
                    $("#clear-searchDtSlides").hide();
                }
            });
            //Clear Search Table
            $("#clear-searchDtSlides").on("click", function () {
                $("#search-dtSlides").val(""),
                table.search("").draw(),
                $("#clear-searchDtSlides").hide();
            });
            //Custom Table
            $("#dt-slides_length select").selectpicker(),
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
    $("#dt-slides").css("width", "100%"),
    $("#search-dtSlides").val(""),
    $("#clear-searchDtSlides").hide();
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
        if (this.value.indexOf("https://") !== 0) {
            this.value = "https://" + this.value;
        }
    });
}
//end::Input https://
//Close Content Card by Open Method
const _closeCard = (card) => {
    if(card=='form_slide') {
        save_method = '';
        _clearFormSlide(), $('#card-formSlide .card-header .card-title').html('');
    }
    $('#card-formSlide').hide(), $('#card-dtSlides').show();
}
//Clear Form Slide
const _clearFormSlide = () => {
    $("#form-slide")[0].reset(), _loadDropifyFile('', '#file_slide'), $('.isLink-hide').hide(), _loadInputLink('#link_url');
    if (save_method == "" || save_method == "add_slide") {
        $('[name="id"]').val(""), $('#iGroup-isPublic').hide();
    } else {
        let idp = $('[name="id"]').val();
        _editSlide(idp);
    }
}
//Add Slide
const _addSlide = () => {
    save_method = "add_slide";
    _clearFormSlide(),
    $("#card-formSlide .card-header .card-title").html(
        `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-window-plus fs-2 text-gray-900 me-2"></i>Form Tambah Slide</h3>`
    ),
    $("#card-dtSlides").hide(), $("#card-formSlide").show();
}
//Edit Slide
const _editSlide = (idp) => {
    save_method = "update_slide";
    $('#iGroup-isPublic').show();
    let target = document.querySelector("#card-formSlide"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    //Ajax load from ajax
    $.ajax({
        url: base_url+ 'api/manage_bannerslides/show',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: 'GET',
        dataType: 'JSON',
        data: {
            idp,
        },
        success: function (data) {
            blockUi.release(), blockUi.destroy();
            if (data.status == true) {
                $('[name="id"]').val(data.row.id),
                _loadDropifyFile(data.row.url_file, '#file_slide'),
                $('#section_position').selectpicker('val', data.row.section_position);
                //is Link
                if (data.row.is_link == 'Y') {
                    $('#is_link').prop('checked', true),
                    $('#iGroup-isLink .form-check-label').text('Ya'),
                    $('.isLink-hide').show(), $('#link_url').val(data.row.link_url);
                    if(data.row.link_target=='_blank') {
                        $('#link_target').prop('checked', true);
                    } else {
                        $('#link_target').prop('checked', false);
                    }
                } else {
                    $('#is_link').prop('checked', false),
                    $('#iGroup-isLink .form-check-label').text('TIDAK');
                    $('.isLink-hide').hide(), $('#link_url').val('');
                    $('#link_target').prop('checked', false);
                }
                //is Public
                if (data.row.is_public == 'Y') {
                    $('#is_public').prop('checked', true),
                    $('#iGroup-isPublic .form-check-label').text('AKTIF');
                } else {
                    $('#is_public').prop('checked', false),
                    $('#iGroup-isPublic .form-check-label').text('TIDAK AKTIF');
                }
                $("#card-formSlide .card-header .card-title").html(
                    `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-pencil-square fs-2 text-gray-900 me-2"></i>Form Edit Slide</h3>`
                ),
                $("#card-dtSlides").hide(), $("#card-formSlide").show();
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
//Save Slide by Enter
$("#form-slide input").keyup(function (event) {
    if (event.keyCode == 13 || event.key === "Enter") {
        $("#btn-save").click();
    }
});
//Save Slide Form
$("#btn-save").on("click", function (e) {
    e.preventDefault();
    $("#btn-save").html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr("disabled", true);
    let file_slide = $('#file_slide'), fileSlide_preview = $('#iGroup-fileSlide .dropify-preview .dropify-render').html(),
    section_position = $("#section_position");

    if (fileSlide_preview == '') {
        toastr.error('File slide masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-fileSlide .dropify-wrapper').addClass('border-2 border-danger').stop().delay(1500).queue(function () {
            $(this).removeClass('border-2 border-danger');
        });
        file_slide.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (section_position.val() == '') {
        toastr.error('Posisi slide masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-sectionPosition button').removeClass('btn-primary').addClass('btn-danger').stop().delay(1500).queue(function () {
			$(this).removeClass('btn-danger').addClass('btn-primary');
		});
        section_position.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if($('#is_link').is(':checked')) {
        let link_url = $('#link_url');
        if (link_url.val() == '') {
            toastr.error('Link url slide masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
            link_url.focus();
            $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
            return false;
        }
    }

    let textConfirmSave = "Simpan perubahan data sekarang ?";
    if (save_method == "add_slide") {
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
            let target = document.querySelector("#card-formSlide"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            let formData = new FormData($("#form-slide")[0]), ajax_url = base_url+ "api/manage_bannerslides/store";
            if(save_method == 'update_slide') {
                ajax_url = base_url+ "api/manage_bannerslides/update";
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
                            _closeCard('form_slide'), _loadDtSlides();
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
//Update Status Data Slide
const _updateStatus = (idp, value) => {
    let textLbl = 'Nonaktifkan';
    if(value=='Y') {
        textLbl = 'Aktifkan';
    }
    let textSwal = textLbl+ ' slide sekarang ?';
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
            let target = document.querySelector('#card-dtSlides'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_bannerslides/update_status",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp, value
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtSlides();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtSlides();
                    });
                }
            });
        }
    });
}
//Delete Data Slide
const _deleteSlide = (idp) => {
    Swal.fire({
        title: "",
        html: "Hapus banner slide sekarang?",
        icon: "question",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak, Batalkan!"
    }).then(result => {
        if (result.value) {
            let target = document.querySelector('#card-dtSlides'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_bannerslides/delete",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtSlides();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtSlides();
                    });
                }
            });
        }
    });
}
//Class Initialization
jQuery(document).ready(function() {
    _loadDtSlides();
    //Load Selectpicker
    $(".selectpicker").selectpicker();
    //Change Check Switch
    $('#is_link').change(function() {
        if(this.checked) {
            $('#iGroup-isLink .form-check-label').text('YA');
            $('.isLink-hide').show(), $('#link_target').prop('checked', true);
        }else{
            $('#iGroup-isLink .form-check-label').text('TIDAK');
            if(save_method=='add_slide') {
                $('#link_url').val(''), $('#link_target').prop('checked', false);
            }
            $('.isLink-hide').hide();
        }
    });
    $('#is_public').change(function() {
        if(this.checked) {
            $('#iGroup-isPublic .form-check-label').text('AKTIF');
        }else{
            $('#iGroup-isPublic .form-check-label').text('TIDAK AKTIF');
        }
    });
});