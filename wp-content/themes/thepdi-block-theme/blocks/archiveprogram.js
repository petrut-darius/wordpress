wp.blocks.registerBlockType("thepdi/archiveprogram", {
    title: "Archive Program",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the archive for programs placeholder.");
}

function SaveComponent() {
    return null;
}