(function (blocks, element, blockEditor, components) {

    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var MediaUpload = blockEditor.MediaUpload;
    var URLInputButton = blockEditor.URLInputButton;
    var Button = components.Button;

    blocks.registerBlockType("custom/hero-slider", {

        title: "Hero Slider",
        icon: "slides",
        category: "widgets",

        attributes: {
            imageUrl: { type: "string" },
            bannerText: { type: "string" },
            subText: { type: "string" },
            buttonText: { type: "string" },
            buttonLink: { type: "string" }
        },

        edit: function (props) {

            return el("div", { className: "hero-slider-block" },

                el(MediaUpload, {
                    onSelect: function (media) {
                        props.setAttributes({ imageUrl: media.url });
                    },
                    allowedTypes: ["image"],
                    render: function (obj) {
                        return el(Button, {
                            onClick: obj.open,
                            isPrimary: true
                        }, "Select Image");
                    }
                }),

                props.attributes.imageUrl &&
                el("img", {
                    src: props.attributes.imageUrl,
                    style: { width: "100%", marginTop: "10px" }
                }),

                el(RichText, {
                    tagName: "h2",
                    placeholder: "Banner Text",
                    value: props.attributes.bannerText,
                    onChange: function (val) {
                        props.setAttributes({ bannerText: val });
                    }
                }),

                el(RichText, {
                    tagName: "p",
                    placeholder: "Sub Text",
                    value: props.attributes.subText,
                    onChange: function (val) {
                        props.setAttributes({ subText: val });
                    }
                }),

                el(RichText, {
                    tagName: "span",
                    placeholder: "Button Text",
                    value: props.attributes.buttonText,
                    onChange: function (val) {
                        props.setAttributes({ buttonText: val });
                    }
                }),

                el(URLInputButton, {
                    url: props.attributes.buttonLink,
                    onChange: function (url) {
                        props.setAttributes({ buttonLink: url });
                    }
                })

            );
        },

        save: function (props) {

            return el("div", { className: "hero-slider" },

                props.attributes.imageUrl &&
                el("img", { src: props.attributes.imageUrl }),

                el("h2", {}, props.attributes.bannerText),
                el("p", {}, props.attributes.subText),

                props.attributes.buttonText &&
                el("a", {
                    href: props.attributes.buttonLink,
                    className: "hero-btn"
                }, props.attributes.buttonText)

            );
        }

    });

})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
