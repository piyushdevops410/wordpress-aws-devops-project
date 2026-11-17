wp.domReady(() => {

    wp.blocks.registerBlockVariation('core/button', {
        name: 'coreflux-cta',
        title: 'CTA Button',
        attributes: {
            className: 'is-style-fill',
        },
        innerBlocks: [
            ['core/button', { text: 'Get Started' }]
        ],
        scope: ['inserter']
    });

});