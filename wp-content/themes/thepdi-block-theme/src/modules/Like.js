import $ from "jquery";

class Like {
    constructor() {
        this.events();
    }

    events() {
        $(".like-box").on("click", this.clickDispatcher.bind(this));
    }

    clickDispatcher(e) {
        var currentLikeBox = $(e.target).closest(".like-box");

        if(currentLikeBox.attr("data-exists") == "yes") {
            this.unlike(currentLikeBox);
        }else{
            this.like(currentLikeBox);
        }
    }

    like(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => { xhr.setRequestHeader("X-WP-Nonce", universityData.nonce); },
            url: universityData.root_url + "/wp-json/university/v1/like",
            data: {
                "professorId": currentLikeBox.attr("data-professor"),
            },
            type: "POST",
            success: (response) => {//response = like id
                currentLikeBox.attr("data-exists", "yes");
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
                currentLikeBox.find(".like-count").html(++likeCount);
                currentLikeBox.attr("data-like", response);
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            },
        });
    }

    unlike(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => { xhr.setRequestHeader("X-WP-Nonce", universityData.nonce); },
            url: universityData.root_url + "/wp-json/university/v1/like",
            data: {
                "likeId": currentLikeBox.attr("data-like"),
            },
            type: "DELETE",
            success: (response) => {
                currentLikeBox.attr("data-exists", "no");
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
                currentLikeBox.find(".like-count").html(--likeCount);
                currentLikeBox.attr("data-like", ""); 
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            },
        });
    }
}



export default Like;