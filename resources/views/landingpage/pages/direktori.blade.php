@extends('landingpage.layout.app')
@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
    <style>
        /* DataTable Container */
        .dataTables_wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 20px;
        }

        /* Table Styling */
        #myTable {
            width: 100% !important;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            border: none;
        }

        /* Header Styling */
        #myTable thead th {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            /* color: white; */
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 20px;
            text-align: left;
            border: none;
            font-size: 14px;
            position: relative;
        }

        #myTable thead th:first-child {
            border-top-left-radius: 8px;
        }

        #myTable thead th:last-child {
            border-top-right-radius: 8px;
        }

        /* Hover effect on header */
        #myTable thead th:hover {
            /* background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%); */
            cursor: pointer;
        }

        /* Body Styling */
        #myTable tbody td {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            color: #495057;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        /* Row Hover Effect */
        #myTable tbody tr:hover {
            /* background-color: #f8f9fa; */
            transform: translateY(-1px);
            /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
        }

        /* Alternating Row Colors */
        #myTable tbody tr:nth-child(even) {
            /* background-color: #f8f9fa; */
        }

        #myTable tbody tr:nth-child(odd) {
            /* background-color: #ffffff; */
        }

        /* Remove last border */
        #myTable tbody tr:last-child td {
            border-bottom: none;
        }

        /* Pagination Styling */
        .dataTables_paginate {
            margin-top: 20px;
            text-align: center;
        }

        .dataTables_paginate .paginate_button {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 2px;
            background: #fff;
            border: 1px solid #dee2e6;
            color: #495057;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-size: 14px;
            min-width: 40px;
            text-align: center;
        }

        .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            transform: translateY(-1px);
            /* box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3); */
        }

        .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            font-weight: 600;
        }

        .dataTables_paginate .paginate_button.disabled {
            color: #6c757d;
            background: #e9ecef;
            border-color: #dee2e6;
            cursor: not-allowed;
        }

        .dataTables_paginate .paginate_button.disabled:hover {
            background: #e9ecef;
            color: #6c757d;
            transform: none;
            box-shadow: none;
        }

        /* Previous/Next Button Styling */
        .dataTables_paginate .paginate_button.previous,
        .dataTables_paginate .paginate_button.next {
            font-weight: 600;
            padding: 8px 16px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {

            #myTable thead th,
            #myTable tbody td {
                padding: 10px 12px;
                font-size: 13px;
            }

            .dataTables_paginate .paginate_button {
                padding: 6px 10px;
                font-size: 12px;
                min-width: 35px;
            }
        }

        /* Loading State */
        .dataTables_processing {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            margin-left: -100px;
            margin-top: -26px;
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Sorting Icons */
        #myTable thead th.sorting:after,
        #myTable thead th.sorting_asc:after,
        #myTable thead th.sorting_desc:after {
            opacity: 0.7;
            font-size: 12px;
        }

        /* Custom Scrollbar for responsive table */
        .dataTables_scrollBody::-webkit-scrollbar {
            height: 6px;
        }

        .dataTables_scrollBody::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .dataTables_scrollBody::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 3px;
        }

        .dataTables_scrollBody::-webkit-scrollbar-thumb:hover {
            background: #5a6fd8;
        }
    </style>
@endpush
@section('content')
    <section style="height: 100vh">
        <div class="container">
            <div>
                <h4 class="fw-bold">Direktori</h4>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jawatan</th>
                            <th>E-mel</th>
                            <th>No telefon</th>
                            <th>Cawangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan diisi via Ajax -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let table = new DataTable('#myTable', {
                responsive: true,
                searching: false,
                lengthChange: false,
                info: false,
                paging: true,
                pageLength: 10,
                processing: true,
                language: {
                    processing: "Memuat data...",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });

            // Fetch data dari endpoint
            $.ajax({
                type: "GET",
                url: "/v1/direktori",
                dataType: "JSON",
                beforeSend: function() {
                    // Show loading
                    $('#myTable tbody').html('<tr><td colspan="5" class="text-center">Memuat data...</td></tr>');
                },
                success: function (response) {
                    console.log(response);
                    
                    // Clear existing data
                    table.clear();
                    
                    if (response.success && response.data && response.data.length > 0) {
                        // Add data to table
                        response.data.forEach(function(item) {
                            table.row.add([
                                item.name || '-',
                                item.jawatan || '-',
                                item.email || '-',
                                item.no_phone || '-', // No telefon tidak ada di response, bisa diisi '-' atau request field ini ke backend
                                item.cawangan || '-'
                            ]);
                        });
                        
                        // Draw the table
                        table.draw();
                    } else {
                        // No data available
                        $('#myTable tbody').html('<tr><td colspan="5" class="text-center">Tidak ada data tersedia</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#myTable tbody').html('<tr><td colspan="5" class="text-center text-danger">Gagal memuat data direktori</td></tr>');
                }
            });
        });
    </script>
@endpush