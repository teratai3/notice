(function (Drupal) {
    Drupal.behaviors.notice = {
        attach: function (context, settings) {
            document.querySelectorAll('.notice_my_module .notice_my_module_close').forEach(function (link) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    let noticeId = this.getAttribute('data-id');
                    document.cookie = "notice_closed_" + noticeId + "=true; path=/; max-age=31536000"; // 1年間有効なクッキーを設定

                    this.parentElement.style.display = 'none';
                });
            });
        }
    };
})(Drupal);