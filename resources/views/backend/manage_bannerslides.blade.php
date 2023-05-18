@extends('backend.layouts', ['activeMenu' => 'KONTEN PUBLIK', 'activeSubMenu' => 'Slide Banner'])
@section('content')
<!--begin::Card Form-->
<div class="card" id="card-formSlide" style="display: none;">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title"></div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn btn-bg-light btn-color-danger me-2" id="btn-closeFormSlide" onclick="_closeCard('form_slide');"><i class="fas fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Form-->
    <form id="form-slide" class="form" onsubmit="return false">
        <input type="hidden" name="id" />
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Input group-->
                    <div class="row mb-6" id="iGroup-fileSlide">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">File Banner</label>
                        <div class="col-lg-8">
                            <input type="file" class="dropify-upl mb-3 mb-lg-0" id="file_slide" name="file_slide" accept=".png, .jpg, .jpeg" data-show-remove="false" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M" />
                            <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                            <div class="form-text">*) Max. size file: <code>2MB</code></div>
                            <div class="form-text">*) Rekomendasi gambar banner: <code>W=1920px</code> dan <code>H=626px</code> dengan <code>resolusi=72,009pixel/inch</code> </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6" id="iGroup-sectionPosition">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="section_position">Posisi</label>
                        <div class="col-lg-8">
                            <select class="show-tick form-select-solid selectpicker" data-width="100%" data-style="btn-sm btn-primary" name="section_position" id="section_position" data-container="body" title="Pilih posisi slide ...">
                                <option value="headSectionSlide" selected>Head Section of Public Home Page</option>
                                <!-- <option value="Laki-Laki">Laki-Laki</option> -->
                            </select>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6 checkIs" id="iGroup-isLink">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="is_link">Memiliki Link</label>
                        <div class="col-lg-8">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="is_link" name="is_link" />
                                <label class="form-check-label" for="is_link"></label>
                            </div>
                            <div class="form-text">*) Jika <code>Ya</code>, Banner Slide berisi link yang mengarah ke halaman tertentu</div>
                            <div class="form-text">*) Jika <code>Tidak</code>, Banner Slide tidak berisi link</div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6 isLink-hide" style="display: none;">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="link_url">Link Url</label>
                        <div class="col-lg-8">
                            <div class="input-group input-group-solid mb-2">
                                <span class="input-group-text"><i class="las la-external-link-alt fs-1"></i></span>
                                <input type="text" class="form-control form-control-lg form-control-solid no-space" name="link_url" id="link_url" placeholder="Isikan link url banner slide ..." />
                            </div>
                            <div class="form-text">*) Contoh: <code>https://google.com</code></div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="1" name="link_target" id="link_target" checked />
                                <label class="form-check-label" for="link_target">
                                    Buka di tab baru
                                </label>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group--
                    <div class="row mb-6 checkIs" id="iGroup-isCaption">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="is_caption">Memiliki Caption</label>
                        <div class="col-lg-8">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="is_caption" name="is_caption" />
                                <label class="form-check-label" for="is_caption"></label>
                            </div>
                            <div class="form-text">*) Jika <code>Ya</code>, Banner Slide berisi caption berupa text dengan panjang maksimal: <code>100 Karakter</code></div>
                            <div class="form-text">*) Jika <code>Tidak</code>, Banner Slide tidak berisi caption</div>
                        </div>
                    </div>
                    <!--end::Input group--
                    <!--begin::Input group--
                    <div class="row mb-6 isCaption-hide">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="caption">Caption</label>
                        <div class="col-lg-8">
                            <textarea name="caption" id="caption" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" rows="2" maxlength="100" placeholder="Isikan caption slide ..."></textarea>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group--
                    <div class="row mb-6 checkIs" id="iGroup-isSosmed">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="is_sosmed">Tampilkan Sosial Media</label>
                        <div class="col-lg-8">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="is_sosmed" name="is_sosmed" />
                                <label class="form-check-label" for="is_sosmed"></label>
                            </div>
                            <div class="form-text">*) Jika <code>Ya</code>, Banner Slide menampilkan sosial media institusi</div>
                            <div class="form-text">*) Jika <code>Tidak</code>, Banner Slide tidak menampilkan sosial media institusi</div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6" id="iGroup-isPublic" style="display: none;">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="is_public">Status</label>
                        <div class="col-lg-8">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="is_public" name="is_public" />
                                <label class="form-check-label" for="is_public"></label>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Card body-->
        <!--begin::Actions-->
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="button" class="btn btn-light btn-active-light-danger me-2" id="btn-reset" onclick="_clearFormSlide();"><i class="las la-redo-alt fs-1 me-3"></i>Batal</button>
            <button type="button" class="btn btn-primary" id="btn-save"><i class="las la-save fs-1 me-3"></i>Simpan</button>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->
</div>
<!--end::Card Form-->
<!--begin::List Table Data-->
<div class="card shadow" id="card-dtSlides">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">
            <h3 class="fw-bolder fs-2 text-gray-900">
                <i class="fas fa-th-list fs-2 text-gray-900 me-2"></i> Konten Banner Slide
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary me-2" id="btn-addSlide" onclick="_addSlide();"><i class="las la-plus fs-3"></i> Tambah</button>
            </div>
        </div>
    </div>
    <!--end::Card header-->
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-center align-items-center mb-5">
            <div class="ms-auto">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative mb-md-0 mb-3">
                    <div class="input-group input-group-sm input-group-solid border">
                        <span class="input-group-text"><i class="las la-search fs-3"></i></span>
                        <input type="text" class="form-control form-control-sm form-control-solid border-left-0" name="search-dtSlides" id="search-dtSlides" placeholder="Pencarian..." />
                        <span class="input-group-text border-left-0 cursor-pointer text-hover-danger" id="clear-searchDtSlides" style="display: none;">
                            <i class="las la-times fs-3"></i>
                        </span>
                    </div>
                </div>
                <!--end::Search-->
            </div>
        </div>
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table table-rounded align-middle table-row-bordered border" id="dt-slides">
                <thead>
                    <tr class="fw-bolder text-uppercase bg-light">
                        <th class="text-center align-middle px-2 border-bottom-2 border-gray-200">No.</th>
                        <th class="align-middle px-2 border-bottom-2 border-gray-200">Slide</th>
                        <th class="align-middle px-2 border-bottom-2 border-gray-200">Posisi</th>
                        <th class="align-middle px-2 border-bottom-2 border-gray-200">Link</th>
                        <th class="align-middle px-2 border-bottom-2 border-gray-200">Active</th>
                        <th class="text-center align-middle px-2 border-bottom-2 border-gray-200">Aksi</th>
                    </tr>
                </thead>
            </table>
            <!--end::Table-->
        </div>
    </div>
</div>
<!--end::List Table Data-->
@endsection