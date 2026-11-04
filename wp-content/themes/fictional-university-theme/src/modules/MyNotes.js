import $ from "jquery";

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $("#my-notes").on("click", ".edit-note", this.editNote.bind(this));
        $("#my-notes").on("click", ".delete-note" , this.deleteNote.bind(this));
        $("#my-notes").on("click", ".update-note", this.updateNote.bind(this));
        $(".submit-note").on("click", this.createNote.bind(this));
    }

    createNote() {
        var createdNote = {
            "title": $(".new-note-title").val(),
            "content": $(".new-note-body").val(),
            "status": "publish",
        }

        $.ajax({
            beforeSend: (xhr) => { xhr.setRequestHeader("X-WP-Nonce", universityData.nonce); },
            url: universityData.root_url + "/wp-json/wp/v2/note",
            method: "POST",
            data: createdNote,
            success: (response) => {
                $(".new-note-title, .new-note-body").val("");
                $(`
                    <li data-id="${response.id}" data-state="cancel">
                        <input class="note-title-field" readonly value="${response.title.raw}">
                        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
                        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                        <textarea class="note-body-field" readonly>${response.content.raw}</textarea>
                        <button class="update-note btn btn--blue btn--small" type="submit" aria-hidden="true">Save</button>
                    </li>
                `).prependTo("#my-notes").hide().slideDown();
            },
            error: (response) => {
                if(response.responseText === "You have reached your note limit.") {
                    $(".note-limit-message").addClass("active");
                }
            },
        })
    }

    /*next lecture -> 19 - 08 */

    updateNote(e) {
        var thisNote = $(e.target).parents("li");

        var updatedNote = {
            "title": thisNote.find(".note-title-field").val(),
            "content": thisNote.find(".note-body-field").val(),
        }

        $.ajax({
            beforeSend: (xhr) => { xhr.setRequestHeader("X-WP-Nonce", universityData.nonce); },
            url: universityData.root_url + `/wp-json/wp/v2/note/${thisNote.data("id")}`,
            method: "PATCH",
            data: updatedNote,
            success: (response) => {
                this.makeNoteReadOnly(thisNote);
            },
            error: () => {
                console.log("Sorry");
            },
        })
    }

    editNote(e) {
        var thisNote = $(e.target).parents("li");

        if(thisNote.data("state") === "editable") {
            this.makeNoteReadOnly(thisNote);
        }else{
            this.makeNoteEditable(thisNote);
        }
    }

    makeNoteEditable(thisNote) {
        thisNote.find(".edit-note").html("<i class='fa fa-times' aria-hidden='true'></i>Cancel");
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        thisNote.find(".update-note").addClass("update-note--visible");
        thisNote.data("state", "editable");
    }

    makeNoteReadOnly(thisNote) {
        thisNote.find(".edit-note").html("<i class='fa fa-pencil' aria-hidden='true'></i>Edit");
        thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
        thisNote.find(".update-note").removeClass("update-note--visible");
        thisNote.data("state", "cancel");
    }

    deleteNote(e) {
        var thisNote = $(e.target).parents("li");

        $.ajax({
            beforeSend: (xhr) => { xhr.setRequestHeader("X-WP-Nonce", universityData.nonce); },
            url: universityData.root_url + `/wp-json/wp/v2/note/${thisNote.data("id")}`,
            method: "DELETE",
            success: (response) => {
                thisNote.slideUp();

                if(response.userNoteCount < 5) {
                    $(".note-limit-message").removeClass("active");
                }
            },
            error: () => {
                console.log("Sorry");
            },
        })
    }
}

export default MyNotes;