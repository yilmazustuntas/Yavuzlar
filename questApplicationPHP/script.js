const homePageButton = document.getElementById("homePageButton");
const adminpanel = document.getElementById("adminpanel");
const studentButton = document.getElementById("studentButton");

function goToHomePage() {
   window.location.href = "index.php";
 }

    function admin() {
      window.location.href = "admin.php";
    }

    function register() {
      window.location.href = "register.php";
    }


    function studentlogin() {
      window.location.href = "studentLogin.php";
    }


    function student() {
      window.location.href = "student.php";
   }

    homePageButton.addEventListener("click", goToHomePage);
    adminpanel.addEventListener("click", admin);
    studentButton.addEventListener("click", student);