(function (wp) {

    const { registerBlockType } = wp.blocks;
    const { RichText, InspectorControls, URLInputButton } = wp.blockEditor;
    const { PanelBody, ColorPalette, TextControl, SelectControl, ToggleControl } = wp.components;
    const el = wp.element.createElement;

    registerBlockType('custom/cta-block', {
        title: 'CTA Block Pro',
        icon: 'megaphone',
        category: 'widgets',

        attributes: {
            title: { type: 'string' },
            content: { type: 'string' },
            buttonText: { type: 'string', default: 'Click Here' },
            buttonURL: { type: 'string' },

            bgColor: { type: 'string', default: '#f5f5f5' },
            textColor: { type: 'string', default: '#000000' },
            buttonColor: { type: 'string', default: '#0073aa' },
            alignment: { type: 'string', default: 'center' },

            fullWidth: { type: 'boolean', default: false },
            maxWidth: { type: 'string', default: '1200px' },
            padding: { type: 'string', default: '30px' },
            borderRadius: { type: 'string', default: '8px' },
            boxShadow: { type: 'string', default: 'none' },
        },

        edit: ({ attributes, setAttributes }) => {

            const {
                title, content, buttonText, buttonURL,
                bgColor, textColor, buttonColor, alignment,
                fullWidth, maxWidth, padding, borderRadius, boxShadow
            } = attributes;

            return el('div', {
                style: {
                    background: bgColor,
                    color: textColor,
                    padding: padding,
                    textAlign: alignment,
                    borderRadius: borderRadius,
                    boxShadow: boxShadow
                }
            },

                // Sidebar Controls
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Design Settings' },

                        el(ToggleControl, {
                            label: 'Full Width',
                            checked: fullWidth,
                            onChange: (val) => setAttributes({ fullWidth: val })
                        }),

                        el(TextControl, {
                            label: 'Max Width',
                            value: maxWidth,
                            onChange: (val) => setAttributes({ maxWidth: val })
                        }),

                        el(TextControl, {
                            label: 'Padding',
                            value: padding,
                            onChange: (val) => setAttributes({ padding: val })
                        }),

                        el(TextControl, {
                            label: 'Border Radius',
                            value: borderRadius,
                            onChange: (val) => setAttributes({ borderRadius: val })
                        }),

                        el(TextControl, {
                            label: 'Box Shadow',
                            value: boxShadow,
                            onChange: (val) => setAttributes({ boxShadow: val })
                        }),

                        el('p', null, 'Background Color'),
                        el(ColorPalette, {
                            value: bgColor,
                            onChange: (val) => setAttributes({ bgColor: val })
                        }),

                        el('p', null, 'Text Color'),
                        el(ColorPalette, {
                            value: textColor,
                            onChange: (val) => setAttributes({ textColor: val })
                        }),

                        el('p', null, 'Button Color'),
                        el(ColorPalette, {
                            value: buttonColor,
                            onChange: (val) => setAttributes({ buttonColor: val })
                        }),

                        el(SelectControl, {
                            label: 'Alignment',
                            value: alignment,
                            options: [
                                { label: 'Left', value: 'left' },
                                { label: 'Center', value: 'center' },
                                { label: 'Right', value: 'right' }
                            ],
                            onChange: (val) => setAttributes({ alignment: val })
                        })
                    )
                ),

                // Content
                el(RichText, {
                    tagName: 'h2',
                    placeholder: 'Enter Title',
                    value: title,
                    onChange: (val) => setAttributes({ title: val })
                }),

                el(RichText, {
                    tagName: 'p',
                    placeholder: 'Enter Description',
                    value: content,
                    onChange: (val) => setAttributes({ content: val })
                }),

                el(TextControl, {
                    label: 'Button Text',
                    value: buttonText,
                    onChange: (val) => setAttributes({ buttonText: val })
                }),

                el(URLInputButton, {
                    url: buttonURL,
                    onChange: (url) => setAttributes({ buttonURL: url })
                }),

                el('div', { style: { marginTop: '15px' } },
                    el('a', {
                        href: '#',
                        style: {
                            background: buttonColor,
                            color: '#fff',
                            padding: '10px 20px',
                            display: 'inline-block',
                            textDecoration: 'none'
                        }
                    }, buttonText)
                )
            );
        },

        save: () => null
    });

})(window.wp);