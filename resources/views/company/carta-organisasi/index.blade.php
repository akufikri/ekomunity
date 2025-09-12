@extends('home')
@section('title-dashboard', 'Company')
@section('content')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Carta Organisasi</a></li>
@endsection

@push('custom-css')
    <style>
        #orgChart {
            width: 100%;
            height: 600px;
            background: white;
            border: 1px solid #BBB;
            border-radius: 8px;
            overflow: auto;
            padding: 20px;
            position: relative;
        }

        /* Responsive container adjustments */
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
            /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
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

        .add-btn {
            position: absolute;
            width: 28px;
            height: 28px;
            background: #28a745;
            color: white;
            border: 2px solid #ffffff;
            border-radius: 50%;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            z-index: 15;
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .add-btn:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .org-node:hover .add-btn,
        .add-btn:hover {
            opacity: 1;
            pointer-events: all;
        }

        .org-node:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .add-btn-bottom {
            bottom: -14px;
            left: 50%;
            margin-left: -14px;
        }

        .add-btn-right {
            right: -14px;
            top: 50%;
            margin-top: -14px;
        }

        .add-btn-left {
            left: -14px;
            top: 50%;
            margin-top: -14px;
        }

        /* Responsive node styling */
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

            .add-btn {
                width: 24px;
                height: 24px;
                font-size: 12px;
            }

            .add-btn-bottom {
                margin-left: -12px;
            }

            .add-btn-right {
                right: -12px;
                margin-top: -12px;
            }

            .add-btn-left {
                left: -12px;
                margin-top: -12px;
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

            .add-btn {
                width: 22px;
                height: 22px;
                font-size: 11px;
            }

            .add-btn-bottom {
                bottom: -11px;
                margin-left: -11px;
            }

            .add-btn-right {
                right: -11px;
                margin-top: -11px;
            }

            .add-btn-left {
                left: -11px;
                margin-top: -11px;
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
@endpush

@section('content')
    <section>
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items:center; justify-content:space-between; margin-bottom:20px">
                    <div class="diagram-controls">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info" id="deletePosition">
                                <i class="fas fa-trash"></i> DELETE
                            </button>
                            <button type="button" class="btn btn-sm btn-info" id="undoAction">
                                <i class="fas fa-undo"></i> UNDO
                            </button>
                            <button type="button" class="btn btn-sm btn-info" id="redoAction">
                                <i class="fas fa-redo"></i> REDO
                            </button>
                            {{-- <button type="button" class="btn btn-sm btn-info" id="saveChart">
                            <i class="fas fa-save"></i> SAVE
                        </button> --}}
                        </div>
                    </div>
                    <div>
                        <a href="/carta/organisasi/{{ $data->id }}" class="btn btn-info btn-sm">Preview</a>
                    </div>
                </div>
                <div class="diagram-container">
                    <div id="orgChart"></div>
                </div>
            </div>
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
@endsection

@push('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {
            var positionCounter = 1;
            var selectedNode = null;
            var orgData = [];
            var chartId = null; // Will be set after chart is created/loaded
            var chartReady = false; // Flag to track if chart is ready for operations

            // Undo/Redo functionality
            var undoStack = [];
            var redoStack = [];

            function saveState() {
                // Save current state to undo stack
                undoStack.push(JSON.parse(JSON.stringify(orgData)));

                // Limit undo stack to 10 states
                if (undoStack.length > 10) {
                    undoStack.shift();
                }

                // Clear redo stack when new action is performed
                redoStack = [];
                updateUndoRedoButtons();
            }

            function updateUndoRedoButtons() {
                $('#undoAction').prop('disabled', undoStack.length === 0);
                $('#redoAction').prop('disabled', redoStack.length === 0);
            }

            function renderChart() {
                $('#orgChart').empty();

                // Get container dimensions
                var containerWidth = $('#orgChart').width() - 40; // Account for padding
                var containerHeight = $('#orgChart').height() - 40;

                // If no data, return early
                if (orgData.length === 0) return;

                // Calculate positions for tree layout
                var levels = {};

                // Group by levels
                orgData.forEach(function(item) {
                    var level = getLevel(item.id);
                    console.log('Item:', item.title, 'Level:', level, 'ParentId:', item.parentId);
                    if (!levels[level]) levels[level] = [];
                    levels[level].push(item);
                });

                // Calculate responsive positions based on container size
                Object.keys(levels).forEach(function(level) {
                    var nodes = levels[level];

                    // Responsive spacing based on screen size
                    var screenWidth = $(window).width();
                    var nodeWidth, verticalSpacing, startPadding, minSpacing;

                    if (screenWidth <= 576) {
                        // Mobile - more compact
                        nodeWidth = Math.min(120, Math.max(80, (containerWidth - 40) / Math.max(nodes
                            .length, 1) - 10));
                        verticalSpacing = 90;
                        startPadding = 10;
                        minSpacing = 5;
                    } else if (screenWidth <= 768) {
                        // Tablet - medium spacing
                        nodeWidth = Math.min(150, Math.max(100, (containerWidth - 60) / Math.max(nodes
                            .length, 1) - 15));
                        verticalSpacing = 110;
                        startPadding = 15;
                        minSpacing = 10;
                    } else if (screenWidth <= 1024) {
                        // Medium desktop
                        nodeWidth = Math.min(170, Math.max(120, (containerWidth - 80) / Math.max(nodes
                            .length, 1) - 20));
                        verticalSpacing = 130;
                        startPadding = 20;
                        minSpacing = 15;
                    } else {
                        // Large desktop
                        nodeWidth = 180;
                        verticalSpacing = 140;
                        startPadding = 20;
                        minSpacing = 20;
                    }

                    // Calculate horizontal positioning with better spacing
                    var totalSpacing = (nodes.length - 1) * minSpacing;
                    var totalWidth = (nodes.length * nodeWidth) + totalSpacing;
                    var startX = Math.max(startPadding, (containerWidth - totalWidth) / 2);

                    nodes.forEach(function(node, index) {
                        node.x = startX + (index * (nodeWidth + minSpacing));
                        node.y = parseInt(level) * verticalSpacing + 40;
                    });
                });

                // Render connections first
                orgData.forEach(function(item) {
                    if (item.parentId) {
                        var parent = orgData.find(p => p.id === item.parentId);
                        if (parent) {
                            // Calculate responsive center positions based on screen size
                            var screenWidth = $(window).width();
                            var nodeEstimatedWidth, nodeEstimatedHeight;

                            if (screenWidth <= 576) {
                                // Mobile
                                nodeEstimatedWidth = 120;
                                nodeEstimatedHeight = 60;
                            } else if (screenWidth <= 768) {
                                // Tablet
                                nodeEstimatedWidth = 140;
                                nodeEstimatedHeight = 70;
                            } else {
                                // Desktop
                                nodeEstimatedWidth = 160;
                                nodeEstimatedHeight = 80;
                            }

                            var parentCenterX = parent.x + (nodeEstimatedWidth / 2);
                            var parentBottomY = parent.y + nodeEstimatedHeight;
                            var childCenterX = item.x + (nodeEstimatedWidth / 2);
                            var childTopY = item.y;

                            // Calculate vertical gap and midpoint
                            var verticalGap = childTopY - parentBottomY;
                            var midY = parentBottomY + (verticalGap / 2);

                            // Only draw connectors if there's enough space
                            if (verticalGap > 10) {
                                // Vertical line from parent down
                                $('<div class="org-connection"></div>').css({
                                    left: parentCenterX - 1,
                                    top: parentBottomY,
                                    height: verticalGap / 2
                                }).appendTo('#orgChart');

                                // Horizontal line connecting parent to child
                                var minX = Math.min(parentCenterX, childCenterX);
                                var maxX = Math.max(parentCenterX, childCenterX);

                                if (Math.abs(maxX - minX) > 5) { // Only draw if nodes are not aligned
                                    $('<div class="org-connection-h"></div>').css({
                                        left: minX,
                                        top: midY - 1,
                                        width: maxX - minX + 2
                                    }).appendTo('#orgChart');
                                }

                                // Vertical line down to child
                                $('<div class="org-connection"></div>').css({
                                    left: childCenterX - 1,
                                    top: midY,
                                    height: (verticalGap / 2) + 1
                                }).appendTo('#orgChart');
                            }
                        }
                    }
                });

                // Render nodes
                orgData.forEach(function(item) {
                    var nodeHtml = '<div class="position-title">' + item.title + '</div>' +
                        '<div class="person-name">' + item.name + '</div>' +
                        '<div class="add-btn add-btn-bottom" title="Add subordinate (below this position)">+</div>';

                    // Only add sibling buttons for non-root nodes
                    if (item.parentId !== null) {
                        nodeHtml +=
                            '<div class="add-btn add-btn-right" title="Add sibling (same level)">+</div>' +
                            '<div class="add-btn add-btn-left" title="Add sibling (same level)">+</div>';
                    }
                    var node = $('<div class="org-node" data-id="' + item.id + '">' + nodeHtml + '</div>');
                    node.css({
                        left: item.x,
                        top: item.y
                    });

                    node.click(function(e) {
                        // Don't trigger if clicking on add button
                        if ($(e.target).hasClass('add-btn')) return;

                        $('.org-node').removeClass('selected');
                        $(this).addClass('selected');
                        selectedNode = item;
                    });

                    node.dblclick(function(e) {
                        // Don't trigger if clicking on add button
                        if ($(e.target).hasClass('add-btn')) return;

                        // Don't allow editing root node (id = 1)
                        if (item.id === 1) {
                            alert('Root position cannot be edited');
                            return;
                        }

                        // Set current editing item
                        window.currentEditingItem = item;

                        // Populate modal with current values immediately
                        $('#positionTitle').val(item.title);

                        // Load person data for select2 and then set the selected value
                        loadPersonDataAndSetValue(item.personId);

                        // Show modal
                        $('#editPositionModal').modal('show');
                    });

                    // Add button event handlers
                    node.find('.add-btn-bottom').click(function(e) {
                        e.stopPropagation();
                        console.log('Bottom button clicked for item:', item.title, 'id:', item.id);
                        addNewPosition(item.id, 'subordinate'); // Add as child of this item
                    });

                    node.find('.add-btn-right, .add-btn-left').click(function(e) {
                        e.stopPropagation();
                        console.log('Side button clicked for item:', item.title, 'parentId:', item
                            .parentId);
                        addNewPosition(item.parentId, 'sibling'); // Add as sibling of this item
                    });

                    $('#orgChart').append(node);
                });
            }


            function getLevel(id, level = 0) {
                var item = orgData.find(i => i.id === id);
                if (!item) return level;
                if (!item.parentId) return level; // Root level
                return getLevel(item.parentId, level + 1); // Go up the tree
            }

            function getNextId() {
                return Math.max(...orgData.map(i => i.id)) + 1;
            }

            // Note: Add position functionality is now handled by individual + buttons on each card

            // Delete selected position
            $('#deletePosition').click(function() {
                if (!selectedNode) {
                    showAlert('warning', 'Please select a position to delete');
                    return;
                }

                if (!selectedNode.parentId) {
                    showAlert('error', 'Cannot delete the root position');
                    return;
                }

                // Check if position has children
                var hasChildren = orgData.some(function(item) {
                    return item.parentId === selectedNode.id;
                });

                var confirmMessage = hasChildren ?
                    'This position has subordinates. Deleting it will also delete all subordinates. Continue?' :
                    'Are you sure you want to delete this position?';

                if (!confirm(confirmMessage)) {
                    return;
                }

                // Show loading state
                $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> DELETING...');

                $.ajax({
                    url: '/carta-organisasi/delete/' + selectedNode.id,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            saveState(); // Save state for undo

                            // Remove the item and its children from local data
                            removeItemAndChildren(selectedNode.id);
                            selectedNode = null;
                            renderChart();

                            var message = response.deleted_count > 1 ?
                                `Position and ${response.deleted_count - 1} subordinates deleted successfully` :
                                'Position deleted successfully';

                            showAlert('success', message);
                        } else {
                            showAlert('error', response.message || 'Failed to delete position');
                        }
                    },
                    error: function(xhr) {
                        var message = 'Failed to delete position';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        showAlert('error', message);
                    },
                    complete: function() {
                        $('#deletePosition').prop('disabled', false).html(
                            '<i class="fas fa-trash"></i> DELETE');
                    }
                });
            });

            function removeItemAndChildren(itemId) {
                // Find all children recursively
                var toRemove = [itemId];
                var found = true;

                while (found) {
                    found = false;
                    orgData.forEach(function(item) {
                        if (toRemove.includes(item.parentId) && !toRemove.includes(item.id)) {
                            toRemove.push(item.id);
                            found = true;
                        }
                    });
                }

                // Remove all items
                orgData = orgData.filter(function(item) {
                    return !toRemove.includes(item.id);
                });
            }

            // Undo functionality
            $('#undoAction').click(function() {
                if (undoStack.length > 0) {
                    // Save current state to redo stack
                    redoStack.push(JSON.parse(JSON.stringify(orgData)));

                    // Restore previous state
                    orgData = undoStack.pop();
                    selectedNode = null;
                    renderChart();
                    updateUndoRedoButtons();
                }
            });

            // Redo functionality
            $('#redoAction').click(function() {
                if (redoStack.length > 0) {
                    // Save current state to undo stack
                    undoStack.push(JSON.parse(JSON.stringify(orgData)));

                    // Restore next state
                    orgData = redoStack.pop();
                    selectedNode = null;
                    renderChart();
                    updateUndoRedoButtons();
                }
            });

            // Save chart functionality
            $('#saveChart').click(function() {
                if (orgData.length === 0) {
                    showAlert('warning', 'No data to save');
                    return;
                }

                // Show loading state
                $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> SAVING...');

                // Prepare data for API
                var structuresData = orgData.map(function(item) {
                    return {
                        id: item.id,
                        title: item.title,
                        personId: item.personId,
                        parentId: item.parentId,
                        x: item.x,
                        y: item.y
                    };
                });

                $.ajax({
                    url: '/carta-organisasi/save',
                    method: 'POST',
                    data: {
                        chart_id: chartId,
                        structures: structuresData,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showAlert('success', 'Chart saved successfully!');
                            // Reload chart data to get updated IDs
                            loadChartData();
                        } else {
                            showAlert('error', response.message || 'Failed to save chart');
                        }
                    },
                    error: function(xhr) {
                        var message = 'Failed to save chart';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.errors) {
                                var errors = [];
                                Object.values(xhr.responseJSON.errors).forEach(function(error) {
                                    errors = errors.concat(error);
                                });
                                message = errors.join('<br>');
                            }
                        }
                        showAlert('error', message, false);
                    },
                    complete: function() {
                        $('#saveChart').prop('disabled', false).html(
                            '<i class="fas fa-save"></i> SAVE');
                    }
                });
            });

            // Function to load person data from API
            function loadPersonData() {
                $.ajax({
                    url: '/carta-organisasi/getAhli',
                    method: 'GET',
                    beforeSend: function() {
                        // Show loading state
                        $('#personName').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            // Clear existing options
                            $('#personName').empty();
                            $('#personName').append('<option value="">Select person</option>');

                            // Add options from API
                            response.data.forEach(function(person) {
                                $('#personName').append(
                                    '<option value="' + person.id + '">' + person.fullname +
                                    '</option>'
                                );
                            });

                            // Initialize or refresh Select2
                            if (!$('#personName').hasClass('select2-hidden-accessible')) {
                                $('#personName').select2({
                                    dropdownParent: $('#editPositionModal'),
                                    width: '100%'
                                });
                            } else {
                                $('#personName').trigger('change.select2');
                            }
                        } else {
                            showAlert('error', response.message || 'Failed to load person data');
                        }
                    },
                    error: function(xhr) {
                        var message = 'Failed to load person data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        showAlert('error', message);
                    },
                    complete: function() {
                        $('#personName').prop('disabled', false);
                    }
                });
            }

            // Function to load person data and set selected value
            function loadPersonDataAndSetValue(selectedPersonId) {
                $.ajax({
                    url: '/carta-organisasi/getAhli',
                    method: 'GET',
                    beforeSend: function() {
                        // Show loading state
                        $('#personName').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            // Clear existing options
                            $('#personName').empty();
                            $('#personName').append('<option value="">Select person</option>');

                            // Add options from API
                            response.data.forEach(function(person) {
                                $('#personName').append(
                                    '<option value="' + person.id + '">' + person.fullname +
                                    '</option>'
                                );
                            });

                            // Initialize or refresh Select2
                            if (!$('#personName').hasClass('select2-hidden-accessible')) {
                                $('#personName').select2({
                                    dropdownParent: $('#editPositionModal'),
                                    width: '100%'
                                });
                            }

                            // Set the selected value after options are loaded
                            if (selectedPersonId) {
                                $('#personName').val(selectedPersonId).trigger('change');
                            }
                        } else {
                            showAlert('error', response.message || 'Failed to load person data');
                        }
                    },
                    error: function(xhr) {
                        var message = 'Failed to load person data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        showAlert('error', message);
                    },
                    complete: function() {
                        $('#personName').prop('disabled', false);
                    }
                });
            }

            // Function to load chart data from API
            function loadChartData() {
                var requestData = {};
                if (chartId) {
                    requestData.chart_id = chartId;
                }

                $.ajax({
                    url: '/carta-organisasi/getData',
                    method: 'GET',
                    data: requestData,
                    beforeSend: function() {
                        // Show loading state
                        showAlert('info', 'Loading chart data...');
                    },
                    success: function(response) {
                        if (response.success && response.data.length > 0) {
                            orgData = response.data;
                            chartId = response.chart_id; // Set the actual chart ID from response
                            chartReady = true;
                            renderChart();
                            showAlert('success', 'Chart data loaded successfully');
                        } else {
                            // No existing chart found, initialize with authenticated user
                            showAlert('info', 'No existing chart found. Creating default structure...');
                            initializeDefaultChart();

                            // Auto-save the default chart immediately
                            saveDefaultChart();
                        }
                    },
                    error: function(xhr) {
                        var message = 'No existing chart found. Starting with default structure.';
                        showAlert('info', message);

                        // Initialize with default data on error
                        initializeDefaultChart();

                        // Auto-save the default chart immediately
                        saveDefaultChart();
                    }
                });
            }

            // Save default chart automatically
            function saveDefaultChart() {
                if (orgData.length === 0) return;

                // Prepare data for API
                var structuresData = orgData.map(function(item) {
                    return {
                        id: null, // New record
                        title: item.title,
                        personId: item.personId,
                        parentId: item.parentId,
                        x: item.x,
                        y: item.y
                    };
                });

                $.ajax({
                    url: '/carta-organisasi/save',
                    method: 'POST',
                    data: {
                        chart_id: null, // Create new chart
                        structures: structuresData,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showAlert('success', 'Default chart structure created successfully!');
                            // Update chartId if returned from response
                            if (response.chart_id) {
                                chartId = response.chart_id;
                                chartReady = true;
                            }
                            // Reload to get the proper IDs
                            setTimeout(function() {
                                loadChartData();
                            }, 500);
                        }
                    },
                    error: function(xhr) {
                        showAlert('warning',
                            'Could not save default chart structure. You can still use the chart and save manually.'
                        );
                    }
                });
            }

            // Initialize default chart if no data exists
            function initializeDefaultChart() {
                // Get authenticated user data from Laravel
                var authUser = @json(Auth::user());

                orgData = [{
                    id: 1,
                    title: "President", // You can customize this title
                    name: authUser ? authUser.fullname : "Select person",
                    personId: authUser ? authUser.id : null,
                    parentId: null,
                    x: 300,
                    y: 50
                }];
                renderChart();
            }

            // Show alert messages
            function showAlert(type, message, autoHide = true) {
                const alertClass = {
                    'success': 'alert-success',
                    'error': 'alert-danger',
                    'warning': 'alert-warning',
                    'info': 'alert-info'
                };

                const iconClass = {
                    'success': 'fas fa-check-circle',
                    'error': 'fas fa-exclamation-circle',
                    'warning': 'fas fa-exclamation-triangle',
                    'info': 'fas fa-info-circle'
                };

                const alert = `
                    <div class="alert ${alertClass[type]} alert-dismissible fade show" role="alert">
                        <i class="${iconClass[type]}"></i> ${message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `;

                // Remove existing alerts
                $('.alert').remove();

                // Add new alert at the top of the card body
                $('.card-body').prepend(alert);

                // Auto hide after 5 seconds for success/info messages
                if (autoHide && (type === 'success' || type === 'info')) {
                    setTimeout(function() {
                        $('.alert').fadeOut();
                    }, 5000);
                }
            }

            // Validate form data
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

            // Add new position via API
            function addNewPosition(parentId, type) {
                // Check if chart is ready for operations
                if (!chartReady) {
                    showAlert('warning', 'Chart is still being initialized. Please wait a moment and try again.');
                    return;
                }

                // Check if we have valid chartId
                if (!chartId) {
                    showAlert('error', 'Chart ID not available. Please save the chart first.');
                    return;
                }

                // Check if we have valid data to work with
                if (orgData.length === 0) {
                    showAlert('error', 'No chart data available. Please refresh the page.');
                    return;
                }

                // Check if parent exists in our local data
                if (parentId && !orgData.find(item => item.id === parentId)) {
                    showAlert('error', 'Parent position not found. Please save the chart first.');
                    return;
                }

                positionCounter++;
                var positionTitle = "New Position " + positionCounter;

                // Calculate position coordinates 
                // Note: renderChart() will override these, but they help with initial placement
                var x = 300,
                    y = 50; // Default position

                // For debugging - let's see what's happening
                console.log('Adding position:', {
                    type: type,
                    parentId: parentId,
                    clickedItemId: parentId ? 'varies' : 'root'
                });

                // Log debug info
                console.log('Adding position with chartId:', chartId, 'parentId:', parentId);

                $.ajax({
                    url: '/carta-organisasi/add',
                    method: 'POST',
                    data: {
                        chart_id: chartId,
                        position_title: positionTitle,
                        user_id: null,
                        parent_id: parentId,
                        position_x: x,
                        position_y: y,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        showAlert('info', 'Adding new position...', false);
                    },
                    success: function(response) {
                        if (response.success) {
                            saveState(); // Save state for undo

                            // Add to local data
                            var newPosition = {
                                id: response.data.id,
                                title: response.data.title,
                                name: response.data.name,
                                personId: response.data.personId,
                                parentId: response.data.parentId,
                                x: response.data.x,
                                y: response.data.y
                            };

                            orgData.push(newPosition);

                            // Re-render with proper positioning
                            renderChart();

                            showAlert('success', 'Position added successfully');
                        } else {
                            showAlert('error', response.message || 'Failed to add position');
                        }
                    },
                    error: function(xhr) {
                        var message = 'Failed to add position';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.errors) {
                                var errors = [];
                                Object.values(xhr.responseJSON.errors).forEach(function(error) {
                                    errors = errors.concat(error);
                                });
                                message = errors.join('<br>');
                            }
                        }
                        showAlert('error', message, false);
                    }
                });
            }

            // Modal save button handler
            $('#savePositionBtn').click(function() {
                var title = $('#positionTitle').val().trim();
                var personId = $('#personName').val();
                var personName = $('#personName option:selected').text();

                // Validate input data
                var errors = validatePositionData(title, personId);

                if (errors.length > 0) {
                    showAlert('error', errors.join('<br>'), false);
                    return;
                }

                if (window.currentEditingItem) {
                    // Show loading state
                    $(this).prop('disabled', true).text('Saving...');

                    // Update via API
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
                                saveState(); // Save state for undo

                                // Update local data
                                window.currentEditingItem.title = title;
                                window.currentEditingItem.personId = personId;
                                window.currentEditingItem.name = personName;

                                // Close modal
                                $('#editPositionModal').modal('hide');

                                // Re-render chart
                                renderChart();

                                showAlert('success', 'Position updated successfully');
                            } else {
                                showAlert('error', response.message ||
                                    'Failed to update position');
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
                            showAlert('error', message, false);
                        },
                        complete: function() {
                            $('#savePositionBtn').prop('disabled', false).text('Save Changes');
                            window.currentEditingItem = null;
                        }
                    });
                }
            });

            // Modal form validation
            $('#editPositionForm').submit(function(e) {
                e.preventDefault();
                $('#savePositionBtn').click();
            });

            // Clear form when modal is hidden
            $('#editPositionModal').on('hidden.bs.modal', function() {
                $('#editPositionForm')[0].reset();

                // Clear Select2
                if ($('#personName').hasClass('select2-hidden-accessible')) {
                    $('#personName').val('').trigger('change');
                }

                window.currentEditingItem = null;
            });

            // Window resize handler for responsive behavior
            var resizeTimeout;
            $(window).resize(function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    renderChart(); // Re-render chart on window resize
                }, 250); // Debounce resize events
            });

            // Initialize - Load chart data from database
            loadChartData();
            updateUndoRedoButtons(); // Initialize button states
        });
    </script>
@endpush
