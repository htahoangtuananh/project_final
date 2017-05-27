<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Project Final</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                    <?php if($this->session->logged_in==TRUE):?>
                        <a class="page-scroll" href="<?php echo base_url()."index.php/Admin"?>">Admin</a>
                    <?php else: ?>
                        <a id="admin-link" class="page-scroll" href="#">Admin</a>
                    <?php endif;?>
                    </li>
                    <span class="page-scroll"> | </span>
                    <li>
                        <a id="enterprise-link" class="page-scroll" href="#">Enterprise</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header sytle="background-image: url(<?php echo base_url().'assets/img/header.jpg'?>);">
        <div class="header-content">
            <div class="header-content-inner">
                <div class="intro">
                    <h1 id="homeHeading">Lorem ipsum Ut tempor incididunt eu exercitation est.</h1>
                    <hr>
                    <p>Lorem ipsum Ut laboris in reprehenderit consequat enim ut velit dolore ea ad.</p>
                    <a href="#about" class="btn btn-primary btn-xl page-scroll">Get started</a>
                </div>
                <div class="col-md-offset-4 col-md-4 admin">
                    <div class="panel panel-default">
                        <div class="panel-heading left-text">
                            <h4><strong>Admin login</strong></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo validation_errors(); ?>
                            <?php echo form_open('Home/login_admin'); ?>
                                <div class="form-group form-label">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Enter username">
                                </div>
                                <div class="form-group form-label">
                                    <label for="exampleInputPassword1">Password <a href="#">(forgot password)</a></label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                                </div>
                            <button type="submit" class="btn btn-primary btn-default">Login</button>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-4 col-md-4 enterprise">
                    <div class="panel panel-default">
                        <div class="panel-heading left-text">
                            <h4><strong>Enterprise login</strong></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo validation_errors(); ?>
                            <?php echo form_open('Home/login_enterprise'); ?>
                                <div class="form-group form-label">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Enter username">
                                </div>
                                <div class="form-group form-label">
                                    <label for="exampleInputPassword1">Password <a href="#">(forgot password)</a></label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                                </div>
                            <button type="submit" class="btn btn-primary btn-default">Login</button>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script>
    $(document).ready(function () {
        $("#enterprise-link").click(function () {
            $(".enterprise").css("display","block");
            $(".admin").css("display","none");
            $(".intro").css("display","none");
        });
    });
    </script>
    <script>
    $(document).ready(function () {
        $("#admin-link").click(function () {
            $(".admin").css("display","block");
            $(".enterprise").css("display","none");
            $(".intro").css("display","none");
        });
    });
    </script>