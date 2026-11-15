wp.blocks.registerBlockType("thepdi/page", {
    title: "Simple Page placeholder",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the simple page placeholder.");
}

function SaveComponent() {
    return null;
}