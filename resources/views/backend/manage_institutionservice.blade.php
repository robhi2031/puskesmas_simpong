@extends('backend.layouts', ['activeMenu' => 'INSTITUSI', 'activeSubMenu' => 'Jenis dan Jadwal Pelayanan'])
@section('content')
<!--begin::Content Page-->
<div class="card mb-5 mb-xl-10" id="card-formService">
    <!--begin::Edit-->
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start flex-wrap mb-10">
            <h3 class="fw-bolder m-0 mb-3"><i class="las la-pen text-dark fs-2 me-3"></i>Edit Halaman Jenis dan Jadwal Pelayanan</h3>
            <a href="javascript:history.back();" class="btn btn-sm btn btn-bg-light btn-color-danger ms-3"><i class="las la-undo fs-3"></i> Kembali</a>
        </div>
        <!--begin::Form-->
        <form id="form-editService" class="form" onsubmit="return false">
            <input type="hidden" name="id" />
            <!--begin::Input group-->
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-bold fs-6" for="title">Judul</label>
                <div class="col-lg-8">
                    <textarea type="text" class="form-control form-control-solid" name="title" id="title" maxlength="200" rows="3" style="resize: none;" placeholder="Isi judul halaman ..." ></textarea>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-bold fs-6" for="content">Isi Konten</label>
                <div class="col-lg-8">
                    <textarea class="form-control form-control-solid summernote" name="content" id="content"></textarea>
                </div>
            </div>
            <!--end::Input group-->
            <div class="row mt-5">
                <div class="col-lg-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-light btn-active-light-danger me-2" id="btn-reset"><i class="las la-redo-alt fs-1 me-3"></i>Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-save"><i class="las la-save fs-1 me-3"></i>Simpan</button>
                </div>
            </div>
        </form>
    </div>
    <!--end::Edit-->
</div>
<!--end::Content Page-->
@endsection