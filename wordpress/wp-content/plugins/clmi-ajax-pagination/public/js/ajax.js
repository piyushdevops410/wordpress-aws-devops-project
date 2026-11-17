jQuery(function ($) {

    if (typeof clmi_ajax === 'undefined') {
        console.error('clmi_ajax not defined');
        return;
    }

    let page = 1;
    let maxPage = 1;
    let loading = false;

    const container = $('#clmi-container');
    if (!container.length) return;

    const postType = container.data('post-type') || 'post';
    const paginationType = container.data('pagination') || 'load_more';

    const postsWrap = container.find('.clmi-posts');
    const loadMoreBtn = container.find('#clmi-load-more');
    const loader = container.find('.clmi-loader');

    function loadPosts(pageNum, append = true) {

        if (loading) return;
        loading = true;

        loader.show();

        $.ajax({
            url: clmi_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'clmi_load',
                page: pageNum,
                post_type: postType,
                nonce: clmi_ajax.nonce
            },
            success: function (res) {

                loader.hide();
                loading = false;

                if (!res || !res.success || !res.data) {
                    postsWrap.html('<p>No posts found</p>');
                    loadMoreBtn.hide();
                    return;
                }

                let html = res.data.html;
                maxPage = parseInt(res.data.max) || 1;

                if (!html || !html.trim()) {
                    if (!append) {
                        postsWrap.html('<p>No posts found</p>');
                    }
                    loadMoreBtn.hide();
                    return;
                }

                if (append) {
                    postsWrap.append(html);
                } else {
                    postsWrap.html(html);
                }

                //  LOAD MORE
                if (paginationType === 'load_more') {
                    if (page < maxPage) {
                        loadMoreBtn.show();
                    } else {
                        loadMoreBtn.hide();
                    }
                }

                //  NUMBERS
                if (paginationType === 'numbers') {
                    generatePagination();
                    loadMoreBtn.hide();
                }

                //  INFINITE
                if (paginationType === 'infinite') {
                    loadMoreBtn.hide();
                }

            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                loader.hide();
                loading = false;
            }
        });
    }

    //  Initial load
    loadPosts(page, false);

    //  Load More Click
    container.on('click', '#clmi-load-more', function () {

        if (page < maxPage && !loading) {
            page++;
            loadPosts(page, true);
        } else {
            $(this).hide();
        }

    });

    //  Generate Number Pagination
    function generatePagination() {

        if (maxPage <= 1) {
            container.find('.clmi-pagination').html('');
            return;
        }

        let html = '';

        for (let i = 1; i <= maxPage; i++) {
            let active = (i === page) ? 'active' : '';
            html += `<button class="clmi-page ${active}" data-page="${i}">${i}</button>`;
        }

        container.find('.clmi-pagination').html(html);
    }

    //  Number Click
    container.on('click', '.clmi-page', function () {

        let selected = $(this).data('page');

        if (selected === page) return;

        page = selected;

        container.find('.clmi-page').removeClass('active');
        $(this).addClass('active');

        loadPosts(page, false);
    });

    //  Infinite Scroll
    if (paginationType === 'infinite') {

        let scrollTimer;

        $(window).on('scroll', function () {

            if (scrollTimer) return;

            scrollTimer = setTimeout(function () {

                scrollTimer = null;

                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {

                    if (page < maxPage && !loading) {
                        page++;
                        loadPosts(page, true);
                    }

                }

            }, 200);

        });

    }

});