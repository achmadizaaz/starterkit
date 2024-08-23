let allCheckbox = document.querySelectorAll(".checkbox").length,
    allCheckboxChecked = document.querySelectorAll(".checkbox:checked").length;
allCheckbox == allCheckboxChecked &&
    (document.getElementById("selectAll").checked = !0),
    $(document).ready(function () {
        // Checklist All
        $("#selectAll").click(function (e) {
            $(this)
                .closest("table")
                .find("td input:checkbox")
                .prop("checked", this.checked);
        }),
            $("table").on("change", "td input:checkbox", function () {
                let e;
                document.querySelectorAll(".checkbox").length ==
                document.querySelectorAll(".checkbox:checked").length
                    ? (document.getElementById("selectAll").checked = !0)
                    : (document.getElementById("selectAll").checked = !1);
            });
    });

// Checklist user
let userUnChecked = document.querySelectorAll(".user-group").length,
    userChecked = document.querySelectorAll(".user-group:checked").length;
function checkAllUser(e) {
    document
        .querySelectorAll(".user-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllUser() {
    document.querySelector("input.checkAllUser").checked =
        userUnChecked == userChecked;
}
$(".user-group").on("change", function () {
    let e;
    document.querySelectorAll(".user-group").length ==
    document.querySelectorAll(".user-group:checked").length
        ? (document.getElementById("all-user").checked = !0)
        : (document.getElementById("all-user").checked = !1);
}),
    userUnChecked == userChecked &&
        (document.getElementById("all-user").checked = !0);

// End Checklist User

// Checklist Role
let roleUnChecked = document.querySelectorAll(".role-group").length,
    roleChecked = document.querySelectorAll(".role-group:checked").length;
function checkAllRole(e) {
    document
        .querySelectorAll(".role-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllRole() {
    document.querySelector("input.checkAllRole").checked =
        roleUnChecked == roleChecked;
}
$(".role-group").on("change", function () {
    let e;
    document.querySelectorAll(".role-group").length ==
    document.querySelectorAll(".role-group:checked").length
        ? (document.getElementById("all-role").checked = !0)
        : (document.getElementById("all-role").checked = !1);
}),
    roleUnChecked == roleChecked &&
        (document.getElementById("all-role").checked = !0);

// End Checklist Role




// Checklist Option
let optionUnChecked = document.querySelectorAll(".option-group").length,
    optionChecked = document.querySelectorAll(".option-group:checked").length;
function checkAllOption(e) {
    document
        .querySelectorAll(".option-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllOption() {
    document.querySelector("input.checkAllOption").checked =
        optionUnChecked == optionChecked;
}
$(".option-group").on("change", function () {
    let e;
    document.querySelectorAll(".option-group").length ==
    document.querySelectorAll(".option-group:checked").length
        ? (document.getElementById("all-option").checked = !0)
        : (document.getElementById("all-option").checked = !1);
}),
    optionUnChecked == optionChecked &&
        (document.getElementById("all-option").checked = !0);

// End Checklist Option

// Tambahkan log untuk memastikan script ter-load
// console.log("Script loaded successfully");
