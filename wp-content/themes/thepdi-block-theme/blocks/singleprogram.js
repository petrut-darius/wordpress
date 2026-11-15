wp.blocks.registerBlockType("thepdi/singleprogram", {
    title: "Single Program",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the single page for programs placeholder.");
}

function SaveComponent() {
    return null;
}