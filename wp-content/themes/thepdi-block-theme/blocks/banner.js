import { registerBlockType } from "@wordpress/blocks";
import { InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck} from "@wordpress/block-editor"
import { Button, PanelBody, PanelRow} from "@wordpress/components";
import apiFetch from "@wordpress/api-fetch";
import { useEffect } from "@wordpress/element";

registerBlockType("thepdi/banner", {
    title: "Banner",
    supports: {
        align: ["full"],
    },
    attributes: {
        align: {
            type: "string",
            default: "full",
        },
        imageID: {
            type: "number",
        },
        imageURL: {
            type: "string",
            default: banner.fallbackimage
        }
    },
    edit: EditComponent,
    save: SaveComponent,
});

function EditComponent(props) {
    useEffect(() => {
        async function go() {
            if(props.attributes.imageID) {
                const response = await apiFetch({
                    path: `/wp/v2/media/${props.attributes.imageID}`,
                    method: "GET",
                });
                props.setAttributes({imageURL: response.media_details.sizes.pageBanner.source_url});
            }
        };
        go();
    }, [props.attributes.imageID]);
    
    function handleBackgroundImageSelect(x) {
        console.log(x);
        props.setAttributes({imageID: x.id});
    }

    return (
        <>
            <InspectorControls>
                <PanelBody title="Background Image" initialOpen={true}>
                    <PanelRow>
                        <MediaUploadCheck>
                            <MediaUpload onSelect={handleBackgroundImageSelect} value={props.attributes.imageID} render={({open}) => {
                                return <Button onClick={open}>Choose Image</Button>
                            }} />
                        </MediaUploadCheck>
                    </PanelRow>
                </PanelBody>
            </InspectorControls>

            <div className="bg-black pt-[80px] pb-[40px] relative">
                <div 
                    className="absolute inset-0 bg-cover bg-center opacity-80" 
                    style={{
                        backgroundImage: props.attributes.imageURL
                            ? `url('${props.attributes.imageURL}')`
                            : "",
                    }}
                ></div>
                <div className="text-center relative z-10 text-white">
                    <InnerBlocks allowedBlocks={["thepdi/genericheading", "thepdi/custombutton"]} />
                </div>
            </div>
        </>
    );
}

function SaveComponent() {
    return <InnerBlocks.Content />
}