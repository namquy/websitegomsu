/**
 * Created by Quy on 11/17/2015.
 */

jQuery(function () {

    onBuyNowButtonClick();
    onPurchasedButtonClick('.purchased-products-list');

    function onBuyNowButtonClick() {
        jQuery('.button-buy-now').click(function () {
            var self = jQuery(this);
            self.attr('disabled', true);

            var parent = self.parent();
            var product_id = parent.find('.product-id').val();
            var price = parent.find('.price').val();
            var quantity = parent.find('.quantity').val();
            var url;

            url = 'buy-now/' + product_id + '/' + price + '/' + quantity;
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

    function onPurchasedButtonClick(view_selector) {
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
        url = 'change-status/' + relationship_id + '/' + status_id;
        jQuery.post(url, function(data) {
            if (data.success) {
                alert(data.message);
            } else { // error
                alert(data.message);
            }
        });

        jQuery(view_selector).triggerHandler('RefreshView');
    }

    function getFullElementHtml(element) {
        return $('<div>').append(element.clone()).html();
    }
});
