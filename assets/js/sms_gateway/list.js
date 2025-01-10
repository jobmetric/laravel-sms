loadScriptsSequentially([
    'assets/vendor/package-core/js/datatable-columns.js',
], function() {
    $(document).ready(function(){
        dt = $('#datatable').on('preXhr.dt', function (e, settings, data) {
        }).DataTable({
            responsive: false,
            autoWidth: false,
            processing: true,
            serverSide: true,
            drawCallback: function(settings) {},
            ajax: {
                url: localize.sms_gateway.route,
                data: function (data) {
                    if (data.order && data.order.length > 0) {
                        data.sort = data.order[0].dir === 'asc' ? data.columns[data.order[0].column].name : `-${data.columns[data.order[0].column].name}`
                    }

                    // Apply any additional filters as needed
                    data.filter = {
                        name: $('#filter-name').val(),
                        driver: $('#filter-driver').val()
                    }
                }
            },
            columns: [
                // checkbox
                {
                    data: datatableColumnSingleCheckList,
                    sortable: false
                },
                // name
                {
                    name: 'name',
                    data: function(e) {
                        return `<div class="align-start text-gray-800 word-no-break">${e.name}</div>`
                    },
                    sortable: true
                },
                // driver
                {
                    name: 'driver',
                    data: function(e) {
                        return `<div class="align-center text-gray-800 word-no-break">${e.driver}</div>`
                    },
                    sortable: true
                },
                // default
                {
                    name: 'default',
                    data: datatableColumnDefaultList,
                    sortable: true
                },
                // action
                {
                    data: function(e) {
                        return `<div class="d-flex justify-content-center align-items-center">
                                    <a href="${localize.sms_gateway.route}/${e.id}/edit" class="btn btn-sm btn-outline btn-outline-dashed bg-light-success btn-color-gray-800">
                                        <i class="la la-edit fs-2 position-absolute"></i>
                                        <span class="ps-9">${localize.language.panelio.button.edit}</span>
                                    </a>
                               </div>`
                    },
                    sortable: false
                }
            ],
            order: [
                [1, "asc"]
            ],
            searching: false,
            lengthChange: false,
            deferRender: true,
            pageLength: localize.list_view.page_limit,
            language: localize.language.datatable
        })
    })
})
