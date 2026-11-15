wp.blocks.registerBlockType("thepdi/eventsandblogs", {
    title: "Events and Blogs",
    supports: {
        align: ["full"],
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent() {
    return wp.element.createElement("div", {className: "placeholder-block"}, "This is the events and blogs placeholder.");
}

function SaveComponent() {
    return null;
}