<div class="main-content">

		<div class="breadcrumbs" id="breadcrumbs">
			<script type="text/javascript">
				try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
			</script>

			<ul class="breadcrumb">
				<li>
					<i class="icon-home home-icon"></i>
					<a href="#">Home</a>

					<span class="divider">
						<i class="icon-angle-right arrow-icon"></i>
					</span>
				</li>
				<li class="active">Panell de control</li>
			</ul><!-- .breadcrumb -->

			<div class="nav-search" id="nav-search">
				<form class="form-search">
					<span class="input-icon">
						<input type="text" placeholder="Buscar..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />
						<i class="icon-search nav-search-icon"></i>
					</span>
				</form>
			</div><!-- #nav-search -->

		</div>

	<div class="page-content">
		<div class="page-header position-relative">
			<h1>
				Panell de control
				<small>
					<i class="icon-double-angle-right"></i>
					Visió general i estadístiques
				</small>
			</h1>
		</div><!-- /.page-header -->
				

		<div class="row-fluid">
			<div class="span12">
			<!-- PAGE CONTENT BEGINS -->

				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="icon-remove"></i>
					</button>

					<i class="icon-ok green"></i>

					Benvinguts a la
					<strong class="green">
						Intranet de l'Institut de l'Ebre
					</strong>
					. En aquest apartat podeu consultar dades generals i estadístiques del centre. Utilitzeu el menú de l'esquerre per tal de navegar per l'aplicació. 
					Tingueu en compte que es tracta d'una versió beta i algunes dades no són correctes o no està encara implementada la funcionalitat corresponent.
				</div>

				<div class="space-6"></div>

					<div class="row-fluid">
						<div class="span7 infobox-container">
							<div class="infobox infobox-green  ">
								<div class="infobox-icon">
									<i class="icon-user"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?php echo $person_statistics['total_number_of_persons'];?></span>
									<div class="infobox-content"><a href="<?php echo base_url('/index.php/persons')?>">persones</a></div>
								</div>
								<div class="stat stat-success">8%</div>
							</div>

							<div class="infobox infobox-blue  ">
								<div class="infobox-icon">
									<i class="icon-male"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?php echo $teachers_statistics['total_teachers'];?></span>
									<div class="infobox-content">Profesors</div>
								</div>
							</div>

							<div class="infobox infobox-pink  ">
								<div class="infobox-icon">
									<i class="icon-user"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?php echo $students_statistics['total_students'];?></span>
									<div class="infobox-content">Alumnes</div>
								</div>
								<div class="stat stat-important">4%</div>
							</div>

							<div class="infobox infobox-red  ">
								<div class="infobox-icon">
									<i class="icon-male"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?php echo $employers_statistics['total_employers'];?></span>
									<div class="infobox-content">Empleats</div>
								</div>
							</div>

							<div class="infobox infobox-orange2  ">
								<div class="infobox-chart">
									<span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number">6,251</span>
									<div class="infobox-content">pageviews</div>
								</div>

								<div class="badge badge-success">
									7.2%
									<i class="icon-arrow-up"></i>
								</div>
							</div>

							<div class="infobox infobox-blue2  ">
								<div class="infobox-progress">
									<div class="easy-pie-chart percentage" data-percent="42" data-size="46">
										<span class="percent">42</span>
										%
									</div>
								</div>

								<div class="infobox-data">
									<span class="infobox-text">traffic used</span>

									<div class="infobox-content">
										<span class="bigger-110">~</span>
										58GB remaining
									</div>
								</div>
							</div>

							<div class="space-6"></div>

							<div class="infobox infobox-green infobox-small infobox-dark">
								<div class="infobox-progress">
									<div class="easy-pie-chart percentage" data-percent="61" data-size="39">
										<span class="percent">61</span>
										%
									</div>
								</div>

								<div class="infobox-data">
									<div class="infobox-content">Task</div>
									<div class="infobox-content">Completion</div>
								</div>
							</div>

							<div class="infobox infobox-blue infobox-small infobox-dark">
								<div class="infobox-chart">
									<span class="sparkline" data-values="3,4,2,3,4,4,2,2"></span>
								</div>

								<div class="infobox-data">
									<div class="infobox-content">Earnings</div>
									<div class="infobox-content">$32,000</div>
								</div>
							</div>

							<div class="infobox infobox-grey infobox-small infobox-dark">
								<div class="infobox-icon">
									<i class="icon-download-alt"></i>
								</div>

								<div class="infobox-data">
									<div class="infobox-content">Downloads</div>
									<div class="infobox-content">1,205</div>
								</div>
							</div>
						</div>

						<div class="vspace"></div>

						<div class="span5">
							<div class="widget-box">
								<div class="widget-header widget-header-flat widget-header-small">
									<h5>
										<i class="icon-signal"></i>
										Traffic Sources
									</h5>

									<div class="widget-toolbar no-border">
										<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
											This Week
											<i class="icon-angle-down icon-on-right"></i>
										</button>

										<ul class="dropdown-menu dropdown-info pull-right dropdown-caret">
											<li class="active">
												<a href="#">This Week</a>
											</li>

											<li>
												<a href="#">Last Week</a>
											</li>

											<li>
												<a href="#">This Month</a>
											</li>

											<li>
												<a href="#">Last Month</a>
											</li>
										</ul>
									</div>
								</div>

								<div class="widget-body">
									<div class="widget-main">
										<div id="piechart-placeholder"></div>

										<div class="hr hr8 hr-double"></div>

										<div class="clearfix">
											<div class="grid3">
												<span class="grey">
													<i class="icon-facebook-sign icon-2x blue"></i>
													&nbsp; likes
												</span>
												<h4 class="bigger pull-right">1,255</h4>
											</div>

											<div class="grid3">
												<span class="grey">
													<i class="icon-twitter-sign icon-2x purple"></i>
													&nbsp; tweets
												</span>
												<h4 class="bigger pull-right">941</h4>
											</div>

											<div class="grid3">
												<span class="grey">
													<i class="icon-pinterest-sign icon-2x red"></i>
													&nbsp; pins
												</span>
												<h4 class="bigger pull-right">1,050</h4>
											</div>
										</div>
									</div><!-- /widget-main -->
								</div><!-- /widget-body -->
							</div><!-- /widget-box -->
						</div><!-- /span -->
					</div><!-- /row -->

					<div class="row-fluid">
						 Dades persones:
						<div class="span12">

							<div class="space-6"></div>

						<div class="row-fluid">
							<div class="span7 infobox-container">
								<div class="infobox infobox-green  ">
									<div class="infobox-icon">
										<i class="icon-user"></i>
									</div>

									<div class="infobox-data">
										<span class="infobox-data-number"><?php echo $person_statistics['total_number_of_duplicated_persons'];?></span>
										<div class="infobox-content">
											<?php $this->session->set_flashdata('persons_filter', $person_statistics['duplicated_person_ids']); ;?>
											<?php if (count($person_statistics['duplicated_person_ids']) > 0): ?>
		        								<a href="<?php echo base_url('/index.php/persons/person/persons_filter')?>">
											<?php endif; ?>
												Ids personals duplicats
											<?php if (count($person_statistics['duplicated_person_ids']) > 0): ?>
												</a>
											<?php endif; ?>	
										</div>
									</div>
								</div>

							<div class="infobox infobox-blue  ">
								<div class="infobox-icon">
									<i class="icon-camera"></i>
								</div>

								<div class="infobox-data">
									<?php $this->session->set_flashdata('without_photo_persons_id', $person_statistics['without_photo_persons_id']); ;?>
									<?php //print_r($person_statistics['without_photo_persons']); ;?>
									<?php //print_r($person_statistics['without_photo_persons_id']);?>
									
									<span class="infobox-data-number"><?php echo count($person_statistics['without_photo_persons']);?></span>
									<div class="infobox-content">
										<?php if (count($person_statistics['without_photo_persons']) > 0): ?>
	        								<a href="<?php echo base_url('/index.php/persons/person/without_photo_persons_id')?>">
										<?php endif; ?>
											Sense foto
										<?php if (count($person_statistics['without_photo_persons']) > 0): ?>
											</a>
										<?php endif; ?>	
									</div>
								</div>
							</div>

							<div class="infobox infobox-pink  ">
								<div class="infobox-icon">
									<i class="icon-shopping-cart"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number">0</span>
									<div class="infobox-content">TODO</div>
								</div>
							</div>

							<div class="infobox infobox-red  ">
								<div class="infobox-icon">
									<i class="icon-male"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?php echo $person_statistics['male_persons'];?></span>
									<div class="infobox-content">Homes</div>
								</div>
							</div>

							<div class="infobox infobox-orange2  ">
								<div class="infobox-icon">
									<i class="icon-female"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?php echo $person_statistics['female_persons'];?></span>
									<div class="infobox-content">Dones</div>
								</div>
							</div>

							<div class="infobox infobox-blue2  ">
								<div class="infobox-progress">
									<div class="easy-pie-chart percentage" data-percent="42" data-size="46">
										<span class="percent">0</span>
										%
									</div>
								</div>

								<div class="infobox-data">
									<span class="infobox-text">Gènere no definit</span>

									<div class="infobox-content">
										<?php echo $person_statistics['not_gender_defined_persons'];?>
									</div>
								</div>
							</div>

							<div class="infobox infobox-red  ">
								<div class="infobox-icon">
									<i class="icon-envelope"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?php echo $person_statistics['undefined_emails'];?></span>
									<div class="infobox-content">Emails personals buits</div>
								</div>
							</div>

							<div class="infobox infobox-orange2  ">
								<div class="infobox-icon">
									<i class="icon-envelope"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?php echo $person_statistics['duplicated_emails'];?></span>
									<div class="infobox-content">Emails duplicats</div>
								</div>
							</div>

							<div class="infobox infobox-blue2  ">
								<div class="infobox-progress">
									<div class="easy-pie-chart percentage" data-percent="42" data-size="46">
										<span class="percent">0</span>
										%
									</div>
								</div>

								<div class="infobox-data">
									<span class="infobox-text">TODO</span>

									<div class="infobox-content">
										0
									</div>
								</div>
							</div>

							<div class="space-6"></div>

							
						</div>

						<div class="vspace"></div>

						<div class="span5">
							<div class="widget-box">
								<div class="widget-header widget-header-flat widget-header-small">
									<h5>
										<i class="icon-signal"></i>
										Traffic Sources
									</h5>

									<div class="widget-toolbar no-border">
										<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
											This Week
											<i class="icon-angle-down icon-on-right"></i>
										</button>

										<ul class="dropdown-menu dropdown-info pull-right dropdown-caret">
											<li class="active">
												<a href="#">This Week</a>
											</li>

											<li>
												<a href="#">Last Week</a>
											</li>

											<li>
												<a href="#">This Month</a>
											</li>

											<li>
												<a href="#">Last Month</a>
											</li>
										</ul>
									</div>
								</div>

								<div class="widget-body">
									<div class="widget-main">
										<div id="piechart-placeholder"></div>

										<div class="hr hr8 hr-double"></div>

										<div class="clearfix">
											<div class="grid3">
												<span class="grey">
													<i class="icon-facebook-sign icon-2x blue"></i>
													&nbsp; likes
												</span>
												<h4 class="bigger pull-right">1,255</h4>
											</div>

											<div class="grid3">
												<span class="grey">
													<i class="icon-twitter-sign icon-2x purple"></i>
													&nbsp; tweets
												</span>
												<h4 class="bigger pull-right">941</h4>
											</div>

											<div class="grid3">
												<span class="grey">
													<i class="icon-pinterest-sign icon-2x red"></i>
													&nbsp; pins
												</span>
												<h4 class="bigger pull-right">1,050</h4>
											</div>
										</div>
									</div><!-- /widget-main -->
								</div><!-- /widget-body -->
							</div><!-- /widget-box -->
						</div><!-- /span -->
					</div><!-- /row -->





				<div class="row-fluid">
						 Currículum:
						<div class="span12">

							<div class="space-6"></div>

							<div class="row-fluid">
								<div class="span7 infobox-container">
									<div class="infobox infobox-green  ">
										<div class="infobox-icon">
											<i class="icon-group"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-data-number"><?php echo $curriculum_statistics['total_departments'];?></span>
											<div class="infobox-content">
												<?php if ($curriculum_statistics['total_departments'] > 0): ?>
                    								<a href="<?php echo base_url('/index.php/curriculum/departments')?>">
												<?php endif; ?>
													Departaments 
														<?php if ($curriculum_statistics['total_departments'] > 0): ?>
															<small><i class="icon-file"></i> <a href="<?php echo base_url('index.php/managment/curriculum_reports_departments')?>">
																Informe
															</a></small>
														<?php endif; ?>
												<?php if ($curriculum_statistics['total_departments'] > 0): ?>
													</a>
												<?php endif; ?>	
											</div>
										</div>
									</div>

									<div class="infobox infobox-blue">
										<div class="infobox-icon">
											<i class="icon-book"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-data-number"><?php echo $curriculum_statistics['total_studies'];?></span>
											<div class="infobox-content">
												<?php if ($curriculum_statistics['total_studies'] > 0): ?>
                    								<a href="<?php echo base_url('/index.php/curriculum/studies')?>">
												<?php endif; ?>
													Estudis
														<?php if ($curriculum_statistics['total_studies'] > 0): ?>
															<small><i class="icon-file"></i> <a href="<?php echo base_url('index.php/managment/curriculum_reports_study')?>">
																Informe
															</a></small>
														<?php endif; ?>
												<?php if ($curriculum_statistics['total_studies'] > 0): ?>
													</a>
												<?php endif; ?>	
											</div>
										</div>
									</div>

									<div class="infobox infobox-pink  ">
										<div class="infobox-icon">
											<i class="icon-group"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-data-number"><?php echo $curriculum_statistics['total_courses'];?></span>
											<div class="infobox-content">
												<?php if ($curriculum_statistics['total_courses'] > 0): ?>
                    								<a href="<?php echo base_url('/index.php/curriculum/course')?>">
												<?php endif; ?>
													Cursos
														<?php if ($curriculum_statistics['total_courses'] > 0): ?>
															<small><i class="icon-file"></i> <a href="<?php echo base_url('/index.php/managment/curriculum_reports_course')?>">
																Informe
															</a></small>
														<?php endif; ?>
												<?php if ($curriculum_statistics['total_courses'] > 0): ?>
													</a>
												<?php endif; ?>	
											</div>
										</div>
									</div>

									<div class="infobox infobox-red">
										<div class="infobox-icon">
											<i class="icon-group"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-data-number"><?php echo $curriculum_statistics['total_classroom_group'];?></span>
											<div class="infobox-content">
												<?php if ($curriculum_statistics['total_classroom_group'] > 0): ?>
                    								<a href="<?php echo base_url('/index.php/curriculum/classroom_group')?>">
												<?php endif; ?>
													Grups classe
														<?php if ($curriculum_statistics['total_courses'] > 0): ?>
															<small><i class="icon-file"></i> <a href="<?php echo base_url('/index.php/managment/curriculum_reports_classgroup')?>">
																Informe
															</a></small>
														<?php endif; ?>
												<?php if ($curriculum_statistics['total_classroom_group'] > 0): ?>
													</a>
												<?php endif; ?>	
												</div>
										</div>
									</div>

									<div class="infobox infobox-orange2  ">
										<div class="infobox-icon">
											<i class="icon-calendar"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-data-number"><?php echo $curriculum_statistics['total_study_modules'];?></span>
											<div class="infobox-content">
												<?php if ($curriculum_statistics['total_study_modules'] > 0): ?>
                    								<a href="<?php echo base_url('/index.php/curriculum/study_module')?>">
												<?php endif; ?>
													MPs
														<?php if ($curriculum_statistics['total_courses'] > 0): ?>
															<small><i class="icon-file"></i> <a href="<?php echo base_url('/index.php/managment/curriculum_reports_studymodules')?>">
																Informe
															</a></small>
														<?php endif; ?>
												<?php if ($curriculum_statistics['total_study_modules'] > 0): ?>
													</a>
												<?php endif; ?>	
											</div>
										</div>
									</div>
									
									<div class="infobox infobox-blue2  ">
										<div class="infobox-icon">
											<i class="icon-calendar"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-text"><?php echo $curriculum_statistics['total_study_submodules'];?></span>

											<div class="infobox-content">
												<?php if ($curriculum_statistics['total_study_submodules'] > 0): ?>
                    								<a href="<?php echo base_url('/index.php/curriculum/study_submodules')?>">
												<?php endif; ?>
													UFs
														<?php if ($curriculum_statistics['total_courses'] > 0): ?>
															<small><i class="icon-file"></i> <a href="<?php echo base_url('/index.php/managment/curriculum_reports_studysubmodules')?>">
																Informe
															</a></small>
														<?php endif; ?>
												<?php if ($curriculum_statistics['total_study_submodules'] > 0): ?>
													</a>
												<?php endif; ?>	
												</div>
											</div>
									</div>
									
									<div class="space-6"></div>

									
								</div>

								<div class="vspace"></div>

								<div class="span5">
									<div class="widget-box">
										<div class="widget-header widget-header-flat widget-header-small">
											<h5>
												<i class="icon-signal"></i>
												Traffic Sources
											</h5>

											<div class="widget-toolbar no-border">
												<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
													This Week
													<i class="icon-angle-down icon-on-right"></i>
												</button>

												<ul class="dropdown-menu dropdown-info pull-right dropdown-caret">
													<li class="active">
														<a href="#">This Week</a>
													</li>

													<li>
														<a href="#">Last Week</a>
													</li>

													<li>
														<a href="#">This Month</a>
													</li>

													<li>
														<a href="#">Last Month</a>
													</li>
												</ul>
											</div>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												<div id="piechart-placeholder"></div>

												<div class="hr hr8 hr-double"></div>

												<div class="clearfix">
													<div class="grid3">
														<span class="grey">
															<i class="icon-facebook-sign icon-2x blue"></i>
															&nbsp; likes
														</span>
														<h4 class="bigger pull-right">1,255</h4>
													</div>

													<div class="grid3">
														<span class="grey">
															<i class="icon-twitter-sign icon-2x purple"></i>
															&nbsp; tweets
														</span>
														<h4 class="bigger pull-right">941</h4>
													</div>

													<div class="grid3">
														<span class="grey">
															<i class="icon-pinterest-sign icon-2x red"></i>
															&nbsp; pins
														</span>
														<h4 class="bigger pull-right">1,050</h4>
													</div>
												</div>
											</div><!-- /widget-main -->
										</div><!-- /widget-body -->
									</div><!-- /widget-box -->
								</div><!-- /span -->
							</div><!-- /row -->









					<div class="row-fluid">
						 Matrícula període acadèmic actual (<?php echo $current_academic_period;?>):
						<div class="span12">

							<div class="space-6"></div>

							<div class="row-fluid">
								<div class="span7 infobox-container">
									<div class="infobox infobox-green  ">
										<div class="infobox-icon">
											<i class="icon-group"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-data-number"><?php echo $enrollment_statistics['total_number_of_current_period_enrolled_persons'];?></span>
											<div class="infobox-content">
                   								<a href="<?php echo base_url('/index.php/enrollment/enrollment')?>">Alumnes matrículats</a>
											</div>
										</div>
									</div>

									<div class="infobox infobox-blue  ">
										<div class="infobox-icon">
											<i class="icon-book"></i>
										</div>

										<div class="infobox-data">												
											<span class="infobox-data-number"><?php echo $enrollment_statistics['total_study_submodules'];?></span>
											<div class="infobox-content">
													Total UFs matrículades
											</div>
										</div>
									</div>

									<div class="infobox infobox-pink  ">
										<div class="infobox-icon">
											<i class="icon-group"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-data-number">
												<?php 
													$total_study_submodules = $enrollment_statistics['total_study_submodules'];
													$total_number_of_current_period_enrolled_persons = $enrollment_statistics['total_number_of_current_period_enrolled_persons'];
													$media = $total_study_submodules / $total_number_of_current_period_enrolled_persons;
													echo round($media,2);
												?>
												
											</span>
											<div class="infobox-content">Mitjana</div>
										</div>
									</div>

									<div class="infobox infobox-red  ">
										<div class="infobox-icon">
											<i class="icon-group"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-data-number"><?php echo $person_statistics['male_persons'];?></span>
											<div class="infobox-content">Grups de Classe</div>
										</div>
									</div>

									<div class="infobox infobox-orange2  ">
										<div class="infobox-icon">
											<i class="icon-calendar"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-data-number"><?php echo $person_statistics['female_persons'];?></span>
											<div class="infobox-content">Mòduls professionals</div>
										</div>
									</div>

									<div class="infobox infobox-blue2  ">
										<div class="infobox-icon">
											<i class="icon-calendar"></i>
										</div>

										<div class="infobox-data">
											<span class="infobox-text"><?php echo $person_statistics['not_gender_defined_persons'];?></span>

											<div class="infobox-content">
												Unitats formatives
											</div>
										</div>
									</div>

									<div class="space-6"></div>

									
								</div>

								<div class="vspace"></div>

								<div class="span5">
									<div class="widget-box">
										<div class="widget-header widget-header-flat widget-header-small">
											<h5>
												<i class="icon-signal"></i>
												Traffic Sources
											</h5>

											<div class="widget-toolbar no-border">
												<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
													This Week
													<i class="icon-angle-down icon-on-right"></i>
												</button>

												<ul class="dropdown-menu dropdown-info pull-right dropdown-caret">
													<li class="active">
														<a href="#">This Week</a>
													</li>

													<li>
														<a href="#">Last Week</a>
													</li>

													<li>
														<a href="#">This Month</a>
													</li>

													<li>
														<a href="#">Last Month</a>
													</li>
												</ul>
											</div>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												<div id="piechart-placeholder"></div>

												<div class="hr hr8 hr-double"></div>

												<div class="clearfix">
													<div class="grid3">
														<span class="grey">
															<i class="icon-facebook-sign icon-2x blue"></i>
															&nbsp; likes
														</span>
														<h4 class="bigger pull-right">1,255</h4>
													</div>

													<div class="grid3">
														<span class="grey">
															<i class="icon-twitter-sign icon-2x purple"></i>
															&nbsp; tweets
														</span>
														<h4 class="bigger pull-right">941</h4>
													</div>

													<div class="grid3">
														<span class="grey">
															<i class="icon-pinterest-sign icon-2x red"></i>
															&nbsp; pins
														</span>
														<h4 class="bigger pull-right">1,050</h4>
													</div>
												</div>
											</div><!-- /widget-main -->
										</div><!-- /widget-body -->
									</div><!-- /widget-box -->
								</div><!-- /span -->
							</div><!-- /row -->

























				<div class="hr hr32 hr-dotted"></div>
				
</div>
</div><!-- /#main content -->