wp.blocks.registerBlockType("thepdi/singleprofessor", {
    title: "Single Professor",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the single page for professors placeholder.");
}

function SaveComponent() {
    return null;
}