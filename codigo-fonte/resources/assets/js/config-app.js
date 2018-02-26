$.extend( true, $.fn.dataTable.defaults, {
    dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>" +
         "<'row'<'col-xs-12't>>" +
         "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
    processing: false,
    serverSide: true,
    searching: false,
    ordering: false,
    paging: false,
    pageLength: 25,
    drawCallback: function() {
        $('.popovers').popover();
    },
    language: { url: "/template/global/scripts/Portuguese-Brasil.json" }
});