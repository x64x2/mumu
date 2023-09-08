function generatePassword() {
    var chars = "abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()";
    var passwordLength = 5;
    var password = "";
    for (var i = 0; i <= passwordLength; i++) {
        var randomNumber = Math.floor(Math.random() * characters.length);
        password += chars.substring(randomNumber, randomNumber +1);
    }
    document.getElementById("password").value = password;
}
function copyPassword() {
  var copyText = document.getElementById("password");
  copyText.select();
  copyText.setSelectionRange(0, 999);
  document.execCommand("copy");
  alert("copied to clipboard")
}