(function ($) {
        $(document).ready(function () {

            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page');

            if (page && page.includes('wp-rank-tracker')) {
                const params = {
                    timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                };

                const options = {
                    method: 'POST',
                    body: JSON.stringify(params)
                };

                const endpoint = wprtObject.wprtRestUrl + 'user-timezone';

                fetch(endpoint, options);
            }
        })
})(jQuery);