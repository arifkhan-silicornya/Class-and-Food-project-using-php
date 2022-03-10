function showDepartmentCreateAcc() {
    var department_Show = document.getElementById("department_Show");
    var batch_Show = document.getElementById("batch_Show");

    var userType = document.getElementById("userType").value;

    if (userType == "student") {
        department_Show.style.display = "block";
        batch_Show.style.display = "block";
    } else {
        department_Show.style.display = "none";
        batch_Show.style.display = "none";
    }
}

function loginForm() {
    var loginForm = document.getElementById("loginForm").style.display;

    if (loginForm == "none") {
        document.getElementById("loginForm").style.display = "flex";
    } else {
        document.getElementById("loginForm").style.display = "none";
    }

}


// ==============  Teacher Home input Field Refresh ============== 
// ================== Start ====================

var j = 0;
var count = document.getElementsByTagName("input").length;
var x = [];
while (j < count) {

    x[j] = document.getElementsByTagName("input")[j].placeholder;
    j++;
}

function inputFieldRefresh() {

    var i = 0;

    while (i < count) {

        document.getElementsByTagName("input")[i].value = "";
        document.getElementsByTagName("input")[i].placeholder = x[i];
        i++;
    }

}


// ================== End ====================
// ==============  Teacher Home input Field Refresh ==============