wp.blocks.registerBlockType("thepdi/header", {
    title: "Header",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the header placeholder.");
}

function SaveComponent() {
    return null;
}