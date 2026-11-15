wp.blocks.registerBlockType("thepdi/pagemynotes", {
    title: "My Notes Page",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the page for my-notes placeholder.");
}

function SaveComponent() {
    return null;
}