wp.blocks.registerBlockType("thepdi/singlepost", {
    title: "Single Post placeholder",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the single post placeholder.");
}

function SaveComponent() {
    return null;
}