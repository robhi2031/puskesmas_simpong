//Summernote Input
const _loadSummernote = (placeholder, height, cardElement, inputElement) => {
    if(inputElement=='#awards') {
        $(inputElement).summernote({
            placeholder: placeholder,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['insert', ['link']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['codeview']]
            ],
            height: height, minHeight: null, maxHeight: null, dialogsInBody: false, focus: false,
        });
    } else {
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
const _loadInstitutionProfile = () => {
    $("#form-profileInstitution")[0].reset(), _loadDropifyFile('', '#logo'), _loadSummernote('Isi profil/ tentang institusi ...', 650, '#profileInstitution_tab', '#profile'),
    _loadSummernote('Isi visi & misi institusi ...', 650, '#profileInstitution_tab', '#vision_mission'), $('#profileInstitution_tab .summernote').summernote('code', ''), _loadDropifyFile('', '#organization_structure'),
    _loadInputLink('#facebook_account'), _loadInputLink('#instagram_account'), _loadInputLink('#twitter_account'), _loadInputLink('#youtube_channel');
    let target = document.querySelector('#profileInstitution_tab'), blockUi = new KTBlockUI(target, {message: messageBlockUi});
    blockUi.block(), blockUi.destroy();
    $.ajax({
        url: base_url+ "api/manage_institutionprofile/show",
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            blockUi.release(), blockUi.destroy();
            $('#name').val(data.row.name),
            $('#short_description').val(data.row.short_description),
            _loadDropifyFile(data.row.url_logo, '#logo');
            //Summernote Profile
            let profile = data.row.profile;
            $('#profile').summernote('code', profile);
            //Summernote Vision Mision
            let vision_mission = data.row.vision_mission;
            $('#vision_mission').summernote('code', vision_mission);
            _loadDropifyFile(data.row.url_organizationStructure, '#organization_structure'),
            $('#email').val(data.row.email),
            $('#phone_number').val(data.row.phone_number),
            $('#office_address').val(data.row.office_address);
            //Coordinat Split
            let lat = data.row.office_address_coordinate.split(",")[0];
            let long = data.row.office_address_coordinate.split(",")[1];
            $('#office_lat_coordinate').val(lat),
            $('#office_long_coordinate').val(long),
            $('#facebook_account').val(data.row.facebook_account),
            $('#instagram_account').val(data.row.instagram_account),
            $('#twitter_account').val(data.row.twitter_account),
            $('#youtube_channel').val(data.row.youtube_channel);
        }, error: function (jqXHR, textStatus, errorThrown) {
            console.log('Load data is error');
            blockUi.release(), blockUi.destroy();
        }
    });
}
// Handle Button Reset / Batal Form Profil Institusi
$('#btn-resetFormProfile').on('click', function (e) {
    e.preventDefault();
    _loadInstitutionProfile();
});
//Handle Enter Submit Form Edit Profil Institusi
$("#form-profileInstitution input").keyup(function(event) {
    if (event.keyCode == 13 || event.key === 'Enter') {
        $("#btn-saveProfile").click();
    }
});
// Handle Button Save Form Profil Institusi
$('#btn-saveProfile').on('click', function (e) {
    e.preventDefault();
    $('#btn-saveProfile').html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr('disabled', true);
    let name = $('#name'), short_description = $('#short_description'),
    logo = $('#logo'), logo_preview = $('#iGroup-logo .dropify-preview .dropify-render').html(),
    profile = $('#profile'), vision_mission = $('#vision_mission'),
    organization_structure = $('#organization_structure'), organizationStructure_preview = $('#iGroup-organizationStructure .dropify-preview .dropify-render').html(),
    email = $('#email'), phone_number = $('#phone_number'), office_address = $('#office_address'),
    office_lat_coordinate = $('#office_lat_coordinate'), office_long_coordinate = $('#office_long_coordinate'), facebook_account = $('#facebook_account'),
    instagram_account = $('#instagram_account'), twitter_account = $('#twitter_account'), youtube_channel = $('#youtube_channel');

    if (name.val() == '') {
        toastr.error('Nama institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        name.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (short_description.val() == '') {
        toastr.error('Deskripsi singkat institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        short_description.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (logo_preview == '') {
        toastr.error('Logo institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-logo .dropify-wrapper').addClass('border-2 border-danger').stop().delay(1500).queue(function () {
            $(this).removeClass('border-2 border-danger');
        });
        logo.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (profile.summernote('isEmpty')) {
        toastr.error('Profil/ tentang institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        profile.summernote('focus');
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (vision_mission.summernote('isEmpty')) {
        toastr.error('Visi dan Misi institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        vision_mission.summernote('focus');
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (organizationStructure_preview == '') {
        toastr.error('Gambar struktur organisasi institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-organizationStructure .dropify-wrapper').addClass('border-2 border-danger').stop().delay(1500).queue(function () {
            $(this).removeClass('border-2 border-danger');
        });
        organization_structure.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (email.val() == '') {
        toastr.error('Email institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        email.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if(!validateEmail(email.val())){
        toastr.error('Email institusi tidak valid! contoh: bp2td.mempawah@gmail.com ...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        email.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (phone_number.val() == '') {
        toastr.error('No. Telpon/ Hp institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        phone_number.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (office_address.val() == '') {
        toastr.error('Alamat kantor institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        office_address.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (office_lat_coordinate.val() == '') {
        toastr.error('Titik koordinat lintang lokasi institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        office_lat_coordinate.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (office_long_coordinate.val() == '') {
        toastr.error('Titik koordinat bujur lokasi institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        office_long_coordinate.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (facebook_account.val() == '') {
        toastr.error('Akun facebook institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        facebook_account.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (instagram_account.val() == '') {
        toastr.error('Akun instagram institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        instagram_account.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (twitter_account.val() == '') {
        toastr.error('Akun twitter institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        twitter_account.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (youtube_channel.val() == '') {
        toastr.error('Channel youtube institusi masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        youtube_channel.focus();
        $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
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
            let target = document.querySelector('#profileInstitution_tab'), blockUi = new KTBlockUI(target, {message: messageBlockUi});
            blockUi.block(), blockUi.destroy();
            let formData = new FormData($('#form-profileInstitution')[0]), ajax_url= base_url+ "api/manage_institutionprofile/update";
            $.ajax({
                url: ajax_url,
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function (data) {
                    $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
                    blockUi.release(), blockUi.destroy();
                    if (data.status==true){
                        Swal.fire({title: "Success!", text: data.message, icon: "success", allowOutsideClick: false}).then(function (result) {
                            location.reload();
                        });
                    } else {
                        Swal.fire({title: "Ooops!", text: data.message, icon: "warning", allowOutsideClick: false});
                    }
                }, error: function (jqXHR, textStatus, errorThrown) {
                    $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
                    blockUi.release(), blockUi.destroy();
                    Swal.fire({title: "Ooops!", text: "Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.", icon: "error", allowOutsideClick: false});
                }
            });
        }else{
            $('#btn-saveProfile').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        }
    });
});
//Load Selectpicker Status Kepegawaian
const _loadSelectpicker_employmentStatus = (value) => {
    $.ajax({
        url: base_url+ "api/manage_institutionprofile/selectpicker_employmentstatus",
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            let output = '';
            let i;
            for (i = 0; i < data.row.length; i++) {
                output += '<option value="' + data.row[i].name + '">' + data.row[i].name + '</option>';
            }
            if(value !== null && value !== '') {
                value = value.toString();
            }
            $('#employment_status').html(output).selectpicker('refresh').selectpicker('val', value);
        }, error: function (jqXHR, textStatus, errorThrown) {
            console.log('Load data is error');
        }
    });
}
//Load Pangkat/ Golongan Select Custom
const _cboRankGradesSelest2 = () => {
    $('#cbo_rank_grade').select2({
        width: '100%', placeholder: 'Pilih pangkat/ golongan ...', allowClear: true,
        ajax: {
            url: base_url+ "api/manage_institutionprofile/select2_rankgrade",
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
                            id: item.text,
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
/*/Load Jabatan Select Custom
const _cboPositionsSelest2 = () => {
    $('#cbo_position').select2({
        width: '100%', placeholder: 'Pilih jabatan ...', allowClear: true,
        ajax: {
            url: base_url+ "api/manage_institutionprofile/select2_position",
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
                            id: item.text,
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
}*/
//Add Option Item for Select2
const _addOptionSelect2 = (selectElement) => {
    let nameText = 'Pangkat/ Golongan';
    /* if(selectElement=='cbo_position') {
        nameText = 'Jabatan';
    } */
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
    let nameOption = $('#nameOption'), selectElement = $('[name="item_method"]').val(), nameText = 'Pangkat/ Golongan';
    /* if(selectElement=='cbo_position') {
        nameText = 'Jabatan';
    } */

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
        url: base_url+ 'api/manage_institutionprofile/update_itemoptionselect2',
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
                    if ($("#" +selectElement).find("option[value='" +nameOption.val().toUpperCase()+ "']").length) {
                        $("#" +selectElement).val(nameOption.val().toUpperCase()).trigger("change");
                    } else { 
                        let newState = new Option(nameOption.val().toUpperCase(), nameOption.val().toUpperCase(), true, true);
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
//Load Profil Kepala Balai
const _loadHeadOfCenter = () => {
    $("#form-headOfCenter")[0].reset(), $('#avatar_remove').val(1),
    $('#iGroup-avatar .image-input-outline').addClass('image-input-empty'),
    $('#iGroup-avatar .image-input-outline .image-input-wrapper').attr('style', 'background-image: none;'),
    _loadAvatar('', ''), $("#gender").selectpicker(), _loadSelectpicker_employmentStatus(''), // _cboPositionsSelest2(),
    _loadSummernote('Isi penghargaan yang pernah di raih ...', 350, '#headOfCenter_tab', '#awards'),
    $('#headOfCenter_tab .summernote').summernote('code', '');
    let target = document.querySelector("#headOfCenter_tab"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    let tab_method = $('[name="tab_method"]').val();
    //Ajax load from ajax
    $.ajax({
        url: base_url+ 'api/manage_institutionprofile/show',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: 'GET',
        dataType: 'JSON',
        data: {
            tab_method,
        }, success: function (data) {
            blockUi.release(), blockUi.destroy();
            if (data.status == true) {
                _loadAvatar(data.row.thumb, data.row.url_thumb),
                $('#nama_kepalabalai').val(data.row.name),
                $('#gender').selectpicker('val', data.row.gender),
                _loadSelectpicker_employmentStatus(data.row.employment_status);
                _cboRankGradesSelest2();
                let selectedClassRank = $("<option selected='selected'></option>").val(data.row.rank_grade).text(data.row.rank_grade);
                $("#cbo_rank_grade").append(selectedClassRank).trigger('change');
                /* let selectedPosition = $("<option selected='selected'></option>").val(data.row.position).text(data.row.position);
                $("#cbo_position").append(selectedPosition).trigger('change'); */
                //Summernote CopyRight
                let awards = data.row.awards;
                $('#awards').summernote('code', awards);
            } else {
                Swal.fire({title: "Ooops!", text: data.message, icon: "warning", allowOutsideClick: false});
            }
        }, complete: function(data) {
            // Handle Button Cancel
            $('#btn-cancelAvatar').on('click', function (e) {
                e.preventDefault();
                _loadAvatar(data.responseJSON.row.thumb, data.responseJSON.row.url_thumb);
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
//Load Avatar Profil Kepala Balai
const _loadAvatar = (foto, url_foto) => {
    $('#iGroup-avatar .image-input-outline').removeClass('image-input-changed image-input-empty'),
    $('#avatar_remove').val(0);
    if(!foto){
        $('#avatar_remove').val(1),
        $('#iGroup-avatar .image-input-outline').addClass('image-input-empty'),
        $('#iGroup-avatar .image-input-outline .image-input-wrapper').attr('style', 'background-image: none;');
    } else {
        $('#iGroup-avatar .image-input-outline .image-input-wrapper').attr('style', `background-image: url('` +url_foto+ `');`);
    }
}
// Handle Button Reset / Batal Form Profil Kepala Balai Institusi
$('#btn-resetFormHeadOfCenter').on('click', function (e) {
    e.preventDefault();
    _loadHeadOfCenter();
});
//Handle Enter Submit Form Update Kepala Balai
$("#form-headOfCenter input").keyup(function(event) {
    if (event.keyCode == 13 || event.key === 'Enter') {
        $("#btn-saveHeadOfCenter").click();
    }
});
// Handle Button Save Form Update Kepala Balai
$('#btn-saveHeadOfCenter').on('click', function (e) {
    e.preventDefault();
    $('#btn-saveHeadOfCenter').html('<span class="spinner-border spinner-border-sm align-middle me-3"></span> Mohon Tunggu...').attr('disabled', true);
    let avatar = $('#iGroup-avatar .image-input-wrapper'), nama_kepalabalai = $('#nama_kepalabalai'),
        gender = $('#gender'), employment_status = $('#employment_status'), cbo_rank_grade = $('#cbo_rank_grade'), awards = $('#awards');

    if (avatar.attr('style')=='' || avatar.attr('style')=='background-image: none;' || avatar.attr('style')=='background-image: url();') {
        toastr.error('Foto kepala balai masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-avatar .image-input').addClass('border border-2 border-danger').stop().delay(1500).queue(function () {
            $(this).removeClass('border border-2 border-danger');
        });
        $('#avatar').focus();
        $('#btn-saveHeadOfCenter').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (nama_kepalabalai.val() == '') {
        toastr.error('Nama kepala balai masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        nama_kepalabalai.focus();
        $('#btn-saveHeadOfCenter').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (gender.val() == '') {
        toastr.error('Jenis kelamin masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-gender button').removeClass('btn-primary').addClass('btn-danger').stop().delay(1500).queue(function () {
			$(this).removeClass('btn-danger').addClass('btn-primary');
		});
        gender.focus();
        $('#btn-saveHeadOfCenter').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (employment_status.val() == '') {
        toastr.error('Status kepegawaian masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        $('#iGroup-employmentStatus button').removeClass('btn-primary').addClass('btn-danger').stop().delay(1500).queue(function () {
			$(this).removeClass('btn-danger').addClass('btn-primary');
		});
        employment_status.focus();
        $('#btn-saveHeadOfCenter').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (cbo_rank_grade.val() == '' || cbo_rank_grade.val() == null) {
        toastr.error('Pangkat/ Golongan masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        cbo_rank_grade.focus();
        $('#btn-saveHeadOfCenter').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    } if (awards.val() == '') {
        toastr.error('Penghargaan masih kosong...', 'Uuppss!', {"progressBar": true, "timeOut": 1500});
        awards.focus();
        $('#btn-saveHeadOfCenter').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
        return false;
    }

    let target = document.querySelector("#headOfCenter_tab"), blockUi = new KTBlockUI(target, { message: messageBlockUi });
    blockUi.block(), blockUi.destroy();
    let formData = new FormData($("#form-headOfCenter")[0])
    $.ajax({
        url: base_url+ 'api/manage_institutionprofile/update',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            $("#btn-saveHeadOfCenter").html('<i class="las la-save fs-1 me-3"></i>Simpan').attr("disabled", false);
            blockUi.release(), blockUi.destroy();
            if (data.status == true) {
                Swal.fire({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                    allowOutsideClick: false,
                }).then(function (result) {
                    _loadHeadOfCenter();
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
            $('#btn-saveHeadOfCenter').html('<i class="las la-save fs-1 me-3"></i>Simpan').attr('disabled', false);
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
//Class Initialization
jQuery(document).ready(function() {
    _loadInstitutionProfile();
    //If Change Tab
    $('#institutionTabMenu li a').on('click', function (e) {
        e.preventDefault();
        let contentType = $(this).attr('href');
        if(contentType == '#profileInstitution_tab') {
            _loadInstitutionProfile();
        } if(contentType == '#headOfCenter_tab') {
            _loadHeadOfCenter();
        }
    });
    //Mask Custom
    $('.mask-13-custom').mask('099-9999999999');
    $(".coordinate-input").on("input", function(){
        var value = this.value;
        value = value.trim();
        //If minus symbol occur at the beginning
        if(value.charAt(0) === '-'){
            value = value.substring(1, value.length);
            value = "-"+value.replace(/^\.|[^\d\.]|\.(?=.*\.)|^0+(?=\d)/g, '');
        }else{
            value = value.replace(/^\.|[^\d\.]|\.(?=.*\.)|^0+(?=\d)/g, '');
        }
        this.value = value;
    });
    //Lock Space Username
	$('.no-space').on('keypress', function (e) {
		return e.which !== 32;
	});
});