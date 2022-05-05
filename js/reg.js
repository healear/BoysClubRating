$(".registerbtn").on("click", function () {
    var userName = $("#login").val();
    var pwd = $("#password").val();
    $.ajax({
        type: 'POST',
        datatype: 'text',
        url: 'php/add_user.php',
        data: {
            'UserName': userName,
            'Password': pwd,
        },
        success: function (data) {
            console.log('THIS');
        },
    })
});