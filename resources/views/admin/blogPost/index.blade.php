@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')

    <li class="breadcrumb-item active"><a>Buletin</a></li>
@endsection

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="card card-outline card-danger">
        <div class="card-header">
            <button class="btn btn-info float-right text-white btn-sm" onclick="createData()">CREATE</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Tags</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Blog Post</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="form-create" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" required>
                        </div>

                        <div class="form-group">
                            <label>Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control-file" name="image" accept="image/*" required>
                            <small class="text-muted">Max size: 2MB, Format: PNG, JPG, JPEG</small>
                        </div>

                        <div class="form-group">
                            <label>Content <span class="text-danger">*</span></label>
                            <div id="editor" style="height: 200px;"></div>
                        </div>

                        <div class="form-group">
                            <label>Tags <span class="text-danger">*</span></label>
                            <select class="form-control" name="tags" id="tags-select" multiple="multiple" required>
                            </select>
                            <small class="text-muted">Type to add new tags or select existing ones</small>
                        </div>

                        <div class="form-group">
                            <label>Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="id_category" required>
                                <option value="">Select Category</option>
                                <!-- Options will be loaded dynamically from API -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                <option value="">Select Status</option>
                                <option value="DRAFT">Draft</option>
                                <option value="PUBLISHED">Published</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let quill;
        let isEditMode = false;
        let editId = null;

        $('#datatable-crud').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            scrollX: true,
            ajax: {
                url: "/admin/blog-post/get",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title',
                    render: function(data, type, row) {
                        // Truncate title
                        let title = data || '';
                        let truncated = title.length > 50 ? title.substring(0, 100) + '...' : title;

                        // Return dengan styling dan tooltip
                        return '<div style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' +
                            title.replace(/"/g, '&quot;') + '">' + truncated + '</div>';
                    }
                },
                {
                    data: 'content',
                    name: 'content',
                    orderable: false,
                    render: function(data, type, row) {
                        let rawContent = row.content || data || '';
                        let plainText = extractTextFromQuill(rawContent);

                        let truncated = plainText.length > 60 ? plainText.substring(0, 60) + '...' :
                            plainText;

                        return '<div style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' +
                            plainText.replace(/"/g, '&quot;') + '">' + truncated + '</div>';
                    }
                },
                {
                    data: 'tags',
                    name: 'tags',
                    orderable: false
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'category',
                    name: 'category',
                    render: function(data) {
                        if (!data) return '';
                        return '<strong>' + data.toUpperCase() + '</strong>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Function untuk load categories dari API
        function loadCategories() {
            $.ajax({
                url: '/category/post/getData?is_public=1',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    let categorySelect = $('select[name="id_category"]');
                    
                    // Clear existing options except the first one
                    categorySelect.find('option:not(:first)').remove();
                    
                    // Add categories from API
                    if (response.data && Array.isArray(response.data)) {
                        response.data.forEach(function(category) {
                            let optionValue = category.id;
                            let optionText = (category.name || category.title || category.slug).toUpperCase();
                            
                            categorySelect.append(
                                $('<option></option>')
                                    .attr('value', optionValue)
                                    .text(optionText)
                            );
                        });
                    } else if (response && Array.isArray(response)) {
                        // If response is directly an array
                        response.forEach(function(category) {
                            let optionValue = category.id;
                            let optionText = (category.name || category.title || category.slug).toUpperCase();
                            
                            categorySelect.append(
                                $('<option></option>')
                                    .attr('value', optionValue)
                                    .text(optionText)
                            );
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to load categories:', error);
                    
                    // Keep default options as fallback
                    let categorySelect = $('select[name="id_category"]');
                    if (categorySelect.find('option').length === 1) {
                        categorySelect.append('<option value="1">ACARA</option>');
                        categorySelect.append('<option value="2">PENGUMUMAN</option>');
                    }
                }
            });
        }

        // Function untuk extract plain text dari Quill content
        function extractTextFromQuill(content) {
            try {
                // Jika content adalah JSON dari Quill
                if (content && content.trim().startsWith('{')) {
                    const delta = JSON.parse(content);
                    let text = '';

                    if (delta.ops) {
                        delta.ops.forEach(op => {
                            if (typeof op.insert === 'string') {
                                text += op.insert;
                            }
                        });
                    }

                    return text.trim();
                }

                // Jika bukan JSON, return as is (remove HTML tags)
                return content.replace(/<[^>]*>/g, '').trim();
            } catch (e) {
                // Fallback: remove HTML tags
                return content.replace(/<[^>]*>/g, '').trim();
            }
        }

        function createData() {
            isEditMode = false;
            editId = null;

            // Reset form
            $('#form-create')[0].reset();
            $('.modal-title').text('Create Blog Post');
            $('input[name="image"]').prop('required', true);

            // Load categories from API
            loadCategories();

            $('#modal-create').modal('show');

            // Initialize Quill when modal opens
            $('#modal-create').on('shown.bs.modal', function() {
                if (!quill) {
                    quill = new Quill('#editor', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{
                                    'header': [1, 2, 3, false]
                                }],
                                ['bold', 'italic', 'underline'],
                                ['link', 'blockquote', 'code-block'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                ['clean']
                            ]
                        }
                    });
                } else {
                    // Clear content jika sudah ada
                    quill.setContents([]);
                }

                // Initialize Select2 for tags
                if (!$('#tags-select').hasClass('select2-hidden-accessible')) {
                    $('#tags-select').select2({
                        tags: true,
                        tokenSeparators: [','],
                        placeholder: "Type to add tags",
                        allowClear: true,
                        createTag: function(params) {
                            return {
                                id: params.term.trim(),
                                text: params.term.trim(),
                                newTag: true
                            };
                        }
                    });
                } else {
                    // Clear existing tags
                    $('#tags-select').val(null).trigger('change');
                }
            });
        }

        function editData(id) {
            isEditMode = true;
            editId = id;

            $.ajax({
                url: `/admin/blog-post/get?id=${id}`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // Update modal title
                    $('.modal-title').text('Edit Blog Post');
                    $('input[name="image"]').prop('required', false);

                    // Load categories first, then populate form
                    loadCategories();

                    // Populate form dengan data
                    $('input[name="title"]').val(data.title);
                    $('select[name="status"]').val(data.status);
                    
                    // Set category after loading categories
                    setTimeout(function() {
                        // Use id_category from the data or from category relationship
                        let categoryId = data.id_category || (data.category ? data.category.id : null);
                        if (categoryId) {
                            $('select[name="id_category"]').val(categoryId);
                        }
                    }, 500);

                    $('#modal-create').modal('show');

                    // Initialize dan populate data setelah modal terbuka
                    $('#modal-create').on('shown.bs.modal', function() {
                        // Initialize Quill jika belum ada
                        if (!quill) {
                            quill = new Quill('#editor', {
                                theme: 'snow',
                                modules: {
                                    toolbar: [
                                        [{
                                            'header': [1, 2, 3, false]
                                        }],
                                        ['bold', 'italic', 'underline'],
                                        ['link', 'blockquote', 'code-block'],
                                        [{
                                            'list': 'ordered'
                                        }, {
                                            'list': 'bullet'
                                        }],
                                        ['clean']
                                    ]
                                }
                            });
                        }

                        // Set Quill content
                        if (data.content) {
                            try {
                                // Jika content adalah JSON dari Quill
                                let contentData = JSON.parse(data.content);
                                quill.setContents(contentData);
                            } catch (e) {
                                // Jika content bukan JSON, set sebagai plain text
                                quill.setText(data.content);
                            }
                        }

                        // Initialize Select2 untuk tags
                        if (!$('#tags-select').hasClass('select2-hidden-accessible')) {
                            $('#tags-select').select2({
                                tags: true,
                                tokenSeparators: [','],
                                placeholder: "Type to add tags",
                                allowClear: true,
                                createTag: function(params) {
                                    return {
                                        id: params.term.trim(),
                                        text: params.term.trim(),
                                        newTag: true
                                    };
                                }
                            });
                        }

                        // Populate tags
                        let tags = JSON.parse(data.tags || '[]');
                        $('#tags-select').empty();
                        tags.forEach(tag => {
                            $('#tags-select').append(new Option(tag, tag, true, true));
                        });
                        $('#tags-select').trigger('change');
                    });
                },
                error: function() {
                    alert('Failed to load blog post data');
                }
            });
        }

        function deleteData(id) {
            if (confirm('Are you sure you want to delete this blog post?')) {
                $.ajax({
                    url: `/admin/blog-post/delete/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#datatable-crud').DataTable().ajax.reload();
                        alert('Blog post deleted successfully!');
                    },
                    error: function() {
                        alert('Failed to delete blog post');
                    }
                });
            }
        }

        // Handle form submission
        $('#form-create').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData();

            // Get form data
            formData.append('title', $('input[name="title"]').val());

            // Get Quill content as JSON
            let content = JSON.stringify(quill.getContents());
            formData.append('content', content);

            formData.append('status', $('select[name="status"]').val());
            formData.append('id_category', $('select[name="id_category"]').val());

            // Handle tags from Select2
            let selectedTags = $('#tags-select').val();
            if (selectedTags && selectedTags.length > 0) {
                selectedTags.forEach(tag => {
                    formData.append('tags[]', tag);
                });
            }

            // Handle image
            let imageFile = $('input[name="image"]')[0].files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            // Determine URL based on edit mode
            let url = isEditMode ? `/admin/blog-post/update/${editId}` : '/admin/blog-post/store';

            if (isEditMode) {
                formData.append('_method', 'POST');
            }

            // Show loading state
            let submitBtn = $(this).find('button[type="submit"]');
            let originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#modal-create').modal('hide');
                    $('#form-create')[0].reset();

                    // Reset form state
                    isEditMode = false;
                    editId = null;

                    // Reload DataTable
                    $('#datatable-crud').DataTable().ajax.reload();

                    let message = isEditMode ? 'Blog post updated successfully!' :
                        'Blog post created successfully!';
                    alert(message);
                },
                error: function(xhr) {
                    let message = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    alert('Error: ' + message);
                },
                complete: function() {
                    // Restore button state
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Clean up when modal closes
        $('#modal-create').on('hidden.bs.modal', function() {
            // Destroy Select2 if exists
            if ($('#tags-select').hasClass('select2-hidden-accessible')) {
                $('#tags-select').select2('destroy');
            }

            // Remove event listeners to prevent duplicate
            $(this).off('shown.bs.modal');

            // Reset form state
            isEditMode = false;
            editId = null;
        });

        // Load categories on page ready
        $(document).ready(function() {
            loadCategories();
        });
    </script>
@endpush