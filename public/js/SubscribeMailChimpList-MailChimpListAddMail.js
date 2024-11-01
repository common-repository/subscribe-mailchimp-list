var SubscribeMailChimpListMailChimpListAddMail =
    {

        alert_selector: false,

        action_url: false,

        selector: '.grid__girl-posts-items',

        run: function () {

            var this_class = this;

            this_class.action_url = window.SubscribeMailChimpList_MailChimpListAddMail__vars.ajax_url_action;

            this_class.alert_selector = "[data-alert='alert-area']";

            this_class.init("[action='" + this_class.action_url + "']");


        },
        init: function (selector) {
            var this_class = this;

            $(selector).submit(function (e) {

                e.preventDefault();

                var method = $(this).attr('method');
                var action = $(this).attr('action');
                var form = $(this);
                var data = $(this).serialize();
                var button = $(this).find("[type='submit']");
                var alert_area = $(this).find(this_class.alert_selector);
                var input = $(this).find("[name='email']");


                button.removeAttr('disabled');


                $.ajax({
                    type: method,
                    url: action,
                    data: data,
                    dataType: 'json',

                    beforeSend: function () {
                        button.attr('disabled', 'disabled');
                    },

                    success: function (result) {

                        button.removeAttr('disabled');
                        alert_area.text(result.data.message);


                        if (result.success) {

                            alert_area.removeClass('no-message').addClass('success');
                            input.val('');
                        }

                    }

                });

            });

        },

    };

$(document).ready(function () {
    SubscribeMailChimpListMailChimpListAddMail.run();
});