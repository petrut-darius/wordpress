wp.blocks.registerBlockType("thepdi/blogindex", {
    title: "Blog Index placeholder",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the blog index placeholder.");
}

function SaveComponent() {
    return null;
}