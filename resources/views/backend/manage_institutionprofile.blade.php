@extends('backend.layouts', ['activeMenu' => 'INSTITUSI', 'activeSubMenu' => 'Profil'])
@section('content')
<!--begin::Content-->
<div class="flex-lg-row-fluid">
    <!--begin:::Tabs-->
    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8" id="institutionTabMenu">
        <li class="nav-item">
            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#profileInstitution_tab">Profil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#headOfCenter_tab">Kepala Balai</a>
        </li>
    </ul>
    <!--end:::Tabs-->
    <!--begin:::Tab content-->
    <div class="tab-content" id="institutionTabContent">
        <!--begin:::Profile Tab panel-->
        <div class="tab-pane fade show active" id="profileInstitution_tab" role="tabpanel">
            <!--begin::Profile Card-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Edit-->
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-10">
                        <h3 class="fw-bolder m-0 mb-3"><i class="las la-pen text-dark fs-2 me-3"></i>Edit Informasi & Profil Institusi</h3>
                        <!-- <a href="javascript:history.back();" class="btn btn-sm btn btn-bg-light btn-color-danger ms-3"><i class="las la-undo fs-3"></i> Kembali</a> -->
                    </div>
                    <!--begin::Form-->
                    <form id="form-profileInstitution" class="form" onsubmit="return false">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="name">Nama</label>
                            <div class="col-lg-8">
                                <input type="text" name="name" id="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" maxlength="225" placeholder="Isikan nama institusi ..." />
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="short_description">Deskripsi Singkat</label>
                            <div class="col-lg-8">
                                <textarea name="short_description" id="short_description" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" rows="3" maxlength="255" placeholder="Isikan deskripsi singkat institusi ..."></textarea>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6" id="iGroup-logo">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Logo</label>
                            <div class="col-lg-8">
                                <input type="file" class="dropify-upl mb-3 mb-lg-0" id="logo" name="logo" accept=".png, .jpg, .jpeg" data-show-remove="false" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M" />
                                <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                                <div class="form-text">*) Max. size file: <code>2MB</code></div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="profile">Profil/ Tentang</label>
                            <div class="col-lg-8">
                                <textarea name="profile" id="profile" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 summernote"></textarea>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="vision_mission">Visi & Misi</label>
                            <div class="col-lg-8">
                                <textarea name="vision_mission" id="vision_mission" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 summernote"></textarea>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6" id="iGroup-organizationStructure">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Struktur Organisasi</label>
                            <div class="col-lg-8">
                                <input type="file" class="dropify-upl mb-3 mb-lg-0" id="organization_structure" name="organization_structure" accept=".png, .jpg, .jpeg" data-show-remove="false" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M" />
                                <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                                <div class="form-text">*) Max. size file: <code>2MB</code></div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="email">Email</label>
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid mb-2">
                                    <span class="input-group-text"><i class="las la-envelope fs-1"></i></span>
                                    <input type="text" class="form-control form-control-lg form-control-solid no-space" name="email" id="email" placeholder="Isikan email institusi ..." />
                                </div>
                                <div class="form-text">*) Pastikan email sesuai format dan masih aktif digunakan, contoh: <code>andre123@gmail.com</code></div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="phone_number">No. Telpon/Hp</label>
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid mb-2">
                                    <span class="input-group-text"><i class="las la-phone fs-1"></i></span>
                                    <input type="text" class="form-control form-control-lg form-control-solid mask-13-custom" name="phone_number" id="phone_number" placeholder="Isikan No. Telpon/Hp institusi ..." />
                                </div>
                                <div class="form-text">*) Pastikan No. Telpon/Hp sesuai format dan masih aktif digunakan, contoh: <code>+6283122222222</code></div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="office_address">Alamat Kantor</label>
                            <div class="col-lg-8">
                                <textarea name="office_address" id="office_address" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" rows="2" maxlength="225" placeholder="Isikan alamat kantor institusi ..."></textarea>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="office_lat_coordinate">Titik Koordinat Lokasi Kantor</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-6 fv-row">
                                        <div class="input-group input-group-solid mb-2">
                                            <span class="input-group-text"><i class="las la-map-marker-alt fs-1"></i></span>
                                            <input type="text" class="form-control form-control-lg form-control-solid coordinate-input" name="office_lat_coordinate" id="office_lat_coordinate" placeholder="-5.142836" />
                                        </div>
                                        <div class="form-text">*) Pastikan titik koordinat sudah sesuai koordinat lintang, contoh: <code>-5.142836</code></div>
                                    </div>
                                    <div class="col-lg-6 fv-row">
                                        <div class="input-group input-group-solid mb-2">
                                            <span class="input-group-text"><i class="las la-map-marker-alt fs-1"></i></span>
                                            <input type="text" class="form-control form-control-lg form-control-solid coordinate-input" name="office_long_coordinate" id="office_long_coordinate" placeholder="119.4382801" />
                                        </div>
                                        <div class="form-text">*) Pastikan titik koordinat sudah sesuai koordinat bujur, contoh: <code>119.4382801</code></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <h2 class="fw-semibold my-1">Sosial Media</h2>
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="facebook_account">Akun Facebook</label>
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid mb-2">
                                    <span class="input-group-text"><i class="lab la-facebook-f fs-1"></i></span>
                                    <input type="text" class="form-control form-control-lg form-control-solid no-space" name="facebook_account" id="facebook_account" placeholder="Isikan link akun facebook institusi ..." />
                                </div>
                                <div class="form-text">*) Contoh: <code>https://web.facebook.com/bp2tdmempawah</code></div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="instagram_account">Akun Instagram</label>
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid mb-2">
                                    <span class="input-group-text"><i class="lab la-instagram fs-1"></i></span>
                                    <input type="text" class="form-control form-control-lg form-control-solid no-space" name="instagram_account" id="instagram_account" placeholder="Isikan link akun instagram institusi ..." />
                                </div>
                                <div class="form-text">*) Contoh: <code>https://www.instagram.com/bp2tdmempawah</code></div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="twitter_account">Akun Twitter</label>
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid mb-2">
                                    <span class="input-group-text"><i class="lab la-twitter fs-1"></i></span>
                                    <input type="text" class="form-control form-control-lg form-control-solid no-space" name="twitter_account" id="twitter_account" placeholder="Isikan link akun twitter institusi ..." />
                                </div>
                                <div class="form-text">*) Contoh: <code>https://twitter.com/bp2tdmempawah</code></div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="youtube_channel">Channel Youtube</label>
                            <div class="col-lg-8">
                                <div class="input-group input-group-solid mb-2">
                                    <span class="input-group-text"><i class="lab la-youtube fs-1"></i></span>
                                    <input type="text" class="form-control form-control-lg form-control-solid no-space" name="youtube_channel" id="youtube_channel" placeholder="Isikan link channel youtube institusi ..." />
                                </div>
                                <div class="form-text">*) Contoh: <code>https://www.youtube.com/@bp2tdmempawah</code></div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <div class="row mt-5">
                            <div class="col-lg-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-light btn-active-light-danger me-2" id="btn-resetFormProfile"><i class="las la-redo-alt fs-1 me-3"></i>Batal</button>
                                <button type="button" class="btn btn-primary" id="btn-saveProfile"><i class="las la-save fs-1 me-3"></i>Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Profile-->
        </div>
        <!--end::Profile Tab panel-->
        <!--begin:::Head Of Center Tab panel-->
        <div class="tab-pane fade" id="headOfCenter_tab" role="tabpanel">
            <!--begin::Head Of Center Card-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Edit-->
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-10">
                        <h3 class="fw-bolder m-0 mb-3"><i class="las la-pen text-dark fs-2 me-3"></i>Edit Kepala Balai</h3>
                        <!-- <a href="javascript:history.back();" class="btn btn-sm btn btn-bg-light btn-color-danger ms-3"><i class="las la-undo fs-3"></i> Kembali</a> -->
                    </div>
                    <!--begin::Form-->
                    <form id="form-headOfCenter" class="form" onsubmit="return false">
                        <input type="hidden" name="tab_method" value="headOfCenter_tab" />
                        <div class="row mb-6">
                            <label class="col-md-4 col-form-label required fw-bold fs-6" for="avatar">Foto</label>
                            <div class="col-md-8" id="iGroup-avatar">
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ asset('/dist/img/avatar-blank.svg') }}')">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px"></div>
                                    <!--end::Preview existing avatar-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Ubah foto">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <input type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" id="avatar_remove" value="1" />
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" id="btn-cancelAvatar" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Batalkan perubahan foto">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Hapus foto">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                </div>
                            </div> 
                            <div class="col-md-12 form-text">*) Jenis file yang diizinkan: <code>png, jpg, jpeg</code> | Ukuran file Maks: <code>2MB</code></div>
                        </div>
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="nama_kepalabalai">Nama</label>
                            <div class="col-lg-8">
                                <input type="text" name="nama_kepalabalai" id="nama_kepalabalai" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" maxlength="225" placeholder="Isikan nama kepala balai ..." />
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6" id="iGroup-gender">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="gender">Jenis Kelamin</label>
                            <div class="col-lg-8">
                                <select class="show-tick form-select-solid" data-width="100%" data-style="btn-sm btn-primary" name="gender" id="gender" data-container="body" title="Pilih Jenis Kelamin ...">
                                    <option value="Perempuan">Perempuan</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6" id="iGroup-employmentStatus">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="employment_status">Status Kepegawaian</label>
                            <div class="col-lg-8">
                                <select class="show-tick form-select-solid" data-width="100%" data-style="btn-sm btn-primary" name="employment_status" id="employment_status" data-container="body" title="Pilih status kepegawaian ..."></select>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="cbo_rank_grade">Pangkat/ Golongan</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-9 fv-row">
                                        <select class="form-select" name="cbo_rank_grade" id="cbo_rank_grade"></select>
                                        <div class="form-text">*) Ketik pangkat/ golongan untuk mempercepat pencarian</div>
                                    </div>
                                    <div class="col-lg-3 fv-row">
                                        <button type="button" class="btn btn-light btn-active-light-primary" onclick="_addOptionSelect2('cbo_rank_grade');" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Tambahkan item Pangkat/ Golongan?"><i class="bi bi-plus fs-1 me-3"></i>Tambah</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group--
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="cbo_position">Jabatan</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-9 fv-row">
                                        <select class="form-select" name="cbo_position" id="cbo_position"></select>
                                        <div class="form-text">*) Ketik jabatan untuk mempercepat pencarian</div>
                                    </div>
                                    <div class="col-lg-3 fv-row">
                                        <button type="button" class="btn btn-light btn-active-light-primary" onclick="_addOptionSelect2('cbo_position');" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Tambahkan item Jabatan?"><i class="bi bi-plus fs-1 me-3"></i>Tambah</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6" for="awards">Penghargaan</label>
                            <div class="col-lg-8">
                                <textarea name="awards" id="awards" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"></textarea>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <div class="row mt-5">
                            <div class="col-lg-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-light btn-active-light-danger me-2" id="btn-resetFormHeadOfCenter"><i class="las la-redo-alt fs-1 me-3"></i>Batal</button>
                                <button type="button" class="btn btn-primary" id="btn-saveHeadOfCenter"><i class="las la-save fs-1 me-3"></i>Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Head Of Center-->
        </div>
        <!--end::Head Of Center Tab panel-->
    </div>
    <!--end:::Tab content-->
</div>
<!--begin::Modal Add Option on Select2-->
<div class="modal fade" id="modal-addOptionSelect2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h3 class="modal-title fw-bolder"></h3>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y">
                <!--begin::Scroll-->
                <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-offset="185px">
                    <form id="form-optionSelect2" class="form" onsubmit="return false">
                        <input type="hidden" name="item_method" />
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-md-12">
                                <!--begin::Input group-->
                                <div class="mb-3">
                                    <label class="col-form-label required fw-bold fs-6" for="nameOption" id="lbOption"></label>
                                    <input type="text" class="form-control form-control-solid" name="nameOption" id="nameOption" maxlength="150" />
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>
                        <!--end::Row-->
                    </form>
                </div>
            </div>
            <!--end::Modal body-->
            <!--begin::Modal footer-->
            <div class="modal-footer py-3">
                <!--begin::Actions-->
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-light btn-active-light-danger me-2" data-bs-dismiss="modal"><i class="las la-times fs-1 me-3"></i>Tutup</button>
                    <button type="button" class="btn btn-primary" id="btn-saveOptionSelect2"><i class="las la-save fs-1 me-3"></i>Simpan</button>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Modal footer-->
        </div>
    </div>
</div>
<!--end::Modal Add Option on Select2-->
@endsection