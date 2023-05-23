"use strict";
//Class Definition
//Summernote Input
$('#content').summernote({
    placeholder: 'Isi konten halaman ...',
    height: 730, minHeight: null, maxHeight: null, dialogsInBody: false, focus: false,
    callbacks: {
        onImageUpload: function(image) {
            var target = document.querySelector('#card-formService'), blockUi = new KTBlockUI(target, { message: messageBlockUi });
            blockUi.block(), blockUi.destroy(), _uploadFile_editor(image[0], '#content'), blockUi.release(), blockUi.destroy();
        }
    }
});
//Load Content Page
const _loadContentPage = (slugPage) => {
    $("#form-editService")[0].reset(), $('#content').summernote('code', '');
    let target = document.querySelector('#card-formService'), blockUi = new KTBlockUI(target, {message: messageBlockUi});
    blockUi.block(), blockUi.destroy();
    $.ajax({
        url: base_url+ "api/manage_institutionservice/show",
        type: 'GET',
        dataType: 'JSON',
        data: {
            slugPage,
        },
        success: function (data) {
            blockUi.release(), blockUi.destroy();
            $('[name="id"]').val(data.row.id),
            $('#title').val(data.row.title);
            //Summernote Content
            let content = data.row.content;
            $('#content').summernote('code', content);
        }, error: function (jqXHR, textStatus, errorThrown) {
            console.log('Load data is error');
            blockUi.release(), blockUi.destroy();
        }
    });
}
// Handle Button Reset / Batal Form Page
$('#btn-reset').on('click', function (e) {
    e.preventDefault();
    _loadContentPage('jenis-dan-jadwal-pelayanan');
});
//Handle Enter Submit Form Edit Page
$("#form-editService input").keyup(function(event) {
    if (event.keyCode == 13 || event.key === 'Enter') {
        $("#btn-save").click();
    }
});
// Handle Button Save Form Page
$('#btn-save').on('click', function (e) {
    e.preventDefault();
    $('#btn-save').html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr('disabled', true);
    let title = $('#title'), content = $('#content');

    if (title.val() == '') {
        toastr.error('Judul halaman masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        title.focus();
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (content.summernote('isEmpty')) {
        toastr.error('Isi konten halaman masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        content.summernote('focus');
        $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    }

    Swal.fire({
        title: "",
        text: "Simpan perubahan sekarang ?",
        icon: "question",
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Batal"
    }).then(result => {
        if (result.value) {
            let target = document.querySelector('#card-formService'), blockUi = new KTBlockUI(target, {message: messageBlockUi});
            blockUi.block(), blockUi.destroy();
            let formData = new FormData($('#form-editService')[0]), ajax_url= base_url+ "api/manage_institutionservice/update";
            $.ajax({
                url: ajax_url,
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function (data) {
                    $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
                    blockUi.release(), blockUi.destroy();
                    if (data.status==true){
                        Swal.fire({title: "Success!", text: data.message, icon: "success", allowOutsideClick: false}).then(function (result) {
                            location.reload();
                        });
                    } else {
                        Swal.fire({title: "Ooops!", text: data.message, icon: "warning", allowOutsideClick: false});
                    }
                }, error: function (jqXHR, textStatus, errorThrown) {
                    $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false});
                }
            });
        }else{
            $('#btn-save').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        }
    });
});
//Class Initialization
jQuery(document).ready(function() {
    _loadContentPage('jenis-dan-jadwal-pelayanan');
});