<?php
/*
session_start();
if(isset($_SESSION['username']))
{
  $pageName = (new PageView())->getLandingPage($_SESSION['role']);
  header("Location:".$pageName);
}
*/
?>

<!DOCTYPE html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="styles/css/stylesheet.css"/>
</head>
<body>
    <form method="post">
    <div>
        <div style=" margin-bottom:auto; background-color:rgb(230, 231, 233); color: #32383e; font-family: Trebuchet MS, sans-serif">
        <br/>
            <img style="display:inline;"  src="images/logo/logo.png" alt="" class="loginmainlogo"/>
        <h1 style="display:inline; font-weight:bold">Welcome to Zauq-e-Imtizaj</h1>

        <hr />
        </div>
        <br />

        <!---Login Box Start-->
        <div class="container" style="display: block; margin-left: auto; margin-right: auto; width: 35%; border: 1pt solid darkgray; border-radius: 1%; padding: 2rem; background-color: rgb(240, 240, 240);">
        <img src="images/logo/icon.png" alt="" class="loginlogo"/>
        <h2 style="text-align: center;">Login</h2>

        <div  class="form-group">
          <label for="exampleInputEmail1">Username</label>
          <input name="txtUsername" type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Enter Username">
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input name="txtPassword" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        <br/>
        <div class="form-group">
        <button name="btnLogin" type="submit" class="btn btn-secondary btn-txt btn-form" style="margin-left: 42%; padding-left: 2rem; padding-right: 2rem; padding-top:7px; padding-bottom:7px; font-size: 12pt;">Login</button>
        </div>
        <!---Login Box End-->
    </div>

    </form>
    
    <?php
        if(isset($_POST['btnLogin']) )
        {
            if(!empty($_POST['txtUsername']) && !empty($_POST['txtPassword']))
            {
                $UserViewObj = new UserView();

                if($UserViewObj->isUser($_POST['txtUsername']) && $UserViewObj->getPassword($_POST['txtUsername']) == $_POST['txtPassword'])
                {
                    $role = $UserViewObj->getRole($_POST['txtUsername']);
                    $_SESSION['username'] = $_POST['txtUsername'];
                    $_SESSION['role'] = $role;
                    $pageName = (new PageView())->getLandingPage($role);
                    $PageViewObj = new PageView();
                    $DBPages =  $PageViewObj->getAllPagesByRole($role);

                    $pages = array(
                        "PageName" => array(),
                        "PageLink" => array()
                    );
                    for($i = 0; $i < count($DBPages); $i++) {

                        $pages['PageName'][$i] = $DBPages[$i]['page_name'];
                        $pages['PageLink'][$i] = $DBPages[$i]['page_link'];   
                    }
                    $_SESSION['pages'] = $pages;
                    
                    header("Location:".$pageName);
                }
                else {
                  ?>
                  <script>alert('Credentials Incorrect!!!');</script>
                  <?php
                }
            }
            else
            {
              ?>
              <script>alert('Credentials Missing!');</script>
              <?php
            }
        }
    ?>
</body>
</html>
