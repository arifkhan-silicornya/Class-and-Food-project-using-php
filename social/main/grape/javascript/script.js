function SK_intervalUpdates() {
    $.get(SK_source(), {
        t: "interval"
    }, function(e) {
        "undefined" != typeof e.notifications && e.notifications > 0 ? ($(".notification-nav").find(".new-update-alert").text(e.notifications).show(), e.notifications != current_notif_count && (document.getElementById("notification-sound").play(), current_notif_count = e.notifications)) : ($(".notification-nav").find(".new-update-alert").hide(), current_notif_count = 0), "undefined" != typeof e.messages && e.messages > 0 ? ($(".message-nav").find(".new-update-alert").text(e.messages).show(), 1 == $(".online-header").length && (SK_getOnlineList(""), $(".online-header").find(".update-alert").show()), 1 == $(".chat-wrapper").length && loadNewChatMessages(), e.messages != current_msg_count && (document.getElementById("notification-sound").play(), current_msg_count = e.messages)) : ($(".message-nav").find(".new-update-alert").hide(), 1 == $(".online-header").length && $(".online-header").find(".update-alert").hide(), current_msg_count = 0), "undefined" != typeof e.follow_requests && e.follow_requests > 0 ? ($(".followers-nav").attr("href", $(".followers-nav").attr("href").replace("following", "requests")).find(".new-update-alert").text(e.follow_requests).show(), e.follow_requests != current_followreq_count && (document.getElementById("notification-sound").play(), current_followreq_count = e.follow_requests)) : ($(".followers-nav").find(".new-update-alert").hide(), current_followreq_count = 0)
    })
}

function SK_registerFollow(e) {
    element = $(".follow-" + e), SK_progressIconLoader(element), $.post(SK_source() + "?t=follow&a=follow", {
        following_id: e
    }, function(e) {
        200 == e.status && (element.after(e.html), element.remove())
    })
}

function SK_openLightbox(e) {
    $(".header-wrapper").width() < 960 ? window.location = "index.php?tab1=story&id=" + e : ($(".sc-lightbox-container").remove(), $(document.body).append('<div class="pre_load_wrap"><div class="bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div></div>'), $.get(SK_source(), {
        t: "post",
        a: "lightbox",
        post_id: e
    }, function(e) {
        200 == e.status ? $(document.body).append(e.html) : $(".pre_load_wrap").remove()
    }))
}

function SK_getChat(e, t) {
    chat_container = $(".chat-container"), 1 == chat_container.length ? $(".header-wrapper").width() < 960 ? (startPageLoadingBar(), SK_loadPage("?tab1=messages&recipient_id=" + e)) : ($(document.body).attr("data-chat-recipient", e), $(".chat-recipient-name").text(t), $(".chat-wrapper").show(), $.get(SK_source(), {
        t: "chat",
        a: "load_messages",
        recipient_id: e
    }, function(t) {
        200 == t.status && ($(".chat-wrapper").remove(), $(".chat-container").prepend(t.html), $(".chat-wrapper").show(), $(".chat-textarea textarea").keyup(), $("#online_" + e).find(".update-alert").hide(), SK_intervalUpdates()), setTimeout(function() {
            $(".chat-messages").scrollTop($(".chat-messages").prop("scrollHeight"))
        }, 500)
    })) : (startPageLoadingBar(), SK_loadPage("?tab1=messages&recipient_id=" + e))
}

function SK_closeWindow() {
    $(".window-container").remove(), $(document.body).css("overflow", "auto")
}

function SK_progressIconLoader(e) {
    e.each(function() {
        return progress_icon_elem = $(this).find("i.progress-icon"), default_icon = progress_icon_elem.attr("data-icon"), hide_back = !1, 1 == progress_icon_elem.hasClass("hide") && (hide_back = !0), 1 == $(this).find("i.icon-spinner").length ? (progress_icon_elem.removeClass("icon-spinner").removeClass("icon-spin").addClass("icon-" + default_icon), 1 == hide_back && progress_icon_elem.hide()) : progress_icon_elem.removeClass("icon-" + default_icon).addClass("icon-spinner icon-spin").show(), !0
    })
}

function SK_progressImageLoader(e) {
    e.each(function() {
        return elm=$(this),"none"==elm.css("display")?(elm.next("i.progress-icon").remove(),elm.show()):(elm.hide(),elm.after('<i class="fa fa-spinner fa-spin progress-icon"></i>'))
    })
}

function SK_generateUsername(e) {
    var t = e.replace(/[^A-Za-z0-9_\-\.]/gi, "").toLowerCase();
    $(".register-username-textinput").val(t).keyup()
}

function addEmoToInput(e, t) {
    inputTag = $(t), inputVal = inputTag.val(), "undefined" != typeof inputTag.attr("placeholder") && (inputPlaceholder = inputTag.attr("placeholder"), inputPlaceholder == inputVal && (inputTag.val(""), inputVal = inputTag.val())), 0 == inputVal.length ? inputTag.val(e + " ") : inputTag.val(inputVal + " " + e), inputTag.keyup()
}

function updateCountAlert() {
    $(".update-alert").each(function() {
        update_count = $(this).text(), update_count = 1 * update_count, 0 == update_count && $(this).addClass("hidden")
    })
}
document_title = document.title, current_notif_count = 0, current_msg_count = 0, current_followreq_count = 0, $(function() {
    setInterval(function() {
        SK_intervalUpdates()
    }, 1e4), 1 == $(".chat-wrapper").length && $(".chat-messages").scrollTop($(this).prop("scrollHeight")), $(document).on("focusin", "*[data-placeholder]", function() {
        elem = $(this), elem.val() == elem.attr("data-placeholder") && elem.val("")
    }), $(document).on("focusout", "*[data-placeholder]", function() {
        elem = $(this), 0 == elem.val().length && elem.val(elem.attr("data-placeholder"))
    }), $(document).on("keyup", "*[data-copy-to]", function() {
        elem = $(this), elem_val = elem.val(), elem_placeholder = elem.attr("data-placeholder"), elem_val == elem_placeholder ? $(elem.attr("data-copy-to")).val("") : $(elem.attr("data-copy-to")).val(elem_val)
    }), $(document).on("keyup", ".auto-grow-input", function() {
        elem = $(this), initialHeight = "10px", elem.attr("data-height") && (initialHeight = elem.attr("data-height") + "px"), this.style.height = initialHeight, this.style.height = this.scrollHeight + "px"
    })
});