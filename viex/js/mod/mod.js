$(document).ready(function () {
    $("#container__specific").on("click", ".user_mod", function () {
        let user_id = this.id.split("_")[1];
        
        $.ajax({
            url: '../api/users/mod.php',
            type: 'POST',
            data: { user_id: user_id },
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                if (data.action == "Mod") {
                    $(`#user_mod_${user_id}`).html("Unmod");
                    $(`#container-mod_${user_id}`).removeClass("container__btn--mod");
                    $(`#container-mod_${user_id}`).addClass("container__btn--unmod");
                } else {
                    $(`#user_mod_${user_id}`).html("Mod");
                    $(`#container-mod_${user_id}`).removeClass("container__btn--unmod");
                    $(`#container-mod_${user_id}`).addClass("container__btn--mod");
                }   
            }
        })
    })
})