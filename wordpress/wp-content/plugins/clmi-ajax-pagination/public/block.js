(function (blocks, element) {

    var el = element.createElement;

    blocks.registerBlockType('clmi/ajax-pagination', {
        title: 'CLMI AJAX Pagination',
        icon: 'list-view',
        category: 'widgets',
        keywords: ['ajax', 'pagination', 'load more'],

        edit: function () {
            return el(
                'p',
                { style: { padding: '10px', border: '1px dashed #ccc' } },
                'AJAX Pagination will render on frontend.'
            );
        },

        save: function () {
            return null; // Dynamic block (important)
        }
    });

})(window.wp.blocks, window.wp.element);