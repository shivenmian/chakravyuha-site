document.getElementById("passwordbtn").onclick = function () { 
    var randompassword = passwordgenerator(8);
    document.getElementById("inputPassword").value = randompassword;
    document.getElementById("generated-pass").innerHTML = randompassword;
    document.getElementById('password-alert').style.display = 'block';
};

document.getElementById("usernamebtn").onclick = function () { 
    var randomuser = usernamegenerator();
    document.getElementById("inputUsername").value = randomuser;
};