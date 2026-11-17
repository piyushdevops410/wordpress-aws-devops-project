const { registerBlockType } = wp.blocks;
const { RichText, InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl, ToggleControl } = wp.components;
const { Fragment } = wp.element;

registerBlockType('custom/block-example', {

    title: 'Custom Block (ACF Like)',
    icon: 'admin-post',
    category: 'widgets',

    attributes: {
        title: { type: 'string', default: '' },
        description: { type: 'string', default: '' },
        showButton: { type: 'boolean', default: true },
        buttonText: { type: 'string', default: 'Read More' }
    },

    edit: (props) => {

        const { attributes, setAttributes } = props;

        return (
            React.createElement(Fragment, null,

                /* Sidebar Fields (Like ACF Backend Fields) */
                React.createElement(InspectorControls, null,
                    React.createElement(PanelBody, { title: "Block Settings", initialOpen: true },

                        React.createElement(TextControl, {
                            label: "Title",
                            value: attributes.title,
                            onChange: (val) => setAttributes({ title: val })
                        }),

                        React.createElement(TextControl, {
                            label: "Button Text",
                            value: attributes.buttonText,
                            onChange: (val) => setAttributes({ buttonText: val })
                        }),

                        React.createElement(ToggleControl, {
                            label: "Show Button",
                            checked: attributes.showButton,
                            onChange: (val) => setAttributes({ showButton: val })
                        })
                    )
                ),

                /* Editor Content */
                React.createElement("div", { className: "custom-block" },

                    React.createElement(RichText, {
                        tagName: "h2",
                        placeholder: "Enter Title",
                        value: attributes.title,
                        onChange: (val) => setAttributes({ title: val })
                    }),

                    React.createElement(RichText, {
                        tagName: "p",
                        placeholder: "Enter Description",
                        value: attributes.description,
                        onChange: (val) => setAttributes({ description: val })
                    }),

                    attributes.showButton &&
                    React.createElement("button", null, attributes.buttonText)
                )
            )
        );
    },

    save: (props) => {

        const { attributes } = props;

        return (
            React.createElement("div", { className: "custom-block" },

                React.createElement("h2", null, attributes.title),
                React.createElement("p", null, attributes.description),

                attributes.showButton &&
                React.createElement("button", null, attributes.buttonText)
            )
        );
    }
});
