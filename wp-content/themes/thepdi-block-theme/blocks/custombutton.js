import { registerBlockType } from "@wordpress/blocks";
import { RichText, BlockControls, __experimentalLinkControl as LinkControl, InspectorControls, getColorObjectByColorValue } from "@wordpress/block-editor";
import { Button, Popover, ToolbarButton, ToolbarGroup, PanelBody, PanelRow, ColorPalette } from "@wordpress/components";
import { link } from "@wordpress/icons";
import { useState } from "@wordpress/element";
import blockColors from "../inc/blockColors";


registerBlockType("thepdi/custombutton", {
    title: "Custom Button",
    attributes: {
        text: {
            type: "string",
        },
        size: {
            type: "string",
            default: "large"
        },
        linkObject: {
            type: "object",
            default: {url: ""}
        },
        backgroundColorName: {
            type: "string",
            default: "blue",
        }
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent(props) {
    function handleTextChange(newButtonValue) {
        props.setAttributes({text: newButtonValue});
    }

    const [isLinkPickerActive, setIsLinkPickerActive] = useState(false);

    function buttonHandler() {
        setIsLinkPickerActive(!isLinkPickerActive);
    }

    function handleLinkChange(newLinkValue) {
        props.setAttributes({linkObject: newLinkValue});
    }

    function handleColorChange(newColorCode) {
        // from hex to string
        const { name } = getColorObjectByColorValue(blockColors, newColorCode);
        props.setAttributes({backgroundColorName: name});
    }

    const currentColorCode = blockColors.filter((color) => {
        return color.name === props.attributes.backgroundColorName;
    })[0].color;

    return (
        <>
            <BlockControls>
                <ToolbarGroup>
                    <ToolbarButton onClick={buttonHandler} icon={link} />
                </ToolbarGroup>
                <ToolbarGroup>
                    <ToolbarButton isPressed={props.attributes.size === "large"} onClick={() => props.setAttributes({size: "large"})}>Large</ToolbarButton>
                    <ToolbarButton isPressed={props.attributes.size === "medium"} onClick={() => props.setAttributes({size: "medium"})}>Medium</ToolbarButton>
                    <ToolbarButton isPressed={props.attributes.size === "small"} onClick={() => props.setAttributes({size: "small"})}>Small</ToolbarButton>
                </ToolbarGroup>
            </BlockControls>

            <InspectorControls>
                <PanelBody title="Color" initialOpen={true}>
                    <PanelRow>
                        <ColorPalette colors={blockColors} value={currentColorCode} onChange={handleColorChange} disableCustomColors={true} clearable={false}/>
                    </PanelRow>
                </PanelBody>
            </InspectorControls>

            <RichText allowedFormats={[]} tagName="a" className={`btn btn--${props.attributes.size} btn--${props.attributes.backgroundColorName}`} value={props.attributes.text} onChange={handleTextChange} />

            {/* popover for link value */}
            {isLinkPickerActive && (
                <Popover position="middle center">
                    <LinkControl settings={[]} value={props.attributes.linkObject} onChange={handleLinkChange} />
                    <Button variant="primary" onClick={() => setIsLinkPickerActive(false)} style={{display: "block", width: "100%"}}>Confirm Link</Button>
                </Popover>
            )}
        </>
    );
}

function SaveComponent(props) {
    return <a href={props.attributes.linkObject.url} className={`btn btn--${props.attributes.size} btn--${props.attributes.backgroundColorName}`}>{props.attributes.text}</a>
}