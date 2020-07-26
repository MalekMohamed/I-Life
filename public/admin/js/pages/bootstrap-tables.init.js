function categoryFormatter(e, t) {
    return '<a href="' + url + '/shop/' + t._name_data.category + '" class="btn-link ">' + e + "</a>"
}

function invoiceFormatter(e, t) {
    return '<a href="#" class="btn-link "> Order #' + e + "</a>"
}

function nameFormatter(e, t) {
    return '<a href="' + url + '/product/' + t._name_data.product + '" class="btn-link product-link" > ' + e + "</a>"
}

function dateFormatter(e, t) {
    return t.id, '<span class="text-muted"> ' + e + "</span>"
}

function statusFormatter(e, t) {
    var n;
    return "Paid" == e ? n = "success" : "Unpaid" == e ? n = "warning" : "Shipped" == e ? n = "info" : "Refunded" == e && (n = "danger"), t.id, '<div class="badge label-table badge-' + n + '"> ' + e + "</div>"
}

function priceSorter(e, t) {
    return e = +e.substring(1), (t = +t.substring(1)) < e ? 1 : e < t ? -1 : 0
}

$(document).ready(function () {
    var e = $("#demo-custom-toolbar"), t = $("#demo-delete-row");
    e.on("check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table", function () {
        t.prop("disabled", !e.bootstrapTable("getSelections").length)
    }), t.click(function () {
        var t = $.map(e.bootstrapTable("getSelections"), function (e) {
            return e.id
        });
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(function (n) {
            n.value ? removeOrder(t, n, e) : n.dismiss === Swal.DismissReason.cancel && Swal.fire({
                title: "Cancelled",
                text: "Your imaginary file is safe :)",
                type: "error"
            })
        })
    })
}), $(window).on("load", function () {
    $('[data-toggle="table"]').show()
}), window.icons = {
    refresh: "mdi mdi-refresh",
    toggle: "fa-refresh",
    toggleOn: "fa-toggle-on",
    toggleOff: "fa-toggle-on",
    columns: "fa-th-list",
    paginationSwitchDown: "glyphicon-collapse-down icon-chevron-down"
};