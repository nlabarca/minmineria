<html lang="en" class="perfect-scrollbar-off"><head>
  <meta charset="utf-8">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>
    Material Dashboard PRO by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.min.css?v=2.1.0" rel="stylesheet">
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet">
  
</head>

<body class="">
   <!-- End Google Tag Manager (noscript) -->
  <div class="wrapper ">
    <div class="sidebar" data-color="rose" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          CT
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Creative Tim
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo"></div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                Tania Andrew
                <b class="caret"></b>
              </span>
            </a>
            <div class="collapse" id="collapseExample">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> MP </span>
                    <span class="sidebar-normal"> My Profile </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> EP </span>
                    <span class="sidebar-normal"> Edit Profile </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> S </span>
                    <span class="sidebar-normal"> Settings </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" href="../../examples/dashboard.html">
              <i class="material-icons">dashboard</i>
              <p> Dashboard </p>
            </a>
          </li>
          
          
          <li class="nav-item active ">
            <a class="nav-link" data-toggle="collapse" href="#formsExamples" aria-expanded="true">
              <i class="material-icons">content_paste</i>
              <p> Forms
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse show" id="formsExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="../../examples/forms/regular.html">
                    <span class="sidebar-mini"> RF </span>
                    <span class="sidebar-normal"> Regular Forms </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="../../examples/forms/extended.html">
                    <span class="sidebar-mini"> EF </span>
                    <span class="sidebar-normal"> Extended Forms </span>
                  </a>
                </li>
                <li class="nav-item active ">
                  <a class="nav-link" href="../../examples/forms/validation.html">
                    <span class="sidebar-mini"> VF </span>
                    <span class="sidebar-normal"> Validation Forms </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="../../examples/forms/wizard.html">
                    <span class="sidebar-mini"> W </span>
                    <span class="sidebar-normal"> Wizard </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          
          
          
          
          
        </ul>
      </div>
    <div class="sidebar-background" style="background-image: url(assets/img/sidebar-1.jpg) "></div></div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Validation Forms</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form id="TypeValidation" class="form-horizontal" action="" method="" novalidate="novalidate">
                <div class="card ">
                  <div class="card-header card-header-rose card-header-text">
                    <div class="card-text">
                      <h4 class="card-title">Type Validation</h4>
                    </div>
                  </div>
                  <div class="card-body ">
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Required Text</label>
                      <div class="col-sm-7">
                        <div class="form-group bmd-form-group has-danger">
                          <input class="form-control" type="text" name="required" required="true" aria-required="true" aria-invalid="true">
                        <label id="required-error" class="error" for="required">This field is required.</label></div>
                      </div>
                      <label class="col-sm-3 label-on-right">
                        <code>required</code>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-7">
                        <div class="form-group bmd-form-group has-danger">
                          <input class="form-control" type="text" name="email" email="true" required="true" aria-required="true">
                        <label id="email-error" class="error" for="email">This field is required.</label></div>
                      </div>
                      <label class="col-sm-3 label-on-right">
                        <code>email="true"</code>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Number</label>
                      <div class="col-sm-7">
                        <div class="form-group bmd-form-group has-danger">
                          <input class="form-control" type="text" name="number" number="true" required="true" aria-required="true">
                        <label id="number-error" class="error" for="number">This field is required.</label></div>
                      </div>
                      <label class="col-sm-3 label-on-right">
                        <code>number="true"</code>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Url</label>
                      <div class="col-sm-7">
                        <div class="form-group bmd-form-group has-danger">
                          <input class="form-control" type="text" name="url" url="true" required="true" aria-required="true">
                        <label id="url-error" class="error" for="url">This field is required.</label></div>
                      </div>
                      <label class="col-sm-3 label-on-right">
                        <code>url="true"</code>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Equal to</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group has-danger">
                          <input class="form-control" id="idSource" type="text" placeholder="#idSource" required="true" aria-required="true">
                        <label id="idSource-error" class="error" for="idSource">This field is required.</label></div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input class="form-control" id="idDestination" type="text" placeholder="#idDestination" equalto="#idSource" required="true" aria-required="true">
                        </div>
                      </div>
                      <label class="col-sm-4 label-on-right">
                        <code>equalTo="#idSource"</code>
                      </label>
                    </div>
                  </div>
                  <div class="card-footer ml-auto mr-auto">
                    <button type="submit" class="btn btn-rose">Validate Inputs<div class="ripple-container"></div></button>
                  </div>
                </div>
              </form>
            </div>
           
          </div>
        </div>
      </div>
      <footer class="footer">
        
      </footer>
    </div>
  </div>
  
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
 <script src="assets/js/core/popper.min.js"></script> 
  <script src="assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Forms Validations Plugin -->
  <script src="assets/js/plugins/jquery.validate.min.js"></script>
  
  
 
  <script>
    function setFormValidation(id) {
      $(id).validate({
        highlight: function(element) {
          $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
          $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
        },
        success: function(element) {
          $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
          $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
        },
        errorPlacement: function(error, element) {
          $(element).closest('.form-group').append(error);
        },
      });
    }

    $(document).ready(function() {
      setFormValidation('#TypeValidation');
      
    });
  </script>





</body></html>