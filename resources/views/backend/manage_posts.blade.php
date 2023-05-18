@extends('backend.layouts', ['activeMenu' => 'BLOG', 'activeSubMenu' => 'Postingan'])
@section('content')
<!--begin::Card Form-->
<div class="card" id="card-formPost" style="display: none;">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title"></div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn btn-bg-light btn-color-danger" id="btn-closeFormLink" onclick="_closeCard('form_link');"><i class="fas fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Form-->
    <form id="form-post" class="form" onsubmit="return false">
        <input type="hidden" name="id" />
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-8">
                    <!--begin::Input group-->
                    <div class="mb-3">
                        <label class="col-form-label required fw-bold fs-6" for="title">Judul</label>
                        <textarea type="text" class="form-control form-control-solid" name="title" id="title" maxlength="200" rows="3" style="resize: none;" placeholder="Isi judul postingan ..." ></textarea>
                        <span id="permalinkPost_text" class="mt-3" style="display: none;"></span>
                        <input type="hidden" name="permalink_post" id="permalink_post" />
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-3">
                        <label class="col-form-label required fw-bold fs-6" for="content">Isi Konten</label>
                        <textarea class="form-control form-control-solid summernote" name="content" id="content"></textarea>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-md-4">
                    <!--begin::Input group-->
                    <div class="mb-3" id="iGroup-format">
                        <label class="col-form-label required fw-bold fs-6" for="format">Tipe</label>
                        <select class="show-tick form-select-solid selectpicker" data-width="100%" data-style="btn-sm btn-primary" name="format" id="format" data-container="body" title="Pilih tipe postingan ...">
                            <option value="DEFAULT" selected>DEFAULT</option>
                            <option value="VIDEO">VIDEO</option>
                            <option value="GALLERY">GALERI</option>
                        </select>
                        <input type="hidden" name="formatOld" />
                        <div class="form-text">*) <code>DEFAULT</code>: Postingan Berita/ Informasi/ Artikel</div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-3 hide-format" id="iGroup-isEmbed" style="display: none;">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" id="is_embed" name="is_embed" />
                            <label class="form-check-label" for="is_embed"></label>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-3 hide-format hide-linkEmbed" id="iGroup-embed" style="display: none;">
                        <label class="col-form-label required fw-bold fs-6" for="embed">Embed</label>
                        <div class="ratio ratio-16x9 mb-3" id="embedShow" style="display: none;"></div>
                        <textarea type="text" class="form-control form-control-solid" name="embed" id="embed" rows="8" placeholder="Isi kode embed ..." ></textarea>
                        <div class="form-text">*) Salin dan tempelkan kode embed media.</div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-3 hide-format hide-linkEmbed" id="iGroup-linkMedia" style="display: none;">
                        <label class="col-form-label required fw-bold fs-6" for="link_media">Link</label>
                        <div class="ratio ratio-16x9 mb-3" id="linkShow" style="display: none;"></div>
                        <textarea type="text" class="form-control form-control-solid" name="link_media" id="link_media" rows="4" style="resize: none;" placeholder="Isi link ..." ></textarea>
                        <div class="form-text">*) Salin dan tempelkan link url media</div>
                        <div class="form-text">*) Support saat ini: <code>Youtube</code></div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Gallery-->
                    <div class="mt-10 px-3 py-2 mb-3 hide-format rounded bg-opacity-5 border-dashed" id="listGallery" style="display: none;">
                        <input type="hidden" name="idGallery" />
                        <div class="d-flex flex-wrap justify-content-center align-items-center">
                            <div class="fw-bold fs-6" id="label-gallery"></div>
                            <div class="ms-auto" id="btn-gallery">
                                <button type="button" class="btn btn-sm btn-light btn-active-light-primary" id="btn-addGallery"><i class="las la-plus fs-3"></i> Tambah</button>
                                <button type="button" class="btn btn-sm btn-bg-light btn-color-danger hide-format" id="btn-closeAddGallery" style="display: none;"><i class="fas fa-close"></i> Tutup</button>
                            </div>
                        </div>
                        <div class="row hide-format" id="row-addGallery" style="display: none;">
                            <div class="col-md-12 mb-3">
                                <!--begin::Input group-->
                                <div class="mb-3" id="iGroup-fileGallery">
                                    <label class="col-form-label required fw-bold fs-6" for="file_gallery">File</label>
                                    <input type="file" class="form-control" id="file_gallery" name="file_gallery" accept=".png, .jpg, .jpeg" data-msg-placeholder="Pilih {files}...">
                                    <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                                    <div class="form-text">*) Max. size file: <code>2MB</code></div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-3">
                                    <label class="col-form-label fw-bold fs-6" for="caption_gallery">Caption</label>
                                    <input type="text" class="form-control form-control-solid" name="caption_gallery" id="caption_gallery" maxlength="100" placeholder="Isi caption file ..." />
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-sm btn-bg-light btn-color-danger me-1" id="btn-resetAddGallery"><i class="las la-redo-alt"></i> Batal</button>
                                <button type="button" class="btn btn-sm btn-primary" id="btn-saveGallery"><i class="las la-save"></i> Simpan</button>
                            </div>
                        </div>
                        <div class="row g-2 mt-3" id="row-listGallery"></div>
                    </div>
                    <!--end::Gallery-->
                    <!--begin::Input group-->
                    <div class="mb-3">
                        <label class="col-form-label required fw-bold fs-6" for="cbo_category">Kategori</label>
                        <div class="row g-0">
                            <div class="col-lg-10 col-10">
                                <select class="form-select" name="cbo_category" id="cbo_category"></select>
                                <div class="form-text">*) Ketik kategori untuk mempercepat pencarian</div>
                            </div>
                            <div class="col-lg-2 col-2">
                                <button type="button" class="btn btn-light btn-active-light-primary" onclick="_addOptionSelect2('cbo_category');" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Tambahkan item Kategori?"><i class="las la-plus fs-3"></i></button>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-3">
                        <label class="col-form-label required fw-bold fs-6" for="keyword">Keyword/ Kata Kunci</label>
                        <select class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="keyword" name="keyword[]" multiple></select>
                        <div class="form-text">*) Pisahkan keyword dengan tanda koma, <br/>Contoh: <code>web bp2td mempawah, mempawah, kalimantan</code></div>
                        <div class="form-text">*) Maksimal: <code>10</code> kata kunci</div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-3" id="iGroup-thumb">
                        <label class="col-form-label required fw-bold fs-6">Thumbnail</label>
                        <input type="file" class="dropify-upl mb-3 mb-lg-0" id="thumb" name="thumb" accept=".png, .jpg, .jpeg" data-show-remove="false" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M" />
                        <div class="form-text">*) Type file: <code>*.jpeg | *.jpeg | *.png</code></div>
                        <div class="form-text">*) Max. size file: <code>2MB</code></div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-3" id="iGroup-isPublic" style="display: none;">
                        <label class="col-form-label fw-bold fs-6" for="is_public">Status</label>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" id="is_public" name="is_public" />
                            <label class="form-check-label" for="is_public"></label>
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
            <button type="button" class="btn btn-light btn-active-light-danger me-2" id="btn-reset" onclick="_clearFormPost();"><i class="las la-redo-alt fs-1 me-3"></i>Batal</button>
            <button type="button" class="btn btn-primary" id="btn-save"><i class="las la-save fs-1 me-3"></i>Simpan</button>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->
