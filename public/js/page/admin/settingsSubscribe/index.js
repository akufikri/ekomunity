$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    loadData();
});

function loadData() {
    $("#datatable-crud").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
            url: "/list_setting_yuran",
            type: "GET",
        },
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false,
            }, // No
            { data: "subscribe_for", name: "subscribe_for" }, // Jenis
            {
                data: "price",
                name: "price",
                render: function (data, type, row) {
                    return "RM " + parseFloat(data || 0).toFixed(2);
                },
            }, // Harga
            {
                data: "price_pusat",
                name: "price_pusat",
                render: function (data, type, row) {
                    return "RM " + parseFloat(data || 0).toFixed(2);
                },
            }, // Harga pusat
            {
                data: "price_cawangan",
                name: "price_cawangan",
                render: function (data, type, row) {
                    return "RM " + parseFloat(data || 0).toFixed(2);
                },
            }, // Harga cawangan
            {
                data: "price_ketua_bahagian",
                name: "price_ketua_bahagian",
                render: function (data, type, row) {
                    return "RM " + parseFloat(data || 0).toFixed(2);
                },
            }, // Harga ketua bahagian
            { data: "subscribe_name", name: "subscribe_name" }, // Keterangan
            { data: "collection_id", name: "collection_id" }, // Category Code
            { data: "secret_key", name: "secret_key" }, // Secret Key
            { data: "is_active", name: "is_active" }, // Status
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            }, // Action
        ],
        columnDefs: [
            {
                targets: 9, // Index kolom Status (is_active)
                data: "is_active",
                render: function (data, type, row) {
                    var btn =
                        row.is_active == "ENABLE"
                            ? '<div><button class="btn btn-sm btn-success" style="width:100%">Enable</button></div>'
                            : '<div><button class="btn btn-sm btn-danger btn-activate-kad" data-id="' +
                              row.id_setting_subscribe +
                              '" style="width:100%">Disable</button></div>';
                    return btn;
                },
            },
            {
                targets: 10, // Index kolom Action
                data: "action",
                render: function (data, type, row) {
                    var btn =
                        '<button type="button" data-toggle="modal" data-target="#ShowCertificateModal" class="btn btn-info btn-sm" id="getShowArticleData" data-id="' +
                        row.id_setting_subscribe +
                        '"><i class="fas fa-info-circle"></i></button> ' +
                        '<button type="button" data-toggle="modal" data-target="#EditArticleModal" class="btn btn-warning btn-sm" id="getEditArticleData" data-id="' +
                        row.id_setting_subscribe +
                        '"><i class="fa fa-edit"></i></button>';
                    return btn;
                },
            },
        ],
        order: [[0, "asc"]],
    });
}

$(".modelClose").on("click", function () {
    $("#EditArticleModal").hide();
});

$("body").on("click", "#getEditArticleData", function (e) {
    $(".alert-danger").html("");
    $(".alert-danger").hide();
    var id = $(this).data("id");
    $.ajax({
        url: "list_setting_yuran/" + id + "/edit",
        method: "GET",
        success: function (result) {
            data = result.data;
            var form = $(".form-update-data");
            form.find("input[name=id_setting_subscribe]").val(
                data.id_setting_subscribe
            );
            form.find("input[name=subscribe_for]").val(data.subscribe_for);
            form.find("input[name=price]").val(data.price);
            form.find("input[name=price_pusat]").val(data.price_pusat);
            form.find("input[name=price_cawangan]").val(data.price_cawangan);
            form.find("input[name=price_ketua_bahagian]").val(
                data.price_ketua_bahagian
            );
            form.find("input[name=collection_id]").val(data.collection_id);
            form.find("input[name=secret_key]").val(data.secret_key);
            form.find("input[name=subscribe_name]").val(data.subscribe_name);

            $("#EditArticleModal").show();
        },
        error: function (xhr, status, error) {
            console.error("Error loading data:", error);
            swal("Error!", "Failed to load data", "error");
        },
    });
});

$(".modelClose").on("click", function () {
    $("#ShowCertificateModal").hide();
});

$("body").on("click", "#getShowArticleData", function (e) {
    $(".alert-danger").html("");
    $(".alert-danger").hide();
    var id = $(this).data("id");
    $.ajax({
        url: "list_setting_yuran/" + id,
        method: "GET",
        success: function (result) {
            data = result.data;
            $("#show_subscribe_for").val(data.subscribe_for);
            $("#show_price").val(data.price);
            $("#show_price_pusat").val(data.price_pusat);
            $("#show_price_cawangan").val(data.price_cawangan);
            $("#show_price_ketua_bahagian").val(data.price_ketua_bahagian);
            $("#show_collection_id").val(data.collection_id);
            $("#show_secret_key").val(data.secret_key);
            $("#show_subscribe_name").val(data.subscribe_name);

            $("#ShowCertificateModal").show();
        },
        error: function (xhr, status, error) {
            console.error("Error loading data:", error);
            swal("Error!", "Failed to load data", "error");
        },
    });
});

// Start Ajax Update data
$(document).on("submit", ".form-update-data", function (e) {
    var formData = new FormData(this);
    e.preventDefault();

    var ini = $(this),
        input_token = $("input[name=_token]"),
        id = ini.find("input[name=id_setting_subscribe]").val(),
        url = "/update_yuran/" + id;

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
    })
        .done(function (result) {
            if (result.data != null || result.status === "success") {
                $("#EditArticleModal").modal("hide");
                loadData();
                swal("Success!", "Update Successfully!", "success");
            } else {
                swal("Error!", "Failed to update data", "error");
            }
            if (result.newToken) {
                input_token.val(result.newToken);
            }
        })
        .fail(function (xhr, status, error) {
            console.error("Ajax error:", error);
            swal("Error!", "Failed to update data: " + error, "error");
        });
});

// Function untuk handle ajax fail
function ajax_fail(xhr, status, error) {
    console.error("Ajax request failed:", {
        status: status,
        error: error,
        response: xhr.responseText,
    });
    swal("Error!", "Request failed: " + error, "error");
}
