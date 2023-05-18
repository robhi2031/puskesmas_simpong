@extends('backend.layouts', ['activeMenu' => 'SETTINGS', 'activeSubMenu' => 'Site Info'])
@section('content')
<!--begin::System Info-->
<div class="card mb-5 mb-xl-10" id="cardSiteInfo">
    <!--begin::Edit-->
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start flex-wrap mb-10">
            <h3 class="fw-bolder m-0 mb-3"><i class="las la-pen text-dark fs-2 me-3"></i>Edit Informasi Situs Web</h3>
            <a href="javascript:history.back();" class="btn btn-sm btn btn-bg-light btn-color-danger ms-3"><i class="las la-undo fs-3"></i> Kembali</a>
        </div>
        <!--begin::Form-->
        <form id="form-editSiteInfo" class="form" onsubmit="return false">
            <!--begin::Input group-->
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-bold fs-6" for="name">Nama</label>
                <div class="col-lg-8">
                    <input type="text" name="name" id="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" maxlength="255" placeholder="Isikan nama situs ..." />
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-bold fs-6" for="short_name">Nama Alias/ Nama Pendek</label>
                <div class="col-lg-8">
                    <input type="text" name="short_name" id="short_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" maxlength="60" placeholder="Isikan nama alias / nama pendek situs ..." />
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-bold fs-6" for="description">Deskripsi</label>
                <div class="col-lg-8">
                    <textarea name="description" id="description" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" rows="2" maxlength="160" placeholder="Isikan deskripsi singkat situs ..."></textarea>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-bold fs-6" for="keyword">Keyword/ Kata Kunci</label>
                <div class="col-lg-8">
                    <select class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="keyword" name="keyword[]" multiple></select>
                    <div class="form-text">*) Pisahkan keyword dengan tanda koma, contoh: <code>web bp2td mempawah, mempawah, kalimantan</code></div>
                    <div class="form-text">*) Maksimal: <code>10</code> kata kunci</div>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-bold fs-6" for="copyright">Copyright</label>
                <div class="col-lg-8">
                    <textarea name="copyright" id="copyright" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 summernote"></textarea>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6" id="iGroup-frontend_logo">
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Logo Header Publik</label>
                <div class="col-lg-8">
                    <input type="file" class="dropify-upl mb-3 mb-lg-0" id="frontend_logo" name="frontend_logo" accept=".png, .jpg, .jpeg" data-show-remove="false" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M" />
                    <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                    <div class="form-text">*) Max. size file: <code>2MB</code></div>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6" id="iGroup-login_bg">
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Background Login</label>
                <div class="col-lg-8">
                    <input type="file" class="dropify-upl mb-3 mb-lg-0" id="login_bg" name="login_bg" accept=".png, .jpg, .jpeg" data-show-remove="false" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M" />
                    <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                    <div class="form-text">*) Max. size file: <code>2MB</code></div>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6" id="iGroup-login_logo">
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Logo Login</label>
                <div class="col-lg-8">
                    <input type="file" class="dropify-upl mb-3 mb-lg-0" id="login_logo" name="login_logo" accept=".png, .jpg, .jpeg" data-show-remove="false" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M" />
                    <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                    <div class="form-text">*) Max. size file: <code>2MB</code></div>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6 dropify-custom-dark" id="iGroup-backend_logo">
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Backend Logo</label>
                <div class="col-lg-8">
                    <input type="file" class="dropify-upl mb-3 mb-lg-0" id="backend_logo" name="backend_logo" accept=".png, .jpg, .jpeg" data-show-remove="false" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M" />
                    <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                    <div class="form-text">*) Max. size file: <code>2MB</code></div>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6" id="iGroup-backend_logo_icon">
                <label class="col-lg-4 col-form-label required fw-bold fs-6">Backend Logo Icon</label>
                <div class="col-lg-8">
                    <input type="file" class="dropify-upl mb-3 mb-lg-0" id="backend_logo_icon" name="backend_logo_icon" accept=".png, .jpg, .jpeg" data-show-remove="false" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M" />
                    <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                    <div class="form-text">*) Max. size file: <code>2MB</code></div>
                </div>
            </div>
            <!--end::Input group-->
            <div class="row mt-5">
                <div class="col-lg-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-light btn-active-light-danger me-2" id="btn-resetFormSiteInfo"><i class="las la-redo-alt fs-1 me-3"></i>Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-saveSiteInfo"><i class="las la-save fs-1 me-3"></i>Simpan</button>
                </div>
            </div>
        </form>
    </div>
    <!--end::Edit-->
</div>
<!--end::Site Info-->
@endsection