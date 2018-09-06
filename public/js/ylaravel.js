$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * 富文本编辑器图片上传
 * @type {wangEditor}
 */
var editor = new wangEditor('content');

if (editor.config) {
    editor.config.uploadImgUrl = '/posts/image/upload';

    // 设置 headers（举例）传递csrf的token
    editor.config.uploadHeaders = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    editor.create();
}

/**
 * 关注按钮
 */
$(".like-button").click(function (event) {
    var target = $(event.target);
    var current_like = target.attr("like-value");
    var user_id = target.attr("like-user");

    // 已经关注了
    if (current_like == 1) {
        // 取消关注
        $.ajax({
            url: "/user/" + user_id + "/unfan",
            method: 'POST',
            dataType: "json",
            success: function success(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }
                target.attr("like-value", 0);
                target.text("关注");

            }
            // error: function (data) {
            //     if (data.error != 0) {
            //         alert(data.msg);
            //         return;
            //     }
            //     target.attr("like-value", 0);
            //     target.text("取消关注");
            // }
        });
    } else {
        // 关注
        $.ajax({
            url: "/user/" + user_id + "/fan",
            method: 'POST',
            dataType: "json",
            success: function success(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }
                target.attr("like-value", 1);
                target.text("取消关注");
            }
            // error: function (data) {
            //     if (data.error != 0) {
            //         alert(data.msg);
            //         return;
            //     }
            //     target.attr("like-value", 0);
            //     target.text("关注");
            // }
        });
    }
});

/**
 * 123
 */
$(".preview_input"), change(function (event) {
    var file = event.currentTarget.files[0];
    var url = window.URL.createObjectURL(file);
    $(event.target).next(".preview_img"), attr("src", url);
});