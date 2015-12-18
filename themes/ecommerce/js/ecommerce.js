/**
 * Created by Quy on 11/17/2015.
 */

jQuery(function () {

    var base_path = jQuery('#base-path').attr('href');

    initDatepicker('.views-exposed-form .form-item-date-from input');
    initDatepicker('.views-exposed-form .form-item-date-to input', true);
    initDatepicker('.views-exposed-form .form-item-date-from-statistic input');
    initDatepicker('.views-exposed-form .form-item-date-to-statistic input', true);
    onBuyNowButtonClick();
    onChangeButtonClick('.purchased-products-list');
    onInvoiceDetailButtonClick('.invoices-list');
    //onViewAllLoad('.invoices-list');
    //onViewAllLoad('.purchased-products-list');
    //onViewAllClick('.invoices-list');
    //onViewAllClick('.purchased-products-list');
    onUserCreateInvoiceButtonClick('.users-list');
    initCreateMultipleProductsView();
    initChosen();

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
            var href = self.attr('href');

            if (!status_id) {
                status_id = 3; // cancel
            }

            if (relationship_id && href == '#') {
                if (confirm(Drupal.t('Do you really want to change status?'))) {
                    changeStatusPurchasingProduct(relationship_id, status_id, view_selector);
                }
                return false;
            } else {
                return true;
            }
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

    function onUserCreateInvoiceButtonClick(view_selector) {
        jQuery(document).on('click', view_selector + ' table tbody tr td:last-child .btn-create-invoice', function () {
            if (confirm(Drupal.t('Do you really want to create invoice for the user?'))) {
                var self = jQuery(this);
                var url = base_path + 'invoice/create/' + self.attr('user-id');

                jQuery.post(url, function(data) {
                    if (data.success) {
                        alert(data.message);
                    } else { // error
                        alert(data.message);
                    }
                });
            }
        });
    }

    function initCreateMultipleProductsView() {
        var container = jQuery('.products-container');
        var table_body = jQuery('.products-container table tbody');
        var origin_row = jQuery('.products-container table tbody .origin-row');
        var error_message = jQuery('.products-container .error-message');
        var error_element;

        error_message.hide();

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
                    self.val(ui.item.label);
                    self.next().val(ui.item.value);
                    return false;
                },
                focus: function(event, ui) {
                    //jQuery('.customer-autocomplete').val(ui.item.label);
                    return false;
                },
                autoFocus: true,
            }).blur(function () {
                var keyEvent = jQuery.Event('keydown');
                keyEvent.keyCode = jQuery.ui.keyCode.ENTER;
                jQuery(this).trigger(keyEvent);
                return false;
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
            var canPost = true;

            error_message.empty();
            error_message.hide();
            if (error_element) {
                error_element.removeClass('invalid');
            }

            url = base_path + 'product/create';
            table_body.children().each(function (i, e) {
                if (i > 0) {
                    var self = jQuery(this);
                    var image_link = self.find('.image-link:first');
                    var note = self.find('.note');
                    var customer_id = self.find('.customer');
                    var price = self.find('.price');
                    var quantity = self.find('.quantity');

                    if (image_link.val().length == 0) {
                        error_message.text(Drupal.t('Image link must be not empty.'));
                        error_message.show();
                        image_link.addClass('invalid');
                        error_element = image_link;
                        canPost = false;
                        return false;
                    } else if (customer_id.val() <= 0) {
                        error_message.text(Drupal.t('Customer must be chosen.'));
                        error_message.show();
                        customer_id.prev().addClass('invalid');
                        error_element = customer_id.prev();
                        canPost = false;
                        return false;
                    } else if (quantity.val() <= 0) {
                        error_message.text(Drupal.t('Quantity must be positive.'));
                        error_message.show();
                        quantity.addClass('invalid');
                        error_element = quantity;
                        canPost = false;
                        return false;
                    } else if (price.val() <= 0) {
                        error_message.text(Drupal.t('Price must be positive.'));
                        error_message.show();
                        price.addClass('invalid');
                        error_element = price;
                        canPost = false;
                        return false;
                    }

                    var tmpData = {
                        /*'title' : 'Facebook Product',*/
                        'image_link' : image_link.val(),
                        'body' : note.val(),
                        'customer_id' : customer_id.val(),
                        'price' : price.val(),
                        'quantity' : quantity.val(),
                        /*'status_id' : 1,*/
                    };
                    data.push(tmpData);
                }
            });

            if (canPost) {
                if (confirm(Drupal.t('Do you really want to save?'))) {
                    jQuery.post(url, JSON.stringify(data), function (data) {
                        alert(data.message);
                        window.location.href = base_path + 'products';
                    }, 'json');
                }
            }
        });
    }

    function initDatepicker(selector, isEndDay) {
        jQuery(document).on('focus', selector, function () {
            var self = jQuery(this);
            if (!self.data('datepicker')) {
                self.datepicker({
                    onSelect: function (datetext) {
                        if (isEndDay) {
                            if (self.parent().find('.fake-input-item').length == 0) {
                                var fakeInput = self.clone();
                                fakeInput.attr('class', 'fake-input-item');
                                fakeInput.attr('id', '');
                                fakeInput.attr('name', '');
                                fakeInput.attr('data-drupal-selector', '');
                                self.parent().append(fakeInput);
                                self.hide();
                            }

                            var date = new Date(datetext);
                            date.setHours(24);
                            datetext = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
                            self.val(datetext);
                        }
                    },
                });
            }
        });
    }

    function initChosen() {

    }

    function getFullElementHtml(element) {
        return jQuery('<div>').append(element.clone()).html();
    }
});
