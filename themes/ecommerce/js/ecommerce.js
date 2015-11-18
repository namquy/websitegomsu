/**
 * Created by Quy on 11/17/2015.
 */

jQuery(function () {

    onBuyNowButtonClick();

    function onBuyNowButtonClick() {
        jQuery('.button-buy-now').click(function () {
            var self = jQuery(this);
            self.attr('disabled', true);

            var parent = self.parent();
            var product_id = parent.find('.product-id').val();
            var price = parent.find('.price').val();
            var quantity = parent.find('.quantity').val();
            var url;
            /*var data;*/

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
});
