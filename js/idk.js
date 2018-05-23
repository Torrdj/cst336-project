$(document).ready(function() {
    $("#sort").click(function(event) {
        console.log("1");
        $('#title').append("2");
    })

    $("#pokedex tr").click(function()
    {
        window.location = 'pokemon.php?id=' + this.id;
    })

    /*
    $("#submitLogin").click(function(event)
    {
        //cancels the form submission
        //event.preventDefault();

        var username = $("#username").val();
        var password = $("#password").val();

        $.ajax({
                type: "POST",
                url: "inc/checkUser.php",
                data: {"username" : username, "password" : password},
                success: function(data)
                {
                    if (data[0] == "success")
                    {
                        window.location.href = 'index.php';
                        console.log(data);
                    }
                    else
                    {
                        console.log(data);
                    }
                }
            });
    });*/
} );