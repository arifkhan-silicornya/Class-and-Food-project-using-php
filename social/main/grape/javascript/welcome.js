function SK_headerSearch(e) {
    search_wrapper = $(".dropdown-search-container"), 0 == e.length ? search_wrapper.hide() : (search_wrapper.show(), SK_progressIconLoader(search_wrapper.find(".search-header")), $.get(SK_source(), {
        t: "search",
        a: "header",
        q: e
    }, function(e) {
        200 == e.status && (0 == e.html.length ? search_wrapper.find(".search-list-wrapper").html('<div class="no-wrapper">No result found!</div>').end().find("a.page-link").hide() : search_wrapper.find(".search-list-wrapper").html(e.html).end().find("a.page-link").attr("href", e.link).show()), SK_progressIconLoader(search_wrapper.find(".search-header"))
    }))
}

function SK_progressIconLoader(e) {
    return progress_icon_elem = e.find("i.progress-icon"), default_icon = progress_icon_elem.attr("data-icon"), hide_back = !1, 1 == progress_icon_elem.hasClass("hide") && (hide_back = !0), 1 == e.find("i.icon-spinner").length ? (progress_icon_elem.removeClass("icon-spinner").removeClass("icon-spin").addClass("icon-" + default_icon), 1 == hide_back && progress_icon_elem.hide()) : progress_icon_elem.removeClass("icon-" + default_icon).addClass("icon-spinner icon-spin").show(), !0
}

function SK_generateUsername(e) {
    var s = e.replace(/[^A-Za-z0-9_\-\.]/gi, "").toLowerCase();
    $(".register-username-textinput").val(s).keyup()
}

function SK_checkUsername(e, s, t, o) {
    t = $(t), target_html = "", $.get(SK_source(), {
        t: "username",
        a: "check",
        q: e,
        timeline_id: s
    }, function(e) {
        200 == e.status ? 1 == o ? target_html = '<span style="color: #94ce8c;"><i class="icon-ok"></i> Username available!</span>' : target_html = '<span style="color: #94ce8c;"><i class="icon-ok"></i></span>' : 201 == e.status ? 1 == o ? target_html = '<span style="color: #94ce8c;">This is you!</span>' : target_html = '<span style="color: #94ce8c;"></span>' : 410 == e.status ? 1 == o ? target_html = '<span style="color: #ee2a33;"><i class="icon-remove"></i> Username not available!</span>' : target_html = '<span style="color: #ee2a33;"><i class="icon-remove"></i></span>' : 406 == e.status && (1 == o ? target_html = '<span style="color: #ee2a33;"><i class="icon-remove"></i> Username should atleast be 4 characters, cannot be only numbers, can contain alphabets [A-Z], numbers [0-9] and underscores (_) only.</span>' : target_html = '<span style="color: #ee2a33;"><i class="icon-remove"></i></span>'), 0 == target_html.length ? t.html("").hide() : t.html(target_html).show()
    })
}
document_title = document.title, $(function() {
    $(".signup-form").ajaxForm({
        url: SK_source() + "?t=register",
        beforeSend: function() {
            signup_form = $(".signup-form"), signup_button = signup_form.find(".submit-btn"), signup_button.attr("disabled", !0), signup_form.find(".post-message").fadeOut("fast"), SK_progressIconLoader(signup_button)
        },
        success: function(e) {
            200 == e.status ? window.location = e.redirect_url : (signup_button.attr("disabled", !1), 0 == signup_form.find(".post-message").length ? signup_form.find(".form-header").after('<div class="post-message hidden">' + e.error_message + "</div>").end().find(".post-message").fadeIn("fast") : signup_form.find(".post-message").html(e.error_message).fadeIn("fast")), SK_progressIconLoader(signup_button)
        }
    }), $(".login-form").ajaxForm({
        url: SK_source() + "?t=login",
        beforeSend: function() {
            login_form = $(".login-form"), login_button = login_form.find(".submit-btn"), login_button.attr("disabled", !0), login_form.find(".post-message").fadeOut("fast"), SK_progressIconLoader(login_button)
        },
        success: function(e) {
            200 == e.status ? window.location = e.redirect_url : (login_button.attr("disabled", !1), 0 == login_form.find(".post-message").length ? login_form.find(".form-header").after('<div class="post-message hidden">' + e.error_message + "</div>").end().find(".post-message").fadeIn("fast") : login_form.find(".post-message").html(e.error_message).fadeIn("fast")), SK_progressIconLoader(login_button)
        }
    }), $(".forgotpass-form").ajaxForm({
        url: SK_source() + "?t=forgot_password",
        beforeSend: function() {
            forgotpass_form = $(".forgotpass-form"), forgotpass_button = forgotpass_form.find(".submit-btn"), forgotpass_button.attr("disabled", !0), forgotpass_form.find(".post-message").fadeOut("fast"), SK_progressIconLoader(forgotpass_button)
        },
        success: function(e) {
            forgotpass_button.attr("disabled", !1), 0 == forgotpass_form.find(".post-message").length ? forgotpass_form.find(".form-header").after('<div class="post-message hidden">' + e.message + "</div>").end().find(".post-message").fadeIn("fast") : forgotpass_form.find(".post-message").html(e.message).fadeIn("fast"), SK_progressIconLoader(forgotpass_button)
        }
    }), $(".passwordreset-form").ajaxForm({
        url: SK_source() + "?t=reset_password",
        beforeSend: function() {
            passwordreset_form = $(".passwordreset-form"), passwordreset_button = passwordreset_form.find(".submit-btn"), passwordreset_button.attr("disabled", !0), SK_progressIconLoader(passwordreset_button)
        },
        success: function(e) {
            200 == e.status ? (passwordreset_form.find(".form-header").after('<div class="post-message hidden">Successful! Please log in with your new password.</div>'), passwordreset_form.find(".post-message").fadeIn("fast", function() {
                $(this).fadeOut(4e3, function() {
                    $(this).remove(), window.location = e.url
                })
            })) : (passwordreset_button.attr("disabled", !1), passwordreset_form.find(".form-header").after('<div class="post-message hidden">Something went wrong! Please try again.</div>'), passwordreset_form.find(".post-message").fadeIn("fast", function() {
                $(this).fadeOut(4e3, function() {
                    $(this).remove()
                })
            })), SK_progressIconLoader(passwordreset_button)
        }
    }), $(document).on("focusin", "*[data-placeholder]", function() {
        elem = $(this), elem.val() == elem.attr("data-placeholder") && elem.val("")
    }), $(document).on("focusout", "*[data-placeholder]", function() {
        elem = $(this), 0 == elem.val().length && elem.val(elem.attr("data-placeholder"))
    }), $(document).on("keyup", "*[data-copy-to]", function() {
        elem = $(this), elem_val = elem.val(), elem_placeholder = elem.attr("data-placeholder"), elem_val == elem_placeholder ? $(elem.attr("data-copy-to")).val("") : $(elem.attr("data-copy-to")).val(elem_val)
    }), $(document).on("keyup", ".auto-grow-input", function() {
        elem = $(this), initialHeight = "10px", elem.attr("data-height") && (initialHeight = elem.attr("data-height") + "px"), this.style.height = initialHeight, this.style.height = this.scrollHeight + "px"
    })
});