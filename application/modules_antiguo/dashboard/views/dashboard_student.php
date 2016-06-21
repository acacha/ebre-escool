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
								. Durant aquest any acadèmic anirem incorporant noves funcionalitats per els alumnes. Estigueu atents i aneu entrant a l'aplicació per consultar les novetats. De moment a l'apartat perfil consulteu que les vostres dades siguin correctes i consulteu també que la matrícula sigui correcte. De la correció de les dades depén en gran part el correcte funcionament de l'aplicació. Per a qualsevol canvi consulteu el vostre tutor
							</div>

							<div class="space-6"></div>

							<ul>
							 <li>
							   Canvi de la paraula de pas: <a href="<?php echo base_url('/index.php/managment/change_password');?>">Canviar paraula de pas</a>
							 </li>
							 <li>Consulta de dades personals: <a href="<?php echo base_url('/index.php/persons/persons/profile');?>" >Perfil</a></li>
							 <li>Matrícula: <a href="<?php echo base_url('/index.php/enrollment/enrollment_query_by_person');?>" >Consulta de la matrícula</a></li>

							</ul>

							<div class="hr hr32 hr-dotted"></div>
				</div>
</div>