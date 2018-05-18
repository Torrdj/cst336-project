$(document).ready(function() {
    $("#sort").click(function(event) {
        console.log("1");
        $('#title').append("2");
    })
    $("#loginForm").submit(function(event)
    {
        //cancels the form submission
        event.preventDefault();

        var username = $("#username").val();
        var password = $("#password").val();

        $.ajax(
            {
                type: "POST",
                url: "inc/checkUser.php",
                data: "username=" + username + "&password=" + password,
                success: function(text)
                {
                    if (text == "success")
                    {

                    }
                }
            })
    })
} );