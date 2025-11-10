jQuery(document).ready(function ($) {
    // Attach click event to the dismiss button
    $(document).on('click', '.notice[data-notice="get-start"] button.notice-dismiss', function () {
        // Dismiss the notice via AJAX
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 't_shirt_printing_shop_dismissed_notice',
            },
            success: function () {
                // Remove the notice on success
                $('.notice[data-notice="example"]').remove();
            }
        });
    });
});

// WordClever – AI Content Writer plugin activation
document.addEventListener('DOMContentLoaded', function () {
    const t_shirt_printing_shop_button = document.getElementById('install-activate-button');

    if (!t_shirt_printing_shop_button) return;

    t_shirt_printing_shop_button.addEventListener('click', function (e) {
        e.preventDefault();

        const t_shirt_printing_shop_redirectUrl = t_shirt_printing_shop_button.getAttribute('data-redirect');

        // Step 1: Check if plugin is already active
        const t_shirt_printing_shop_checkData = new FormData();
        t_shirt_printing_shop_checkData.append('action', 'check_wordclever_activation');

        fetch(installWordcleverData.ajaxurl, {
            method: 'POST',
            body: t_shirt_printing_shop_checkData,
        })
        .then(res => res.json())
        .then(res => {
            if (res.success && res.data.active) {
                // Plugin is already active → just redirect
                window.location.href = t_shirt_printing_shop_redirectUrl;
            } else {
                // Not active → proceed with install + activate
                t_shirt_printing_shop_button.textContent = 'Installing & Activating...';

                const t_shirt_printing_shop_installData = new FormData();
                t_shirt_printing_shop_installData.append('action', 'install_and_activate_wordclever_plugin');
                t_shirt_printing_shop_installData.append('_ajax_nonce', installWordcleverData.nonce);

                fetch(installWordcleverData.ajaxurl, {
                    method: 'POST',
                    body: t_shirt_printing_shop_installData,
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        window.location.href = t_shirt_printing_shop_redirectUrl;
                    } else {
                        alert('Activation error: ' + (res.data?.message || 'Unknown error'));
                        t_shirt_printing_shop_button.textContent = 'Try Again';
                    }
                })
                .catch(error => {
                    alert('Request failed: ' + error.message);
                    t_shirt_printing_shop_button.textContent = 'Try Again';
                });
            }
        })
        .catch(error => {
            alert('Check request failed: ' + error.message);
        });
    });
});
