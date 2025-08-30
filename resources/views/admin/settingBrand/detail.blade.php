@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/setting-brand">Setting brand</a></li>
    <li class="breadcrumb-item active"><a>Setting</a></li>
@endsection

@section('content')
    <section>
        <div class="card card-outline card-info">
            <div class="card-header font-weight-bold">Hero Sections</div>
            <div class="card-body">
                <form action="">
                    <div class="mb-3 row">
                        <div class="col-md-4">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Type here..">
                        </div>
                        <div class="col-md-4">
                            <label for="logo">Logo</label>
                            <div style="display: flex; gap:4px">
                                <div>
                                    <div class="card card-bordered" id="imagePreview" style="width: 40px; height:40px">
                                        <div class="card-body p-0 overflow-hidden">
                                            <img src="" alt="Logo Brand" class="w-full h-full object-contain" />
                                        </div>
                                    </div>
                                </div>
                                <input type="file" name="title" id="title" class="form-control"
                                    placeholder="Type here..">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="btn-cta">Cta Button</label>
                            <input type="text" name="btn_cta" id="btn_cta" class="form-control" maxlength="30"
                                placeholder="Type here...">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-outline card-info">
            <div class="card-header font-weight-bold">Feature <button type="button" id="add-feature"
                    class="btn btn-primary btn-sm float-right">Add <i class="fa fa-plus"></i></button></div>
            <div class="card-body">
                <form action="">
                    <div id="feature-wrapper">
                        <div class="feature-item mb-3 border p-3 rounded">
                            <div class="mb-3">
                                <label>Title feature</label>
                                <input type="text" name="title_feature[]" class="form-control" placeholder="Type here..">
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description_feature[]" class="form-control" placeholder="Type here..."></textarea>
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger btn-sm remove-feature">Remove <i
                                        class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-outline card-info">
            <div class="card-header font-weight-bold">(FAQ)</div>
            <div class="card-body">
                <form action="">
                    <div class="mb-3">
                        <label for="title">Title Faq</label>
                        <input type="text" name="title_faq" id="">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function() {
            // Tambah form baru
            $("#add-feature").click(function() {
                let featureItem = `
                <div class="feature-item mb-3 border p-3 rounded">
                    <div class="mb-3">
                        <label>Title feature</label>
                        <input type="text" name="title_feature[]" class="form-control"
                            placeholder="Type here..">
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description_feature[]" class="form-control" placeholder="Type here..."></textarea>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-feature">Hapus</button>
                </div>`;
                $("#feature-wrapper").append(featureItem);
            });

            // Hapus form
            $(document).on("click", ".remove-feature", function() {
                $(this).closest(".feature-item").remove();
            });
        });
    </script>
@endpush
