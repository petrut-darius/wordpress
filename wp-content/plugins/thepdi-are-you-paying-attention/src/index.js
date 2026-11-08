import "./index.scss";
import {TextControl, Flex, FlexBlock, FlexItem, Button, PanelBody, PanelRow} from "@wordpress/components";
import {Icon, table, starFilled, starEmpty} from "@wordpress/icons";
import {InspectorControls, BlockControls, AlignmentToolbar} from "@wordpress/block-editor";
import {ChromePicker} from "react-color";

(function() {
    let locked = false;

    wp.data.subscribe(() => {
        const results = wp.data.select("core/block-editor").getBlocks().filter((block) => {
            return block.name == "thepdiplugin/are-you-paying-attention" && block.attributes.correctAnswer == undefined;
        });

        if(results.length && locked == false) {
            locked = true;
            wp.data.dispatch("core/editor").lockPostSaving("noanswer");
        }

        if(!results.length && locked) {
            locked = false;
            wp.data.dispatch("core/editor").unlockPostSaving("noanswer");
        }
    });
})();


wp.blocks.registerBlockType("thepdiplugin/are-you-paying-attention", {
    title: "thepdi - Are you paying attention?",
    description: "this a quiz type block that I created",
    icon: table,
    category: "common",
    attributes: {
        question: {
            type: "string"
        },
        answers: {
            type: "array",
            default: [],
        },
        correctAnswer: {
            type: "number",
            default: undefined,
        },
        bgColor: {
            type: "string",
            default: "#EBEBEB",
        },
        alingment: {
            type: "string",
            default: "left",
        }
    },
    example: {
        attributes: {
            question: "Audi?",
            answers: ["yes", "no"],
            correctAnswer: 0,
            bgColor: "#fab935",
            alingment: "right",
        }
    },
    edit: EditBlock,
    save: () => null,
});

function EditBlock(props) {
    function updateQuestion(value) {
        props.setAttributes({question: value});
    }
    
    function deleteAnswer(answerIndex) {
        const newAnswears = props.attributes.answers.filter((x, index) => {
            return index != answerIndex;
        });

        props.setAttributes({answers: newAnswears});

        if(answerIndex == props.attributes.correctAnswer) {
            props.setAttributes({correctAnswer: undefined});
        }
    }

    function markAsCorrect(answerIndex) {
        props.setAttributes({correctAnswer: answerIndex});
    }

    return (
        <div className="paying-attention-edit-block" style={{backgroundColor: props.attributes.bgColor}}>
            <BlockControls>
                <AlignmentToolbar value={props.attributes.alingment} onChange={(newAlingment) => props.setAttributes({alingment: newAlingment})} />
            </BlockControls>
            <InspectorControls>
                <PanelBody title="Background Color" initialOpen={true}>
                    <PanelRow>
                        <ChromePicker color={props.attributes.bgColor} onChangeComplete={(newColor) => {props.setAttributes({bgColor: newColor.hex})}} disableAlpha={true}/>
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <TextControl value={props.attributes.question} onChange={updateQuestion} label="Question:"/>
            <p style={{fontSize: "13px", margin: "20px 0 8px 0"}}>Answers:</p>
            {
                props.attributes.answers.map((answer, index) => {
                    return (
                        <Flex>
                            <FlexBlock>
                                <TextControl value={answer} onChange={(newValue) => {
                                    const newAnswers = props.attributes.answers.concat([]);

                                    newAnswers[index] = newValue;

                                    props.setAttributes({answers: newAnswers});
                                }} />
                            </FlexBlock>
                            <FlexItem>
                                <Button onClick={() => markAsCorrect(index)}>
                                    <Icon className="mark-as-correct" icon={props.attributes.correctAnswer == index ? starFilled : starEmpty} />
                                </Button>
                            </FlexItem>
                            <FlexItem>
                                <Button link className="attention-delete" onClick={() => deleteAnswer(index)}>Delete</Button>
                            </FlexItem>
                        </Flex>
                    );
                })}
            <Button isPrimary onClick={() => { props.setAttributes({answers: props.attributes.answers.concat([""])}) }}>Add another answer</Button>
        </div>
    );
};