(function (blocks, element, blockEditor, components) {

    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var MediaUpload = blockEditor.MediaUpload;
    var Button = components.Button;

    blocks.registerBlockType("custom/mission-values", {

        title: "Mission & Values",
        icon: "groups",
        category: "widgets",

        attributes: {
            missionTitle: { type: "string", default: "Our mission" },
            missionText: { type: "string" },
            valuesTitle: { type: "string", default: "Our values" },
            rightImage: { type: "string" },
            valuesItems: { type: "array", default: [] }
        },

        edit: function (props) {

            var items = props.attributes.valuesItems;

            function addItem() {
                var newItems = items.slice();
                newItems.push({ icon: "", title: "", text: "" });
                props.setAttributes({ valuesItems: newItems });
            }

            function updateItem(index, field, value) {
                var newItems = items.slice();
                newItems[index][field] = value;
                props.setAttributes({ valuesItems: newItems });
            }

            return el("div", {},

                el(RichText, {
                    tagName: "h2",
                    value: props.attributes.missionTitle,
                    onChange: function (val) {
                        props.setAttributes({ missionTitle: val });
                    }
                }),

                el(RichText, {
                    tagName: "p",
                    value: props.attributes.missionText,
                    onChange: function (val) {
                        props.setAttributes({ missionText: val });
                    }
                }),

                el(RichText, {
                    tagName: "h2",
                    value: props.attributes.valuesTitle,
                    onChange: function (val) {
                        props.setAttributes({ valuesTitle: val });
                    }
                }),

                items.map(function (item, index) {
                    return el("div", { style: { border: "1px solid #ddd", padding: "10px", marginTop: "10px" } },

                        el(MediaUpload, {
                            onSelect: function (media) {
                                updateItem(index, "icon", media.url);
                            },
                            allowedTypes: ["image"],
                            render: function (obj) {
                                return el(Button, { onClick: obj.open }, "Select Icon");
                            }
                        }),

                        item.icon && el("img", { src: item.icon, style: { width: "50px" } }),

                        el(RichText, {
                            tagName: "h3",
                            placeholder: "Value Title",
                            value: item.title,
                            onChange: function (val) {
                                updateItem(index, "title", val);
                            }
                        }),

                        el(RichText, {
                            tagName: "p",
                            placeholder: "Value Text",
                            value: item.text,
                            onChange: function (val) {
                                updateItem(index, "text", val);
                            }
                        })
                    );
                }),

                el(Button, { onClick: addItem, isPrimary: true }, "Add Value Item"),

                el("hr"),

                el("p", {}, "Right Side Image"),

                el(MediaUpload, {
                    onSelect: function (media) {
                        props.setAttributes({ rightImage: media.url });
                    },
                    allowedTypes: ["image"],
                    render: function (obj) {
                        return el(Button, { onClick: obj.open }, "Select Right Image");
                    }
                }),

                props.attributes.rightImage &&
                el("img", { src: props.attributes.rightImage, style: { width: "150px" } })

            );
        },

        save: function (props) {

            return el("section", { className: "about-our-mission section-margin" },

                el("div", { className: "container" },

                    el("h2", { className: "section-title" }, props.attributes.missionTitle),
                    el("p", {}, props.attributes.missionText),

                    el("div", { className: "about-our-mission-row" },

                        el("h2", { className: "section-title" }, props.attributes.valuesTitle),

                        el("div", { className: "about-our-mission-column" },

                            el("div", { className: "content" },

                                props.attributes.valuesItems.map(function (item) {

                                    return el("div", { className: "single-item" },

                                        el("h3", {},
                                            el("div", { className: "border-icon" },
                                                item.icon && el("img", { src: item.icon })
                                            ),
                                            item.title
                                        ),

                                        el("p", {}, item.text)
                                    );

                                })

                            ),

                            el("div", { className: "img" },
                                props.attributes.rightImage &&
                                el("img", { src: props.attributes.rightImage })
                            )

                        )

                    )

                )

            );
        }

    });

})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
