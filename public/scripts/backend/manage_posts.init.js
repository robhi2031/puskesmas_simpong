"use strict";
//Class Definition
var save_method;
var table;
//Load Datatables Posts
const _loadDtPosts = () => {
    table = $('#dt-posts').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url+ 'api/manage_posts/show',
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            data: function ( data ) {
                data.select_filter= $('#filter-dtPosts').val();
            }
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
            { data: 'post', name: 'post', width: "45%", className: "align-top border px-2" },
            { data: 'category', name: 'category', width: "15%", className: "align-top border px-2" },
            { data: 'views', name: 'views', width: "5%", className: "align-top text-center border px-2", searchable: false },
            { data: 'is_public', name: 'is_public', width: "5%", className: "align-top text-center border px-2", searchable: false },
            { data: 'created_at', name: 'created_at', width: "15%", className: "align-top border px-2", searchable: false },
            { data: 'action', name: 'action', width: "10%", className: "align-top text-center border px-2", orderable: false, searchable: false },
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
            $("#search-dtPosts").on("keyup", function () {
                table.search(this.value).draw();
                if ($(this).val().length > 0) {
                    $("#clear-searchDtPosts").show();
                } else {
                    $("#clear-searchDtPosts").hide();
                }
            });
            //Clear Search Table
            $("#clear-searchDtPosts").on("click", function () {
                $("#search-dtPosts").val(""),
                table.search("").draw(),
                $("#clear-searchDtPosts").hide();
            });
            //Custom Table
            $("#dt-posts_length select").selectpicker(),
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
    $("#dt-posts").css("width", "100%"),
    $("#search-dtPosts").val(""),
    $("#clear-searchDtPosts").hide();
}
//Close Content Card by Open Method
const _closeCard = (card) => {
    if(card=='form_post') {
        save_method = '';
        _clearFormPost(), $('#card-formPost .card-header .card-title').html('');
    }
    $('#card-formPost').hide(), $('#card-dtPosts').show();
}
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
//Load Kategori Select Custom
const _cboCategoriesSelest2 = () => {
    $('#cbo_category').select2({
        width: '100%', placeholder: 'Pilih kategori ...', allowClear: true,
        ajax: {
            url: base_url+ "api/manage_posts/select2_category",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            data: function (params) {
                let query = {
                    search: params.term,
                    page: params.page || 1
                }
                // Query parameters will be ?search=[term]&page=[page]
                return query;
            }, processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    //results: data.results,
                    results: $.map(data.row.results, function (item) {
                        return {
                            id: item.id,
                            text: item.text
                        }
                    }),
                    pagination: {
                        more: (params.page * 20) < data.row.count
                    }
                };
            },
            cache: true
        }
    });
}
//Add Option Item for Select2
const _addOptionSelect2 = (selectElement) => {
    let nameText = 'Kategori';
    $("#form-optionSelect2")[0].reset(), $('[name="item_method"]').val(selectElement),
    $("#lbOption").text(nameText), $("#nameOption").attr('placeholder', 'Isi nama ' +nameText);
    $('#modal-addOptionSelect2 .modal-header .modal-title').html(`<i class="bi bi-window-plus fs-2 text-gray-900 me-2"></i> Tambah item <span class="badge badge-light-success fw-bold fs-3 px-2">` +nameText+ `</span>`);
    $('#modal-addOptionSelect2').modal('show');
}
//Handle Enter Submit Form Add Option Select2
$("#form-optionSelect2 input").keyup(function(event) {
    if (event.keyCode == 13 || event.key === 'Enter') {
        $("#btn-saveOptionSelect2").click();
    }
});
// Handle Button Save Form Add Option Select2
$('#btn-saveOptionSelect2').on('click', function (e) {
    e.preventDefault();
    $('#btn-saveOptionSelect2').html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr('disabled', true);
    let nameOption = $('#nameOption'), selectElement = $('[name="item_method"]').val(), nameText = 'Kategori';

    if (nameOption.val() == '') {
        toastr.error(nameText+ ' masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        nameOption.focus();
        $('#btn-saveOptionSelect2').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    }

    let target = document.querySelector("#modal-addOptionSelect2 .modal-content"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    let formData = new FormData($("#form-optionSelect2")[0])
    $.ajax({
        url: base_url+ 'api/manage_posts/update_itemoptionselect2',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            $("#btn-saveOptionSelect2").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
            blockUi.release(), blockUi.destroy();
            if (data.status == true) {
                Swal.fire({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                    allowOutsideClick: false,
                }).then(function (result) {
                    if ($("#" +selectElement).find("option[value='" +data.row.idp+ "']").length) {
                        $("#" +selectElement).val(data.row.idp).trigger("change");
                    } else { 
                        let newState = new Option(nameOption.val(), data.row.idp, true, true);
                        $("#" +selectElement).append(newState).trigger('change');
                    }
                    $('[name="item_method"]').val(''),
                    $("#lbOption").text(''), $("#nameOption").attr('placeholder', ''),
                    $('#modal-addOptionSelect2 .modal-header .modal-title').html(''),
                    $('#modal-addOptionSelect2').modal('hide');
                });
            } else {
                Swal.fire({
                    title: "Ooops!",
                    text: data.message,
                    icon: "warning",
                    allowOutsideClick: false,
                });
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            $('#btn-saveOptionSelect2').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
            blockUi.release(), blockUi.destroy();
            Swal.fire({
                title: "Ooops!",
                text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.",
                icon: "error",
                allowOutsideClick: false,
            });
        }
    });
});
//Type Post Change
const _changeType = (isEmbed, linkEmbed) => {
    $("#format").change(function() {
        let value = $(this).val();
        $('.hide-format').hide(), $('#embed').val(''), $('#link_media').val(''), $('#label-gallery').html('');
        if(value == 'VIDEO') {
            $('#iGroup-isEmbed').show();
            if(isEmbed == 'Y') {
                $('#is_embed').prop('checked', true);
                $('#iGroup-isEmbed .form-check-label').text('EMBED');
                $('#link_media').val(''), $('#iGroup-linkMedia').hide(),
                $('#embed').val(linkEmbed), $('#iGroup-embed').show();
                if(linkEmbed == '' || linkEmbed == null) {
                    $('#embedShow').html('').hide();
                } else {
                    $('#embedShow').html(linkEmbed).show();
                }
            } else {
                $('#is_embed').prop('checked', false);
                $('#iGroup-isEmbed .form-check-label').text('LINK');
                $('#embed').val(''), $('#iGroup-embed').hide();
                $('#link_media').val(linkEmbed), $('#iGroup-linkMedia').show();
                if(linkEmbed == '' || linkEmbed == null) {
                    $('#linkShow').html('').hide();
                } else {
                    let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                    let match = linkEmbed.match(regExp);
                    if (match && match[2].length == 11) {
                        $('#linkShow').html(`<iframe class="embed-responsive-item rounded w-100" src="//www.youtube.com/embed/` +match[2]+ `" frameborder="0" allowfullscreen></iframe>`).show();
                    } else {
                        $('#linkShow').html(`<iframe class="embed-responsive-item rounded w-100" src="//www.youtube.com/embed/error-source" frameborder="0" allowfullscreen></iframe>`).show();
                    }
                }
            }
        } if(value == 'GALLERY') {
            let idp = $('[name="idGallery"]').val();
            $('#iGroup-isEmbed').hide(), $('#embed').val(''), $('#link_media').val(''), $('.hide-linkEmbed').hide();
            $('#file_gallery').val(''), $('#caption_gallery').val(''), _loadListGallery(idp), $('#listGallery').show(), $('#label-gallery').html('Galeri');
        }
    });
    //===========>> VIDEO
    //Switch is Embed Change
    $('#is_embed').change(function() {
        if(this.checked) {
            $('#iGroup-isEmbed .form-check-label').text('EMBED'),
            $('#link_media').val(''), $('#iGroup-linkMedia').hide(),
            $('#linkShow').html('').hide(),
            $('#embed').val(linkEmbed), $('#iGroup-embed').show();
            if(linkEmbed == '' || linkEmbed == null) {
                $('#embedShow').html('').hide();
            } else {
                $('#embedShow').html(linkEmbed).show();
            }
        }else{
            $('#iGroup-isEmbed .form-check-label').text('LINK'),
            $('#embed').val(''), $('#iGroup-embed').hide(),
            $('#embedShow').html('').hide(),
            $('#link_media').val(linkEmbed), $('#iGroup-linkMedia').show();
            if(linkEmbed == '' || linkEmbed == null) {
                $('#linkShow').html('').hide();
            } else {
                let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                let match = linkEmbed.match(regExp);
                if (match && match[2].length == 11) {
                    $('#linkShow').html(`<iframe class="embed-responsive-item rounded w-100" src="//www.youtube.com/embed/` +match[2]+ `" frameborder="0" allowfullscreen></iframe>`).show();
                } else {
                    $('#linkShow').html(`<iframe class="embed-responsive-item rounded w-100" src="//www.youtube.com/embed/error-source" frameborder="0" allowfullscreen></iframe>`).show();
                }
            }
        }
    });
    //Input Embed Change
    $('#embed').change(function() {
        let valEmbed = $(this).val();
        if(valEmbed == '') {
            $('#embedShow').html('').hide();
        } else {
            $('#embedShow').html(valEmbed).show();
        }
    });
    //Input Link Change
    $('#link_media').change(function() {
        let valLink = $(this).val();
        if(valLink == '') {
            $('#linkShow').html('').hide();
        } else {
            let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            let match = valLink.match(regExp);
            if (match && match[2].length == 11) {
                $('#linkShow').html(`<iframe class="embed-responsive-item rounded w-100" src="//www.youtube.com/embed/` +match[2]+ `" frameborder="0" allowfullscreen></iframe>`).show();
            } else {
                $('#linkShow').html(`<iframe class="embed-responsive-item rounded w-100" src="//www.youtube.com/embed/error-source" frameborder="0" allowfullscreen></iframe>`).show();
            }
        }
    });
}
//===========>> GALLERY  <<=============//
//Add Gallery
$("#btn-addGallery").on("click", function (e) {
    e.preventDefault();
    let listGallery = $("#row-listGallery");
    if (listGallery.find('img').length >= 8) {
        toastr.error("File galeri minimal 1 file dan maksimal 8 file", "Uuppss!", { progressBar: true, timeOut: 1500 });
        return false;
    }
    $('#row-listGallery').hide(), $('#row-addGallery').show(), $('#btn-addGallery').hide(), $('#btn-closeAddGallery').show(), $('#label-gallery').html('Tambah File Galeri');
});
//Button Close Add Gallery
$("#btn-closeAddGallery").on("click", function (e) {
    e.preventDefault();
    _closeAddGallery();
});
//Button Close Add Gallery
$("#btn-resetAddGallery").on("click", function (e) {
    e.preventDefault();
    _closeAddGallery();
});
//Close Add Gallery
const _closeAddGallery = () => {
    $('#file_gallery').val('').fileinput('reset').fileinput('refresh'), $('#caption_gallery').val(''),
    $('#row-addGallery').hide(), $('#btn-closeAddGallery').hide(), $('#btn-addGallery').show(), $('#row-listGallery').show(), $('#label-gallery').html('Galeri');
}
/*/Button Save Gallery by Enter
$("#row-addGallery input").keyup(function (event) {
    if (event.keyCode == 13 || event.key === "Enter") {
        $("#btn-saveGallery").click();
    }
});*/
//Button Save Gallery
$("#btn-saveGallery").on("click", function (e) {
    e.preventDefault();
    $('#btn-saveGallery').html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr('disabled', true);
    let file_gallery = $('#file_gallery');

    if (file_gallery.val() == '') {
        toastr.error('File masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-fileGallery .file-input').addClass('file-input-error rounded').stop().delay(2500).queue(function(){
            $(this).removeClass('file-input-error rounded');
        });
        file_gallery.focus();
        $('#btn-saveGallery').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    }

    let target = document.querySelector("#listGallery"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    // let formData = new FormData($("#form-post")[0])
    let formData = new FormData();
    formData.append("file_gallery", $('#file_gallery')[0].files[0]);
    formData.append("caption_gallery", $('#caption_gallery').val());
    formData.append("idGallery", $('[name="idGallery"]').val());
    //Ajax data
    $.ajax({
        url: base_url+ 'api/manage_posts/store_filegallery',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            $("#btn-saveGallery").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
            blockUi.release(), blockUi.destroy();
            if (data.status == true) {
                Swal.fire({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                    allowOutsideClick: false,
                }).then(function (result) {
                    $('[name="idGallery"]').val(data.row.idp), _closeAddGallery(), _loadListGallery(data.row.idp);
                });
            } else {
                Swal.fire({
                    title: "Ooops!",
                    text: data.message,
                    icon: "warning",
                    allowOutsideClick: false,
                });
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            $('#btn-saveGallery').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
            blockUi.release(), blockUi.destroy();
            Swal.fire({
                title: "Ooops!",
                text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.",
                icon: "error",
                allowOutsideClick: false,
            });
        }
    });
});
//Load List Gallery
const _loadListGallery = (idp) => {
    if(idp == '' || idp == null) {
        $('#row-listGallery').html(`<div class="col-md-12 text-center">
            <span>Tidak ditemukan gallery, Silahkan klik <strong>Tambah</strong> untuk menambahkan file gallery.</span>                     
        </div>`);
    } else {
        let target = document.querySelector("#listGallery"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
        blockUi.block(), blockUi.destroy();
        //Ajax load from ajax
        $.ajax({
            url: base_url+ 'api/manage_posts/show_gallery',
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            dataType: 'JSON',
            data: {
                idp,
            },
            success: function (data) {
                blockUi.release(), blockUi.destroy();
                if (data.status == true) {
                    $('#row-listGallery').html(data.row);
                } else {
                    Swal.fire({title: "Ooops!", text: data.message, icon: "warning", allowOutsideClick: false});
                }
            }, complete: function(data) {
                $('[data-bs-toggle="tooltip"]').tooltip({
                    trigger: "hover"
                }).on("click", function () {
                    $(this).tooltip("hide");
                });
                $('#row-listGallery .image-popup').magnificPopup({
                    type: 'image',
                    mainClass: 'mfp-with-zoom', 
                    gallery:{
                        enabled:true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                        easing: 'ease-in-out',
                        opener: function(openerElement) {
                            return openerElement.is('img') ? openerElement : openerElement.find('img');
                        }
                    }
                });
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
}
//Hapus File Gallery
const deleteFileGallery = (idp) => {
    let target = document.querySelector('#listGallery'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    // Load Ajax
    $.ajax({
        url: base_url+ "api/manage_posts/delete_filegallery",
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: "POST",
        dataType: "JSON",
        data: {
            idp
        }, success: function (data) {
            blockUi.release(), blockUi.destroy();
            Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                _loadListGallery(data.row.idp);
            });
        }, error: function (jqXHR, textStatus, errorThrown) {
            blockUi.release(), blockUi.destroy();
            Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                console.log("Update data is error!");
            });
        }
    });
}
//Clear Form Post
const _clearFormPost = () => {
    $("#form-post")[0].reset(),
    $('#permalinkPost_text').html('').removeClass('d-block').hide(), $('#permalink_post').val('');
    _loadSummernote('Isi konten postingan ...', 730, '#card-formPost', '#content'), $('#content').summernote('code', ''),
    $("#format").selectpicker('val', 'DEFAULT'), $('[name="idGallery"]').val(''),
    $('#file_gallery').val('').fileinput('reset').fileinput('refresh'), $('#caption_gallery').val(''), $('#label-gallery').html(''), _loadListGallery('');
    $("#cbo_category").html('').trigger('change'), _cboCategoriesSelest2(), $("#keyword").html('').trigger('change'),
    $('.hide-format').hide(), _loadDropifyFile('', '#thumb');
    if (save_method == "" || save_method == "add_post") {
        $('[name="id"]').val(""), $('[name="formatOld"]').val(""), _changeType('', ''), $('#iGroup-isPublic').hide();
    } else {
        let idp = $('[name="id"]').val();
        _editPost(idp);
    }
}
//Add Post
const _addPost = () => {
    save_method = "add_post";
    _clearFormPost(),
    $("#card-formPost .card-header .card-title").html(
        `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-window-plus fs-2 text-gray-900 me-2"></i>Form Tambah Postingan</h3>`
    ),
    $("#card-dtPosts").hide(), $("#card-formPost").show();
}
//Edit Post
const _editPost = (idp) => {
    save_method = "update_post";
    $('#form-post')[0].reset(),
    _loadSummernote('Isi konten postingan ...', 730, '#card-formPost', '#content'), $('#content').summernote('code', ''),
    $('#permalinkPost_text').show(), $('[name="permalink_post"]').val(''), $("#keyword").html('').trigger('change'),
    $('#file_gallery').val('').fileinput('reset').fileinput('refresh'), $('#caption_gallery').val(''), $('#label-gallery').html(''), _loadListGallery('');
    $('.hide-format').hide(), _loadDropifyFile('', '#thumb'), $('#iGroup-isPublic').show();
    let target = document.querySelector("#card-formPost"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    //Ajax load from ajax
    $.ajax({
        url: base_url+ 'api/manage_posts/show',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: 'GET',
        dataType: 'JSON',
        data: {
            idp,
        },
        success: function (data) {
            blockUi.release(), blockUi.destroy();
            if (data.status == true) {
                $('[name="id"]').val(data.row.id), $('[name="idGallery"]').val(data.row.id), $('#title').val(data.row.title);
                $('#permalink_post').val(data.row.slug);
                let slug = base_url+ 'read/'+data.row.slug;
                if(data.row.is_public == 'Y'){
                    $('#permalinkPost_text').html(`Permalink: <a href="` +slug+ `" class="fs-7 text-muted text-hover-primary" data-bs-toggle="tooltip" title="Lihat postingan pada halaman publik!" target="_blank">`+ slug +`</a>`).addClass('d-block').show();
                }else{
                    $('#permalinkPost_text').html(`Permalink: <a href="javascript:void(0);" class="fs-7 text-muted text-hover-primary">`+ slug +`</a>`).addClass('d-block').show();
                }
                //Summernote
                let content = data.row.content;
                $('#content').summernote('code', content);
                //Format Post
                $('#format').selectpicker('val', data.row.post_format), $('[name="formatOld"]').val(data.row.post_format);
                if(data.row.post_format == 'VIDEO') {
                    $('#iGroup-isEmbed').show();
                    if(data.row.is_embed == 'Y') {
                        $('#is_embed').prop('checked', true),
                        $('#iGroup-isEmbed .form-check-label').text('EMBED');
                        $('#link_media').val(''), $('#iGroup-linkMedia').hide(),
                        $('#embed').val(data.row.link_embed), $('#iGroup-embed').show();
                        $('#embedShow').html(data.row.link_embed).show();
                    } else {
                        $('#is_embed').prop('checked', false),
                        $('#iGroup-isEmbed .form-check-label').text('LINK');
                        $('#embed').val(''), $('#iGroup-embed').hide(),
                        $('#link_media').val(data.row.link_embed), $('#iGroup-linkMedia').show();
                        let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                        let match = data.row.link_embed.match(regExp);
                        if (match && match[2].length == 11) {
                            $('#linkShow').html(`<iframe class="embed-responsive-item rounded w-100" src="//www.youtube.com/embed/` +match[2]+ `" frameborder="0" allowfullscreen></iframe>`).show();
                        } else {
                            $('#linkShow').html(`<iframe class="embed-responsive-item rounded w-100" src="//www.youtube.com/embed/error-source" frameborder="0" allowfullscreen></iframe>`).show();
                        }
                    }
                } if(data.row.post_format == 'GALLERY') {
                    $('#iGroup-isEmbed').hide(), $('#embed').val(''), $('#link_media').val(''), $('.hide-linkEmbed').hide();
                    $('#file_gallery').val(''), $('#caption_gallery').val(''), _loadListGallery(data.row.id), $('#listGallery').show(), $('#label-gallery').html('Galeri');
                }
                _changeType(data.row.is_embed, data.row.link_embed);
                // Select 2 Category Post
                _cboCategoriesSelest2();
                let selectedCategory = $("<option selected='selected'></option>").val(data.row.fid_category).text(data.row.category);
                $("#cbo_category").append(selectedCategory).trigger('change');
                //Keyword Post
                let selectedKeyword = '', i;
                for (i = 0; i < data.row.keyword_explode.length; i++) {
                    selectedKeyword += '<option value="' + data.row.keyword_explode[i] + '" selected>' + data.row.keyword_explode[i] + '</option>';
                }
                $("#keyword").html(selectedKeyword).trigger('change');
                _loadDropifyFile(data.row.url_thumb, '#thumb');
                //is Public
                if (data.row.is_public == 'Y') {
                    $('#is_public').prop('checked', true),
                    $('#iGroup-isPublic .form-check-label').text('AKTIF');
                } else {
                    $('#is_public').prop('checked', false),
                    $('#iGroup-isPublic .form-check-label').text('TIDAK AKTIF');
                }
                $("#card-formPost .card-header .card-title").html(
                    `<h3 class="fw-bolder fs-2 text-gray-900"><i class="bi bi-pencil-square fs-2 text-gray-900 me-2"></i>Form Edit Postingan</h3>`
                ),
                $("#card-dtPosts").hide(), $("#card-formPost").show();
            } else {
                Swal.fire({title: "Ooops!", text: data.message, icon: "warning", allowOutsideClick: false});
            }
        }, complete: function(data) {
            $('[data-bs-toggle="tooltip"]').tooltip({
                trigger: "hover"
            }).on("click", function () {
                $(this).tooltip("hide");
            });
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
//Save Post by Enter
$("#form-post input").keyup(function (event) {
    if (event.keyCode == 13 || event.key === "Enter") {
        $("#btn-save").click();
    }
});
//Save Post Form
$("#btn-save").on("click", function (e) {
    e.preventDefault();
    $("#btn-save").html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr("disabled", true);
    let title = $('#title'),
        content = $('#content'),
        format = $('#format'),
        cbo_category = $('#cbo_category'),
        keyword = $('#keyword'),
        thumb = $('#thumb'), thumb_preview = $('#iGroup-thumb .dropify-preview .dropify-render').html();

    if (title.val() == '') {
        toastr.error('Judul postingan masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        title.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (content.summernote('isEmpty')) {
        toastr.error('Isi konten postingan masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        content.summernote('focus');
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (format.val() == '') {
        toastr.error('Tipe postingan masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-format button').removeClass('btn-primary').addClass('btn-danger').stop().delay(1500).queue(function () {
			$(this).removeClass('btn-danger').addClass('btn-primary');
		});
        format.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (format.val() == 'VIDEO') {
        let is_embed = $("#is_embed");
        if (is_embed.is(':checked')) {
            let embed = $("#embed");
            if (embed.val() == "") {
                toastr.error("Kode embed media masih kosong...", "Uuppss!", { progressBar: true, timeOut: 1500 });
                embed.focus();
                $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
                return false;
            }
        } else {
            let link_media = $("#link_media");
            if (link_media.val() == "") {
                toastr.error("Link url media masih kosong...", "Uuppss!", { progressBar: true, timeOut: 1500 });
                link_media.focus();
                $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
                return false;
            }
        }
    } if (format.val() == 'GALLERY') {
        let listGallery = $("#row-listGallery");
        if (listGallery.find('img').length <= 0) {
            toastr.error("File galeri minimal berisi 1 file", "Uuppss!", { progressBar: true, timeOut: 1500 });
            $('#file_gallery').focus();
            $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
            return false;
        } if (listGallery.find('img').length > 8) {
            toastr.error("File galeri maksimal berisi 8 file", "Uuppss!", { progressBar: true, timeOut: 1500 });
            $('#file_gallery').focus();
            $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
            return false;
        }
    } if (cbo_category.val() == '' || cbo_category.val() == null) {
        toastr.error('Kategori postingan masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        cbo_category.focus().select2('open');
        $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
        return false;
    } if (keyword.val() == '' || keyword.val() == null) {
        toastr.error('Keyword/ kata kunci postingan masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        keyword.focus().select2('open');
        $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
        return false;
    } if (thumb_preview == '') {
        toastr.error('Gambar utama/ thumnail postingan masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-thumb .dropify-wrapper').addClass('border-2 border-danger').stop().delay(1500).queue(function () {
            $(this).removeClass('border-2 border-danger');
        });
        thumb.focus();
        $("#btn-save").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
        return false;
    }

    let textConfirmSave = "Simpan perubahan data sekarang ?";
    if (save_method == "add_post") {
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
            let target = document.querySelector("#card-formPost"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            let formData = new FormData($("#form-post")[0]), ajax_url = base_url+ "api/manage_posts/store";
            if(save_method == 'update_post') {
                ajax_url = base_url+ "api/manage_posts/update";
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
                            _closeCard('form_post'), _loadDtPosts();
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
//Update Status Data Postingan
const _updateStatus = (idp, value) => {
    let textLbl = 'Nonaktifkan';
    if(value=='Y') {
        textLbl = 'Aktifkan';
    }
    let textSwal = textLbl+ ' postingan sekarang ?';
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
            let target = document.querySelector('#card-dtPosts'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_posts/update_status",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp, value
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtPosts();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtPosts();
                    });
                }
            });
        }
    });
}
//Restore or Delete Data Post
const _resdelPost = (idp, is_trash) => {
    let textSwal = "Hapus postingan dan jadikan data sampah sekarang?";
    if(is_trash=='N') {
        textSwal = "Restore postingan dari data sampah sekarang?";
    }
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
            let target = document.querySelector('#card-dtPosts'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_posts/update_status",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp, is_trash
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtPosts();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtPosts();
                    });
                }
            });
        }
    });
}
//Delete Data Post Permanently
const _deletePermanentlyPost = (idp) => {
    Swal.fire({
        title: "",
        html: "Hapus postingan secara permanen sekarang?",
        icon: "question",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak, Batalkan!"
    }).then(result => {
        if (result.value) {
            let target = document.querySelector('#card-dtPosts'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy();
            // Load Ajax
            $.ajax({
                url: base_url+ "api/manage_posts/delete",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                dataType: "JSON",
                data: {
                    idp
                }, success: function (data) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Success!", html: data.message, icon: "success", allowOutsideClick: false }).then(function (result) {
                        _loadDtPosts();
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({ title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false }).then(function (result) {
                        console.log("Update data is error!");
                        _loadDtPosts();
                    });
                }
            });
        }
    });
}
//Class Initialization
jQuery(document).ready(function() {
    _loadDtPosts();
    //Load Selectpicker
    $(".selectpicker").selectpicker();
    $("#filter-dtPosts").change(function () {
        _loadDtPosts();
    });
    //Load Select2 Keyword
    $('#keyword').select2({
        dropdownAutoWidth: true,
        tags: true,
        maximumSelectionLength: 10,
        placeholder: 'Isi keyword/ kata kunci postingan ...',
        tokenSeparators: [','],
        width: '100%',
        language: { noResults: () => 'Gunakan tanda koma (,) sebagai pemisah tag'}
    });
    //Load File Gallery Upload
    $("#file_gallery").fileinput({
        maxFileSize: 2048, //2Mb
        language: "id", showUpload: false, showRemove: false, dropZoneEnabled: false, showPreview: false,
        allowedFileExtensions: ["jpg", "jpeg", "png"], browseClass: "btn btn-dark btn-file btn-square rounded-right",
        browseLabel: "Cari File...", showCancel: false, removeClass: "btn btn-bg-light btn-color-danger", removeLabel: "Hapus"
    });
    //Get Slug to Permalink
    $('#title').change(function(){
        if(save_method=='add_post'){
            var title = $(this).val();
            if(title != ''){
                $.ajax({
                    url : base_url+ 'api/manage_posts/get_slugpost',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        title
                    },
                    success: function(data){
                        var get_slug = base_url+'read/'+data.row.slug_post;
                        $('#permalinkPost_text').html(`Permalink: <a href="javascript:void(0);" class="fs-7 text-muted text-hover-primary">`+ get_slug +`</a>`).addClass('d-block').show();
                        $('#permalink_post').val(data.row.slug_post);
                    }, complete: function(data){
                        $('[data-bs-toggle="tooltip"]').tooltip({trigger: 'hover'}).on('click', function(){$(this).tooltip('hide')});
                    }, error: function (jqXHR, textStatus, errorThrown){
                        console.log('Load data is error!');
                    }
                });
            } else {
                $('#permalinkPost_text').html('').removeClass('d-block').hide(), $('#permalink_post').val('');
            }
        }
    });
    //Change Switch
    $('#is_public').change(function() {
        if(this.checked) {
            $('#iGroup-isPublic .form-check-label').text('AKTIF');
        }else{
            $('#iGroup-isPublic .form-check-label').text('TIDAK AKTIF');
        }
    });
});