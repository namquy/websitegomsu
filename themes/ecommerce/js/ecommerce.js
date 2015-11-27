/**
 * Created by Quy on 11/17/2015.
 */

jQuery(function () {

    var base_path = jQuery('#base-path').attr('href');

    onBuyNowButtonClick();
    onChangeButtonClick('.purchased-products-list');
    onInvoiceDetailButtonClick('.invoices-list');
    //onViewAllLoad('.invoices-list');
    //onViewAllLoad('.purchased-products-list');
    onViewAllClick('.invoices-list');
    onViewAllClick('.purchased-products-list');
    initCreateMultipleProductsView();

    function onBuyNowButtonClick() {
        jQuery('.button-buy-now').click(function () {
            var self = jQuery(this);
            self.attr('disabled', true);

            var parent = self.parent();
            var product_id = parent.find('.product-id').val();
            var price = parent.find('.price').val();
            var quantity = parent.find('.quantity').val();
            var url;

            url = base_path + 'buy-now/' + product_id + '/' + price + '/' + quantity;
            jQuery.post(url, function(data) {
                if (data.success) {
                    alert(data.message);
                } else { // error
                    alert(data.message);
                }
                self.attr('disabled', false);
            });
        });
    }

    function onChangeButtonClick(view_selector) {
        jQuery(document).on('click', view_selector + ' table tbody tr td:last-child a', function () {
            var self = jQuery(this);
            var relationship_id = self.attr('rel-item');
            var status_id = self.attr('rel-status');

            if (confirm(Drupal.t('Do you really want to change status?'))) {
                changeStatusPurchasingProduct(relationship_id, status_id, view_selector);
            }

            return false;
        });
    }

    function changeStatusPurchasingProduct(relationship_id, status_id, view_selector) {
        url = base_path + 'change-status/' + relationship_id + '/' + status_id;
        jQuery.post(url, function(data) {
            if (data.success) {
                alert(data.message);
            } else { // error
                alert(data.message);
            }
        });

        jQuery(view_selector).triggerHandler('RefreshView');
    }

    function onInvoiceDetailButtonClick(view_selector) {
        jQuery(document).on('click', view_selector + ' table tbody tr td:last-child a', function () {
            var self = jQuery(this);
            var invoice_id = self.attr('rel-item');
            var classes = self.attr('class');

            if (classes.indexOf('start') >= 0) { // start
                if (confirm(Drupal.t('Do you really want to change status?'))) {
                    startInvoice(invoice_id, view_selector);
                }
            } else { // detail
                window.location.href = base_path + 'invoice/detail/' + invoice_id;
            }

            return false;
        });
    }

    function startInvoice(invoice_id, view_selector) {
        url = base_path + 'invoice/start/' + invoice_id;
        jQuery.post(url, function(data) {
            if (data.success) {
                alert(data.message);
            } else { // error
                alert(data.message);
            }
        });

        jQuery(view_selector).triggerHandler('RefreshView');
    }

    /*
    function onViewAllLoad(view_selector) {
        jQuery(document).on('load', view_selector + ' .view-header .view-all', function () {
            var self = jQuery(this);
            self.attr('href', base_path + self.attr('path'));
        });
    }
    */

    function onViewAllClick(view_selector) {
        jQuery(document).on('click', view_selector + ' .view-header .view-all', function () {
            var self = jQuery(this);
            window.location.href = base_path + self.attr('path');
            return false;
        });
    }

    function initCreateMultipleProductsView() {
        var container = jQuery('.products-container');
        var table_body = jQuery('.products-container table tbody');
        var origin_row = jQuery('.products-container table tbody .origin-row');

        jQuery(document).on('keydown.autocomplete', '.products-container table tbody .customer-autocomplete', function () {
            var self = jQuery(this);

            self.autocomplete({
                source: function(request, response ) {
                    jQuery.ajax({
                        url: base_path + 'purchase/user/autocomplete/' + request.term,
                        data: 'json',
                        success: function(data) {
                            //response(data);
                            response(jQuery.map(data, function (item) {
                                return {
                                    value: item.id,
                                    label: item.name
                                };
                            }));
                        },
                    });
                },
                select: function(event, ui) {
                    jQuery('.customer-autocomplete').val(ui.item.label);
                    jQuery('.customer').val(ui.item.value);
                    return false;
                },
                focus: function(event, ui) {
                    //jQuery('.customer-autocomplete').val(ui.item.label);
                    return false;
                },
            });
        });

        // add a row on init
        table_body.append(origin_row.clone().css('display', '').removeClass('origin-row'));

        // on add new row buton click
        container.find('.btn-add-row').click(function () {
            var cloned_row = origin_row.clone();
            cloned_row.css('display', '');
            cloned_row.removeClass('origin-row');
            table_body.append(cloned_row);
        });

        // on remove row button click
        jQuery(document).on('click', '.products-container table tbody .btn-remove-row', function () {
            var self = jQuery(this);
            var row = self.parent().parent();
            row.remove();
        });

        // on save button click
        container.find('.btn-save').click(function () {
            var data = [];
            var url;

            url = base_path + 'product/create';
            table_body.children().each(function (i, e) {
                if (i > 0) {
                    var self = jQuery(this);
                    var tmpData = {
                        /*'title' : 'Facebook Product',*/
                        'image_link' : self.find('.image-link:first').val(),
                        'body' : self.find('.note').val(),
                        'customer_id' : self.find('.customer').val(),
                        'price' : self.find('.price').val(),
                        'quantity' : self.find('.quantity').val(),
                        /*'status_id' : 1,*/
                    };
                    data.push(tmpData);
                }
            });

            jQuery.post(url, JSON.stringify(data), function (data) {
                alert(data.message);
            }, 'json');
        });
    }

    function getFullElementHtml(element) {
        return jQuery('<div>').append(element.clone()).html();
    }
});
