/**
 * Created by Quy on 11/17/2015.
 */

jQuery(function () {

    var base_path = jQuery('#base-path').attr('href');

    initSlideshow();
    initPrintDialog();
    initDatepicker('.views-exposed-form .form-item-date-from input');
    initDatepicker('.views-exposed-form .form-item-date-to input', true);
    initDatepicker('.views-exposed-form .form-item-date-from-statistic input');
    initDatepicker('.views-exposed-form .form-item-date-to-statistic input', true);
    initDatepicker('.views-exposed-form .form-item-payment-date-before input');
    initDatepicker('.views-exposed-form .form-item-purchased-date-before input');
    initDatepicker('.profit-statistics-container .date-from-container input');
    initDatepicker('.profit-statistics-container .date-to-container input');
    initStatisticsView('.profit-statistics-container .result .user .data');
    onGetStatistics('.btn-get-full-statistics', true);
    onBuyNowButtonClick('.button-buy-now', '.view-normal-products');
    onQuantityButtonClick('.quantity-wrapper');
    onQuantityInputChange('.quantity-wrapper');
    onChangeButtonClick('.purchased-products-list');
    onInvoiceButtonClick('.invoices-list');
    onButtonViewProfitStatisticsClick('.btn-get-statistics');
    onButtonViewProfitStatisticsClick('.btn-get-full-statistics', true);
    //onViewAllLoad('.invoices-list');
    //onViewAllLoad('.purchased-products-list');
    //onViewAllClick('.invoices-list');
    //onViewAllClick('.purchased-products-list');
    onUserCreateInvoiceButtonClick('.users-list');
    initCreateMultipleProductsView();
    initCreateMultipleExpendituresView();
    onExpenditureDeleteButtonClick('.expenditures-list');
    initChosen();

    function initSlideshow() {
        // process
        jQuery(".slideshow .view-content").owlCarousel({
            autoPlay: 3000,
            items : 4,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [979,3],
            itemsTablet: [768,2],
            itemsMobile: [479,1],
            stopOnHover: true,
        });

        jQuery('.node--type-product.node--view-mode-full .field--name-field-images').flexslider({
            animation: "slide"
        });
    }

    function onBuyNowButtonClick(button_selector, view_selector) {
        jQuery(document).on('click', button_selector, function () {
            var self = jQuery(this);
            self.attr('disabled', true);

            var parent = self.parents('article');
            var product_id = parent.find('.product-id').val();
            var price = parent.find('.price').val();
            var quantity = parent.find('.quantity').val();
            var url;

            url = base_path + 'buy-now/' + product_id + '/' + quantity;
            jQuery.post(url, function(data) {
                if (data.success) {
                    alert(data.message);
                    if (data.quantity > 0) {
                        parent.find('.quantity').val(1);
                        parent.find('.field--name-field-quantity .field__item').text(data.quantity);
                    } else {
                        jQuery(view_selector).triggerHandler('RefreshView');
                    }
                } else { // error
                    if (data.isAnonymous) {
                        alert(data.message);
                        //registryNewAccount();
                        jQuery('.buying-container .quantity-outer-wrapper').addClass('hidden');
                        jQuery('.buying-container .not-login-message').removeClass('hidden');
                    } else {
                    }
                }
                self.attr('disabled', false);
            });
        });
    }

    function onQuantityButtonClick(wrapper_selector) {
        var wrapper = jQuery(wrapper_selector);
        var quantity = wrapper.find('.quantity');
        var max_quantity = parseInt(wrapper.find('.max-quantity').val());

        jQuery(document).on('click', wrapper_selector + ' a', function () {
            var self = jQuery(this);
            var quantity_value = parseInt(quantity.val());

            if (self.hasClass('quantity-add')) {
                quantity_value += 1;
                if (quantity_value > max_quantity) {
                    quantity_value = max_quantity;
                }
            } else {
                quantity_value -= 1;
                if (quantity_value < 1) {
                    quantity_value = 1;
                }
            }
            quantity.val(quantity_value);

            return false;
        });
    }

    function onQuantityInputChange(wrapper_selector) {
        jQuery(document).on('keydown', wrapper_selector + ' .quantity', function (e) {
            var self = jQuery(this);
            var val = parseInt(self.val());
            var max_quantity = parseInt(self.parent().find('.max-quantity').val());

            onNumberInput(e);
            if (val < 1) {
                self.val(1);
                e.preventDefault();
            } else if (val > max_quantity) {
                self.val(max_quantity);
                e.preventDefault();
            }
        });
        jQuery(document).on('keyup', wrapper_selector + ' .quantity', function (e) {
            var self = jQuery(this);
            var val = parseInt(self.val());
            var max_quantity = parseInt(self.parent().find('.max-quantity').val());

            //onNumberInput(e);
            if (val < 1) {
                self.val(1);
                e.preventDefault();
            } else if (val > max_quantity) {
                self.val(max_quantity);
                e.preventDefault();
            }
        });
    }

    function onNumberInput(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
                // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 112 || e.keyCode > 123)) {
            e.preventDefault();
        }
    }

    function registryNewAccount() {
        var phone = prompt("Please enter your phone", "Account Registration");
        var url;

        if (phone != null) {
            url = base_path + 'registry/' + phone;
            jQuery.post(url, function (data) {
                if (data.success) {
                    alert(data.message);

                    url = base_path + 'login/' + data.uid;
                    jQuery.post(url, function (data) {
                        if (!data.success) {
                            alert('Login successfully.');
                            location.reload();
                        } else {
                            alert('Login unsuccessfully.');
                        }
                    });
                } else {
                    alert(data.message);
                    if (data.isExisted) {
                        registryNewAccount();
                    }
                }
            });
        }
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

    function onInvoiceButtonClick(view_selector) {
        jQuery(document).on('click', view_selector + ' table tbody tr td:last-child a', function () {
            var self = jQuery(this);
            var invoice_id = self.attr('rel-item');
            var classes = self.attr('class');

            if (classes.indexOf('start') >= 0) { // start
                if (confirm(Drupal.t('Do you really want to change status?'))) {
                    startInvoice(invoice_id, view_selector);
                }
            } else if (classes.indexOf('print') >= 0) {
                window.location.href = base_path + 'invoice/print/' + invoice_id;
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
                    var btn = jQuery(this);
                    btn.attr('disabled', true);

                    jQuery.post(url, JSON.stringify(data), function (data) {
                        btn.attr('disabled', false);
                        alert(data.message);
                        window.location.href = base_path + 'products';
                    }, 'json');
                }
            }
        });
    }

    function initCreateMultipleExpendituresView() {
        var container = jQuery('.expenditures-container');
        var table_body = jQuery('.expenditures-container table tbody');
        var origin_row = jQuery('.expenditures-container table tbody .origin-row');
        var error_message = jQuery('.expenditures-container .error-message');
        var error_element;

        error_message.hide();

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
        jQuery(document).on('click', '.expenditures-container table tbody .btn-remove-row', function () {
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

            url = base_path + 'expenditure/create-expenditures';
            table_body.children().each(function (i, e) {
                if (i > 0) {
                    var self = jQuery(this);
                    var name = self.find('.name');
                    var note = self.find('.note');
                    var total_cost = self.find('.total-cost');

                    if (name.val().length == 0) {
                        error_message.text(Drupal.t('Name must be not empty.'));
                        error_message.show();
                        name.addClass('invalid');
                        error_element = name;
                        canPost = false;
                        return false;
                    } else if (total_cost.val() <= 0) {
                        error_message.text(Drupal.t('Total cost must be positive.'));
                        error_message.show();
                        total_cost.addClass('invalid');
                        error_element = total_cost;
                        canPost = false;
                        return false;
                    }

                    var tmpData = {
                        'name' : name.val(),
                        'note' : note.val(),
                        'total_cost' : total_cost.val(),
                    };
                    data.push(tmpData);
                }
            });

            if (canPost) {
                if (confirm(Drupal.t('Do you really want to save?'))) {
                    var btn = jQuery(this);
                    btn.attr('disabled', true);

                    jQuery.post(url, JSON.stringify(data), function (data) {
                        btn.attr('disabled', false);
                        alert(data.message);
                        window.location.href = base_path;
                    }, 'json');
                }
            }
        });
    }

    function onExpenditureDeleteButtonClick(view_selector) {
        jQuery(document).on('click', view_selector + ' table tbody tr td:last-child a', function () {
            var self = jQuery(this);
            var expenditure_id = self.attr('exp-item');
            var href = self.attr('href');

            if (expenditure_id && href == '#') {
                if (confirm(Drupal.t('Do you really want to delete expenditure?'))) {
                    deleteExpenditure(expenditure_id, view_selector);
                }
                return false;
            } else {
                return true;
            }
        });
    }

    function deleteExpenditure(expenditure_id, view_selector) {
        url = base_path + 'expenditure/delete/' + expenditure_id;
        jQuery.post(url, function(data) {
            if (data.success) {
                alert(data.message);
            } else { // error
                alert(data.message);
            }
        });

        jQuery(view_selector).triggerHandler('RefreshView');
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

    function initStatisticsView(selector) {
        var user = jQuery(selector);
        var url = base_path + 'statistics/get-total-users';
        jQuery.post(url, function (data) {
            user.html(data.total_users);
        }, 'json');
    }

    function onButtonViewProfitStatisticsClick(selector, is_full) {
        jQuery(document).on('click', selector, function () {
            onGetStatistics(this, is_full);
        });
    }

    function onGetStatistics(selector, is_full) {
        var self = jQuery(selector);
        var container = self.parents('.profit-statistics-container');
        var date_from = container.find('.date-from').val();
        var date_to = container.find('.date-to').val();
        var receipt = container.find('.result .receipt .data');
        var cost = container.find('.result .cost .data');
        var expenditure = container.find('.result .expenditure .data');
        var profit = container.find('.result .profit .data');
        var url;
        if (is_full == true) {
            url = base_path + 'statistics/get-profit-full';
        } else {
            url = base_path + 'statistics/get-profit';
        }
        var data = {
            'date_from' : date_from,
            'date_to' : date_to,
        };

        jQuery.ajax({
            type: "POST",
            url: url,
            data: JSON.stringify(data),
            dataType: "json",
            timeout: 100000, // in milliseconds
            success: function(data) {
                receipt.html(formatCurrency(data.total_receipt));
                cost.html(formatCurrency(data.total_cost));
                expenditure.html(formatCurrency(data.total_expenditure));
                profit.html(formatCurrency(data.total_profit));
            },
        });

        /*
        jQuery.post(url, JSON.stringify(data), function (data) {
            receipt.html(formatCurrency(data.total_receipt));
            cost.html(formatCurrency(data.total_cost));
            expenditure.html(formatCurrency(data.total_expenditure));
            profit.html(formatCurrency(data.total_profit));
        }, 'json');
        */
    }

    function initPrintDialog() {
        var href = window.location.href;
        if (href.indexOf('print') > 0) {
            window.print();
        }
    }

    function formatCurrency(value) {
        var curStr = value.toString();
        var result = "";
        var length = curStr.length;
        var i;
        var c;
        var seperate = 0;
        var seperate_index = -1;
        for (i = length-1; i >= 0; i--) {
            c = curStr.charAt(i);
            result += c;
            if (c == '.') {
                seperate += 1;
                seperate_index = i;
            }
            if ((length + seperate - i) % 3 == 0 && i != 0 && i != seperate_index) {
                result += ",";
            }
        }
        return reverse(result);
    }

    function reverse(s){
        return s.split("").reverse().join("");
    }

    function initChosen() {

    }

    function getFullElementHtml(element) {
        return jQuery('<div>').append(element.clone()).html();
    }


    //test();
    function test() {
        jQuery('.create-multiple-products .image-link').val('https://www.facebook.com/gomsunhatgiare/photos/a.465336356980061.1073741825.465335773646786/465337096979987/?type=3&theater');
        jQuery('.create-multiple-products .customer').val('1');
        jQuery('.create-multiple-products .quantity').val('1');
        jQuery('.create-multiple-products .price').val('10000');

        for (var i = 0; i < 100; i++) {
            jQuery('.create-multiple-products .btn-add-row').trigger('click');
        }
    }
});
