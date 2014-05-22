
<body>
  <div class="navbar" id="navbar">
      
      <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
      </script>
      
      <div class="navbar-inner">
        <div class="container-fluid">
          <a href="#" class="brand">
            <small>
              <i class="icon-leaf"></i>
              Ebre-escool
            </small>
          </a><!-- /.brand -->

          <ul class="nav ace-nav pull-right">
            <li class="grey" style="">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-tasks"></i>
                <span class="badge badge-grey">4</span>
              </a>

              <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer">
                <li class="nav-header">
                  <i class="icon-ok"></i>
                  4 Tasks to complete
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">Software Update</span>
                      <span class="pull-right">65%</span>
                    </div>

                    <div class="progress progress-mini ">
                      <div style="width:65%" class="bar"></div>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">Hardware Upgrade</span>
                      <span class="pull-right">35%</span>
                    </div>

                    <div class="progress progress-mini progress-danger">
                      <div style="width:35%" class="bar"></div>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">Unit Testing</span>
                      <span class="pull-right">15%</span>
                    </div>

                    <div class="progress progress-mini progress-warning">
                      <div style="width:15%" class="bar"></div>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">Bug Fixes</span>
                      <span class="pull-right">90%</span>
                    </div>

                    <div class="progress progress-mini progress-success progress-striped active">
                      <div style="width:90%" class="bar"></div>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    See tasks with details
                    <i class="icon-arrow-right"></i>
                  </a>
                </li>
              </ul>
            </li>

            <li class="purple" style="">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-bell-alt icon-animated-bell"></i>
                <span class="badge badge-important">8</span>
              </a>

              <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-closer">
                <li class="nav-header">
                  <i class="icon-warning-sign"></i>
                  8 Notifications
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">
                        <i class="btn btn-mini no-hover btn-pink icon-comment"></i>
                        New Comments
                      </span>
                      <span class="pull-right badge badge-info">+12</span>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <i class="btn btn-mini btn-primary icon-user"></i>
                    Bob just signed up as an editor ...
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">
                        <i class="btn btn-mini no-hover btn-success icon-shopping-cart"></i>
                        New Orders
                      </span>
                      <span class="pull-right badge badge-success">+8</span>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">
                        <i class="btn btn-mini no-hover btn-info icon-twitter"></i>
                        Followers
                      </span>
                      <span class="pull-right badge badge-info">+11</span>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    See all notifications
                    <i class="icon-arrow-right"></i>
                  </a>
                </li>
              </ul>
            </li>

            <li class="green" style="">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-envelope icon-animated-vertical"></i>
                <span class="badge badge-success">5</span>
              </a>

              <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer">
                <li class="nav-header">
                  <i class="icon-envelope-alt"></i>
                  5 Messages
                </li>

                <li>
                  <a href="#">
                    <img src="<?php echo base_url('assets/avatars/avatar.png');?>" class="msg-photo" alt="Alex's Avatar" />
                    <span class="msg-body">
                      <span class="msg-title">
                        <span class="blue">Alex:</span>
                        Ciao sociis natoque penatibus et auctor ...
                      </span>

                      <span class="msg-time">
                        <i class="icon-time"></i>
                        <span>a moment ago</span>
                      </span>
                    </span>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <img src="<?php echo base_url('assets/avatars/avatar3.png');?>" class="msg-photo" alt="Susan's Avatar" />
                    <span class="msg-body">
                      <span class="msg-title">
                        <span class="blue">Susan:</span>
                        Vestibulum id ligula porta felis euismod ...
                      </span>

                      <span class="msg-time">
                        <i class="icon-time"></i>
                        <span>20 minutes ago</span>
                      </span>
                    </span>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <img src="<?php echo base_url('assets/avatars/avatar4.png');?>" class="msg-photo" alt="Bob's Avatar" />
                    <span class="msg-body">
                      <span class="msg-title">
                        <span class="blue">Bob:</span>
                        Nullam quis risus eget urna mollis ornare ...
                      </span>

                      <span class="msg-time">
                        <i class="icon-time"></i>
                        <span>3:15 pm</span>
                      </span>
                    </span>
                  </a>
                </li>

                <li>
                  <a href="#">
                    See all messages
                    <i class="icon-arrow-right"></i>
                  </a>
                </li>
              </ul>
            </li>


            <?php if ($this->session->userdata('is_admin')): ?>

              <li class="dark-blue">
                <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                  Administrador <i class="icon-caret-down"></i>
                </a>

                <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                  <li>
                    <a href="#">
                      <i class="icon-cog"></i>
                      Configuració general (TODO)
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <i class="icon-user"></i>
                      Suplantació d'identitat
                    </a>
                  </li>

                  <li class="divider"></li>

                  <li>
                    <a href="#">
                      Altres
                    </a>
                  </li>
                </ul>
              </li>

            <?php endif; ?>

            <li class="light-blue">
              <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <img class="nav-user-photo" src="<?php echo base_url('uploads/person_photos/' . $this->session->userdata('photo'));?>" 
                  style="max-height: 36px !important;" alt="Foto de <?php echo $this->session->userdata('username');?>" />
                <span class="user-info" style="line-height: 16px;">
                  <small>Benvingut/da,</small>
                  <?php echo $this->session->userdata('username');?>
                </span>

                <i class="icon-caret-down"></i>
              </a>

              <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                <li>
                  <a href="#">
                    <i class="icon-cog"></i>
                    Configuració
                  </a>
                </li>

                <li>
                  <a href="<?php echo base_url('/index.php/persons/persons/profile')?>" alt="Foto de <?php echo $this->session->userdata('username');?>">
                    <i class="icon-user"></i>
                    Perfil
                  </a>
                </li>

                <li class="divider"></li>

                <li>
                  <a href="<?php echo base_url('/index.php/skeleton_auth/ebre_escool_auth/logout'); ?>">
                    <i class="icon-off"></i>
                    Sortir
                  </a>
                </li>
              </ul>
            </li>


          </ul><!-- /.ace-nav -->

        </div><!-- /.container-fluid -->
      </div><!-- /.navbar-inner -->
    </div>



    <div class="main-container container-fluid">
      <a class="menu-toggler" id="menu-toggler" href="#">
        <span class="menu-text"></span>
      </a>

      
			<div class="sidebar menu-min" id="sidebar">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-small btn-success">
							<i class="icon-signal"></i>
						</button>

						<button class="btn btn-small btn-info">
							<i class="icon-pencil"></i>
						</button>

						<button class="btn btn-small btn-warning">
							<i class="icon-group"></i>
						</button>

						<button class="btn btn-small btn-danger">
							<i class="icon-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- #sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li class="active">
						<a href="http://localhost/plantilla/index.html">
							<i class="icon-dashboard"></i>
							<span class="menu-text"> Dashboard </span>
						</a>
					</li>

					<li>
						<a href="http://localhost/plantilla/typography.html">
							<i class="icon-text-width"></i>
							<span class="menu-text"> Typography </span>
						</a>
					</li>

					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-desktop"></i>
							<span class="menu-text"> UI Elements </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<li>
								<a href="http://localhost/plantilla/elements.html">
									<i class="icon-double-angle-right"></i>
									Elements
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/buttons.html">
									<i class="icon-double-angle-right"></i>
									Buttons &amp; Icons
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/treeview.html">
									<i class="icon-double-angle-right"></i>
									Treeview
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/jquery-ui.html">
									<i class="icon-double-angle-right"></i>
									jQuery UI
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/nestable-list.html">
									<i class="icon-double-angle-right"></i>
									Nestable Lists
								</a>
							</li>

							<li>
								<a href="#" class="dropdown-toggle">
									<i class="icon-double-angle-right"></i>

									Three Level Menu
									<b class="arrow icon-angle-down"></b>
								</a>

								<ul class="submenu">
									<li>
										<a href="#">
											<i class="icon-leaf"></i>
											Item #1
										</a>
									</li>

									<li>
										<a href="#" class="dropdown-toggle">
											<i class="icon-pencil"></i>

											4th level
											<b class="arrow icon-angle-down"></b>
										</a>

										<ul class="submenu">
											<li>
												<a href="#">
													<i class="icon-plus"></i>
													Add Product
												</a>
											</li>

											<li>
												<a href="#">
													<i class="icon-eye-open"></i>
													View Products
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</li>

					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-list"></i>
							<span class="menu-text"> Tables </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<li>
								<a href="http://localhost/plantilla/tables.html">
									<i class="icon-double-angle-right"></i>
									Simple &amp; Dynamic
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/jqgrid.html">
									<i class="icon-double-angle-right"></i>
									jqGrid plugin
								</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-edit"></i>
							<span class="menu-text"> Forms </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<li>
								<a href="http://localhost/plantilla/form-elements.html">
									<i class="icon-double-angle-right"></i>
									Form Elements
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/form-wizard.html">
									<i class="icon-double-angle-right"></i>
									Wizard &amp; Validation
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/wysiwyg.html">
									<i class="icon-double-angle-right"></i>
									Wysiwyg &amp; Markdown
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/dropzone.html">
									<i class="icon-double-angle-right"></i>
									Dropzone File Upload
								</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="http://localhost/plantilla/widgets.html">
							<i class="icon-list-alt"></i>
							<span class="menu-text"> Widgets </span>
						</a>
					</li>

					<li>
						<a href="http://localhost/plantilla/calendar.html">
							<i class="icon-calendar"></i>

							<span class="menu-text">
								Calendar
								<span data-original-title="2&nbsp;Important&nbsp;Events" class="badge badge-transparent tooltip-error" title="">
									<i class="icon-warning-sign red bigger-130"></i>
								</span>
							</span>
						</a>
					</li>

					<li>
						<a href="http://localhost/plantilla/gallery.html">
							<i class="icon-picture"></i>
							<span class="menu-text"> Gallery </span>
						</a>
					</li>

					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-tag"></i>
							<span class="menu-text"> More Pages </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<li>
								<a href="http://localhost/plantilla/profile.html">
									<i class="icon-double-angle-right"></i>
									User Profile
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/inbox.html">
									<i class="icon-double-angle-right"></i>
									Inbox
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/pricing.html">
									<i class="icon-double-angle-right"></i>
									Pricing Tables
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/invoice.html">
									<i class="icon-double-angle-right"></i>
									Invoice
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/timeline.html">
									<i class="icon-double-angle-right"></i>
									Timeline
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/login.html">
									<i class="icon-double-angle-right"></i>
									Login &amp; Register
								</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-file-alt"></i>

							<span class="menu-text">
								Other Pages
								<span class="badge badge-primary ">5</span>
							</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<li>
								<a href="http://localhost/plantilla/faq.html">
									<i class="icon-double-angle-right"></i>
									FAQ
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/error-404.html">
									<i class="icon-double-angle-right"></i>
									Error 404
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/error-500.html">
									<i class="icon-double-angle-right"></i>
									Error 500
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/grid.html">
									<i class="icon-double-angle-right"></i>
									Grid
								</a>
							</li>

							<li>
								<a href="http://localhost/plantilla/blank.html">
									<i class="icon-double-angle-right"></i>
									Blank Page
								</a>
							</li>
						</ul>
					</li>
				</ul><!-- /.nav-list -->

				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-right" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

 
<!-- END OF body_header. DO NOT CLOSE Body tag. Closed in body footer--> 
