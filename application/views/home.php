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
                    <h1 id="homeHeading">FACTORY EMISSION MONITORING SYSTEM</h1>
                    <hr>
                    <p>Managing and monitoring system for environment managers and enterprises </p>
                    <a href="#about" class="btn btn-primary btn-xl page-scroll">Get started</a>
                </div>
                
                

            </div>
        </div>
    </header>
    