</div>
<!--end::Card Form-->
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
<!--begin::List Table Data-->
<div class="card shadow" id="card-dtPosts">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">
            <h3 class="fw-bolder fs-2 text-gray-900">
                <i class="fas fa-th-list fs-2 text-gray-900 me-2"></i> Konten Postingan
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary" id="btn-addPost" onclick="_addPost();"><i class="las la-plus fs-3"></i> Tambah</button>
            </div>
        </div>
    </div>
    <!--end::Card header-->
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-center align-items-center mb-5">
            <!--begin::Row-->
            <div class="row justify-content-center align-items-center m-0 mb-md-0 mb-5">
                <div class="col-lg-12 col-sm-12 px-0">
                    <select class="show-tick form-control form-control-sm form-select-solid selectpicker" data-width="150px" data-style="btn-sm btn-secondary" name="filter-dtPosts" id="filter-dtPosts" data-container="body" title="Filter data berdasarkan ...">
                        <option value="all" selected>SEMUA</option>
                        <option value="public">PUBLIK</option>
                        <option value="draft">DRAFT</option>
                        <option value="trash">SAMPAH</option>
                    </select>
                </div>
            </div>
            <!--end::Row-->
            <div class="ms-auto">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative mb-md-0 mb-3">
                    <div class="input-group input-group-sm input-group-solid border">
                        <span class="input-group-text"><i class="las la-search fs-3"></i></span>
                        <input type="text" class="form-control form-control-sm form-control-solid border-left-0" name="search-dtPosts" id="search-dtPosts" placeholder="Pencarian..." />
                        <span class="input-group-text border-left-0 cursor-pointer text-hover-danger" id="clear-searchDtPosts" style="display: none;">
                            <i class="las la-times fs-3"></i>
                        </span>
                    </div>
                </div>
                <!--end::Search-->
            </div>
        </div>
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table table-rounded align-middle table-row-bordered border" id="dt-posts">
                <thead>
                    <tr class="fw-bolder text-uppercase bg-light">
                        <th class="text-center align-middle px-2 border-bottom-2 border-gray-200">No.</th>
                        <th class="align-middle px-2 border-bottom-2 border-gray-200">Post</th> <!-- Thumb, Judul -->
                        <th class="align-middle px-2 border-bottom-2 border-gray-200">Kategori</th>
                        <th class="align-middle px-2 border-bottom-2 border-gray-200">Views</th>
                        <th class="align-middle px-2 border-bottom-2 border-gray-200">Active</th>
                        <th class="align-middle px-2 border-bottom-2 border-gray-200">Created</th> <!-- User, dan Waktu -->
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