"use strict"

const smsGateway = {
    driver: {
        change: function () {
            let driver = $('select[name="driver"]').val()

            if (driver) {
                $.ajax({
                    url: getLocalize('sms_gateway.getFields'),
                    method: 'get',
                    dataType: 'json',
                    async: false,
                    data: $.param({
                        driver: driver
                    }),
                    beforeSend: function () {
                        panelio.select2.loading.show('#field-driver')
                    },
                    complete: function () {
                        panelio.select2.loading.hide('#field-driver')
                    },
                    success: function (json) {
                        smsGateway.driver.boxDriver.fill(json.data.theme)
                    }
                })
            } else {
                smsGateway.driver.boxDriver.hide()
            }
        },
        boxDriver: {
            show: function () {
                $('#box-driver-fields').removeClass('d-none')
            },
            hide: function () {
                $('#box-driver-fields').addClass('d-none')
            },
            fill: function (theme) {
                this.show()
                $('#box-driver-fields .card-body').html(theme)
            },
        }
    },
}
