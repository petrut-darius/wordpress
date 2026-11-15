wp.blocks.registerBlockType("thepdi/footer", {
    title: "Footer",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the footer placeholder.");
}

function SaveComponent() {
    return null;
}