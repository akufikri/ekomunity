<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carta Organisasi</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/template_dashboard/plugins/fontawesome-free/css/all.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/template_dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/template_dashboard/dist/css/adminlte.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/template_dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #orgChart {
            width: 100%;
            height: 600px;
            background: white;
            border-radius: 8px;
            overflow: auto;
            padding: 20px;
            position: relative;
        }

        @media (max-width: 1024px) {
            #orgChart {
                height: 550px;
                padding: 18px;
            }
        }

        @media (max-width: 768px) {
            #orgChart {
                height: 450px;
                padding: 12px;
            }
        }

        @media (max-width: 576px) {
            #orgChart {
                height: 400px;
                padding: 10px;
                overflow-x: auto;
                overflow-y: auto;
            }
        }

        .org-node {
            background: #D9D9D9;
            border: 2px solid #34495e;
            border-radius: 8px;
            padding: 15px 20px;
            margin: 20px;
            display: inline-block;
            position: absolute;
            min-width: 120px;
            text-align: center;
            font-weight: bold;
            color: #2c3e50;
            cursor: pointer;
            z-index: 10;
        }

        .org-node::before {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            right: -15px;
            bottom: -15px;
            z-index: -1;
        }

        .org-node .position-title {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .org-node .person-name {
            font-size: 11px;
            color: #7f8c8d;
            font-weight: normal;
        }

        .org-node.selected {
            border-color: #e74c3c;
            box-shadow: 0 0 10px rgba(231, 76, 60, 0.5);
        }

        .org-connection {
            position: absolute;
            border-left: 2px solid #3498db;
            z-index: 5;
        }

        .org-connection-h {
            position: absolute;
            border-top: 2px solid #3498db;
            z-index: 5;
        }

        .diagram-controls {
            margin-bottom: 0px;
        }

        @media (max-width: 768px) {
            .org-node {
                padding: 12px 15px;
                margin: 15px;
                min-width: 100px;
                font-size: 12px;
            }

            .org-node .position-title {
                font-size: 11px;
            }

            .org-node .person-name {
                font-size: 10px;
            }
        }

        @media (max-width: 576px) {
            .org-node {
                padding: 10px 12px;
                margin: 12px;
                min-width: 80px;
                font-size: 11px;
            }

            .org-node .position-title {
                font-size: 10px;
                margin-bottom: 2px;
            }

            .org-node .person-name {
                font-size: 9px;
            }

            .diagram-controls {
                margin-bottom: 0px;
            }

            .btn-group .btn {
                font-size: 10px;
                padding: 4px 8px;
            }
        }
    </style>
</head>

<body>
    <ul class="breadcrumb bg-white shadow-sm"
        style="height: 70px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <a href="/carta-organisasi" class="btn btn-danger shadow-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </ul>
    <section>
        {{-- <div style="display: flex; align-items:center; justify-content:space-between; margin-bottom:20px">
            <div class="diagram-controls">
                <div class="btn-group" role="group">
                    <a href="/carta-organisasi" class="btn btn-sm btn-info">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div> --}}
        <div class="diagram-container">
            <div id="orgChart"></div>
        </div>

        <!-- Edit Position Modal -->
        <div class="modal fade" id="editPositionModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Position</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editPositionForm">
                            <div class="form-group">
                                <label for="positionTitle">Position Title</label>
                                <input type="text" class="form-control" id="positionTitle"
                                    placeholder="Enter position title" required>
                            </div>
                            <div class="form-group">
                                <label for="personName">Person Name</label>
                                <select class="form-control" id="personName" required>
                                    <option value="">Select person</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="savePositionBtn">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/template_dashboard/dist/js/adminlte.min.js"></script>
    <script src="/template_dashboard/plugins/chart.js/Chart.min.js"></script>
    <script src="/js/my-custom.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script type="text/javascript" src="/js/config-firebase.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var positionCounter = 1;
            var selectedNode = null;
            var orgData = [];
            var chartId = new URLSearchParams(window.location.search).get('id');
            var chartReady = false;

            function renderChart() {
                $('#orgChart').empty();

                var containerWidth = $('#orgChart').width() - 40;
                var containerHeight = $('#orgChart').height() - 40;

                if (orgData.length === 0) return;

                var levels = {};

                orgData.forEach(function(item) {
                    var level = getLevel(item.id);
                    console.log('Item:', item.title, 'Level:', level, 'ParentId:', item.parentId);
                    if (!levels[level]) levels[level] = [];
                    levels[level].push(item);
                });

                Object.keys(levels).forEach(function(level) {
                    var nodes = levels[level];

                    var screenWidth = $(window).width();
                    var nodeWidth, verticalSpacing, startPadding, minSpacing;

                    if (screenWidth <= 576) {
                        nodeWidth = Math.min(120, Math.max(80, (containerWidth - 40) / Math.max(nodes
                            .length, 1) - 10));
                        verticalSpacing = 90;
                        startPadding = 10;
                        minSpacing = 5;
                    } else if (screenWidth <= 768) {
                        nodeWidth = Math.min(150, Math.max(100, (containerWidth - 60) / Math.max(nodes
                            .length, 1) - 15));
                        verticalSpacing = 110;
                        startPadding = 15;
                        minSpacing = 10;
                    } else if (screenWidth <= 1024) {
                        nodeWidth = Math.min(170, Math.max(120, (containerWidth - 80) / Math.max(nodes
                            .length, 1) - 20));
                        verticalSpacing = 130;
                        startPadding = 20;
                        minSpacing = 15;
                    } else {
                        nodeWidth = 180;
                        verticalSpacing = 140;
                        startPadding = 20;
                        minSpacing = 20;
                    }

                    var totalSpacing = (nodes.length - 1) * minSpacing;
                    var totalWidth = (nodes.length * nodeWidth) + totalSpacing;
                    var startX = Math.max(startPadding, (containerWidth - totalWidth) / 2);

                    nodes.forEach(function(node, index) {
                        node.x = startX + (index * (nodeWidth + minSpacing));
                        node.y = parseInt(level) * verticalSpacing + 40;
                    });
                });

                orgData.forEach(function(item) {
                    if (item.parentId) {
                        var parent = orgData.find(p => p.id === item.parentId);
                        if (parent) {
                            var screenWidth = $(window).width();
                            var nodeEstimatedWidth, nodeEstimatedHeight;

                            if (screenWidth <= 576) {
                                nodeEstimatedWidth = 120;
                                nodeEstimatedHeight = 60;
                            } else if (screenWidth <= 768) {
                                nodeEstimatedWidth = 140;
                                nodeEstimatedHeight = 70;
                            } else {
                                nodeEstimatedWidth = 160;
                                nodeEstimatedHeight = 80;
                            }

                            var parentCenterX = parent.x + (nodeEstimatedWidth / 2);
                            var parentBottomY = parent.y + nodeEstimatedHeight;
                            var childCenterX = item.x + (nodeEstimatedWidth / 2);
                            var childTopY = item.y;

                            var verticalGap = childTopY - parentBottomY;
                            var midY = parentBottomY + (verticalGap / 2);

                            if (verticalGap > 10) {
                                $('<div class="org-connection"></div>').css({
                                    left: parentCenterX - 1,
                                    top: parentBottomY,
                                    height: verticalGap / 2
                                }).appendTo('#orgChart');

                                var minX = Math.min(parentCenterX, childCenterX);
                                var maxX = Math.max(parentCenterX, childCenterX);

                                if (Math.abs(maxX - minX) > 5) {
                                    $('<div class="org-connection-h"></div>').css({
                                        left: minX,
                                        top: midY - 1,
                                        width: maxX - minX + 2
                                    }).appendTo('#orgChart');
                                }

                                $('<div class="org-connection"></div>').css({
                                    left: childCenterX - 1,
                                    top: midY,
                                    height: (verticalGap / 2) + 1
                                }).appendTo('#orgChart');
                            }
                        }
                    }
                });

                orgData.forEach(function(item) {
                    var nodeHtml = '<div class="position-title">' + item.title + '</div>' +
                        '<div class="person-name">' + item.name + '</div>';

                    var node = $('<div class="org-node" data-id="' + item.id + '">' + nodeHtml + '</div>');
                    node.css({
                        left: item.x,
                        top: item.y
                    });

                    node.click(function(e) {
                        $('.org-node').removeClass('selected');
                        $(this).addClass('selected');
                        selectedNode = item;
                    });

                    $('#orgChart').append(node);
                });
            }

            function getLevel(id, level = 0) {
                var item = orgData.find(i => i.id === id);
                if (!item) return level;
                if (!item.parentId) return level;
                return getLevel(item.parentId, level + 1);
            }

            function loadPersonData() {
                $.ajax({
                    url: '/carta-organisasi/getAhli',
                    method: 'GET',
                    beforeSend: function() {
                        $('#personName').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#personName').empty();
                            $('#personName').append('<option value="">Select person</option>');

                            response.data.forEach(function(person) {
                                $('#personName').append(
                                    '<option value="' + person.id + '">' + person.fullname +
                                    '</option>'
                                );
                            });

                            if (!$('#personName').hasClass('select2-hidden-accessible')) {
                                $('#personName').select2({
                                    dropdownParent: $('#editPositionModal'),
                                    width: '100%'
                                });
                            } else {
                                $('#personName').trigger('change.select2');
                            }
                        }
                    },
                    complete: function() {
                        $('#personName').prop('disabled', false);
                    }
                });
            }

            function loadPersonDataAndSetValue(selectedPersonId) {
                $.ajax({
                    url: '/carta-organisasi/getAhli',
                    method: 'GET',
                    beforeSend: function() {
                        $('#personName').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#personName').empty();
                            $('#personName').append('<option value="">Select person</option>');

                            response.data.forEach(function(person) {
                                $('#personName').append(
                                    '<option value="' + person.id + '">' + person.fullname +
                                    '</option>'
                                );
                            });

                            if (!$('#personName').hasClass('select2-hidden-accessible')) {
                                $('#personName').select2({
                                    dropdownParent: $('#editPositionModal'),
                                    width: '100%'
                                });
                            }

                            if (selectedPersonId) {
                                $('#personName').val(selectedPersonId).trigger('change');
                            }
                        }
                    },
                    complete: function() {
                        $('#personName').prop('disabled', false);
                    }
                });
            }

            function loadChartData() {
                var requestData = {};
                if (chartId) {
                    requestData.chart_id = chartId;
                }

                $.ajax({
                    url: '/carta-organisasi/getData',
                    method: 'GET',
                    data: requestData,
                    success: function(response) {
                        if (response.success && response.data.length > 0) {
                            orgData = response.data;
                            chartId = response.chart_id;
                            chartReady = true;
                            renderChart();
                        } else {
                            initializeDefaultChart();
                        }
                    },
                    error: function(xhr) {
                        initializeDefaultChart();
                    }
                });
            }

            function initializeDefaultChart() {
                var authUser = window.authUser || {
                    fullname: "Select person",
                    id: null
                };

                orgData = [{
                    id: 1,
                    title: "President",
                    name: authUser.fullname,
                    personId: authUser.id,
                    parentId: null,
                    x: 300,
                    y: 50
                }];
                renderChart();
            }

            function validatePositionData(title, personId) {
                const errors = [];

                if (!title || title.trim().length === 0) {
                    errors.push('Position title is required');
                }

                if (title && title.trim().length > 255) {
                    errors.push('Position title must be less than 255 characters');
                }

                if (!personId) {
                    errors.push('Please select a person for this position');
                }

                return errors;
            }

            $('#savePositionBtn').click(function() {
                var title = $('#positionTitle').val().trim();
                var personId = $('#personName').val();
                var personName = $('#personName option:selected').text();

                var errors = validatePositionData(title, personId);

                if (errors.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errors.join('<br>')
                    });
                    return;
                }

                if (window.currentEditingItem) {
                    $(this).prop('disabled', true).text('Saving...');

                    $.ajax({
                        url: '/carta-organisasi/update/' + window.currentEditingItem.id,
                        method: 'PUT',
                        data: {
                            position_title: title,
                            user_id: personId,
                            position_x: window.currentEditingItem.x,
                            position_y: window.currentEditingItem.y,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                window.currentEditingItem.title = title;
                                window.currentEditingItem.personId = personId;
                                window.currentEditingItem.name = personName;

                                $('#editPositionModal').modal('hide');
                                renderChart();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Position updated successfully',
                                    timer: 5000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message ||
                                        'Failed to update position'
                                });
                            }
                        },
                        error: function(xhr) {
                            var message = 'Failed to update position';
                            if (xhr.responseJSON) {
                                if (xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                } else if (xhr.responseJSON.errors) {
                                    var errors = [];
                                    Object.values(xhr.responseJSON.errors).forEach(function(
                                        error) {
                                        errors = errors.concat(error);
                                    });
                                    message = errors.join('<br>');
                                }
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: message
                            });
                        },
                        complete: function() {
                            $('#savePositionBtn').prop('disabled', false).text('Save Changes');
                            window.currentEditingItem = null;
                        }
                    });
                }
            });

            $('#editPositionForm').submit(function(e) {
                e.preventDefault();
                $('#savePositionBtn').click();
            });

            $('#editPositionModal').on('hidden.bs.modal', function() {
                $('#editPositionForm')[0].reset();

                if ($('#personName').hasClass('select2-hidden-accessible')) {
                    $('#personName').val('').trigger('change');
                }

                window.currentEditingItem = null;
            });

            var resizeTimeout;
            $(window).resize(function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    renderChart();
                }, 250);
            });

            loadChartData();
        });
    </script>
</body>

</html>
