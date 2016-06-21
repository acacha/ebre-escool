<div class="main-content" >

<style>

.profile-info-name {
  position: absolute;
  width: 240px;
  text-align: right;
  padding: 6px 10px 6px 0;
  left: 0;
  top: 0;
  bottom: 0;
  font-weight: normal;
  color: #667E99;
  background-color: transparent;
  border-top: 1px dotted #D5E4F1;
}

.profile-info-value {
  padding: 6px 4px 6px 6px;
  margin-left: 250px;
  border-top: 1px dotted #D5E4F1;
}

</style>

<div id="breadcrumbs" class="breadcrumbs">
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
  <li class="active"><?php echo "Perfil d'usuari";?></li>
 </ul>
</div>

        <div class="page-content">


        <div class="page-header position-relative">
                        <h1>
                            <?php echo lang("persons");?>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                <?php echo "Perfil";?>
                            </small>
                        </h1>
        </div><!-- /.page-header -->

        <div class="pull-left alert alert-success no-margin">
                    <button type="button" class="close" data-dismiss="alert">
                      <i class="icon-remove"></i>
                    </button>

                    <i class="icon-umbrella bigger-120 blue"></i>
                    Si us plau, comproveu si les vostres dades són correctes! Si trobeu algun error feu arribar les correccions al secretari/a del centre
        </div>


        <div class="row-fluid">
            <div class="span12">
              <!-- PAGE CONTENT BEGINS -->

              <div class="hr dotted"></div>

              <div>
                <div id="user-profile-1" class="user-profile row-fluid">
                  <div class="span3 center">
                    <div>
                      <span class="profile-picture">
                        <img id="avatar" class="editable" alt="<?php echo $this->session->userdata('username'); ?> Avatar" src="<?php echo base_url('uploads/person_photos/' . $this->session->userdata('photo'));?>" />
                      </span>

                      <div class="space-4"></div>

                      <div class="width-80 label label-info label-large arrowed-in arrowed-in-right">
                        <div class="inline position-relative">
                          <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-circle light-green middle"></i>
                            &nbsp;
                            <span class="white middle bigger-120"><?php echo $this->session->userdata('fullname'); ?></span>
                          </a>

                          <ul class="align-left dropdown-menu dropdown-caret dropdown-lighter">
                            <li class="nav-header"> Canviar l'estatus </li>

                            <li>
                              <a href="#">
                                <i class="icon-circle green"></i>
                                &nbsp;
                                <span class="green">Disponible</span>
                              </a>
                            </li>

                            <li>
                              <a href="#">
                                <i class="icon-circle red"></i>
                                &nbsp;
                                <span class="red">Ocupat</span>
                              </a>
                            </li>

                            <li>
                              <a href="#">
                                <i class="icon-circle grey"></i>
                                &nbsp;
                                <span class="grey">Invisible</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <div class="space-6"></div>

                    <div class="profile-contact-info">
                      <div class="profile-contact-links align-left">
                        <a class="btn btn-link" href="#">
                          <i class="icon-plus-sign bigger-120 green"></i>
                          Afegir com amic
                        </a>

                        <a class="btn btn-link" href="#">
                          <i class="icon-envelope bigger-120 pink"></i>
                          Enviar un missatge
                        </a>

                        <a class="btn btn-link" href="#">
                          <i class="icon-globe bigger-125 blue"></i>
                          www.elmeudomini.com
                        </a>
                      </div>

                      <div class="space-6"></div>

                      <div class="profile-social-links center">
                        <a href="#" class="tooltip-info" title="" data-original-title="Visit my Facebook">
                          <i class="middle icon-facebook-sign icon-2x blue"></i>
                        </a>

                        <a href="#" class="tooltip-info" title="" data-original-title="Visit my Twitter">
                          <i class="middle icon-twitter-sign icon-2x light-blue"></i>
                        </a>

                        <a href="#" class="tooltip-error" title="" data-original-title="Visit my Pinterest">
                          <i class="middle icon-pinterest-sign icon-2x red"></i>
                        </a>
                      </div>
                    </div>

                    <div class="hr hr12 dotted"></div>

                    <div class="clearfix">
                      <div class="grid2">
                        <span class="bigger-175 blue">25</span>

                        <br />
                        Followers
                      </div>

                      <div class="grid2">
                        <span class="bigger-175 blue">12</span>

                        <br />
                        Following
                      </div>
                    </div>

                    <div class="hr hr16 dotted"></div>
                  </div>

                  <div class="span9">
                    <div class="center">
                      <span class="btn btn-app btn-small btn-light no-hover">
                        <span class="bigger-150 blue"> 1,411 </span>

                        <br />
                        <span class="smaller-90"> Estudis </span>
                      </span>

                      <span class="btn btn-app btn-small btn-yellow no-hover">
                        <span class="bigger-175"> 32 </span>

                        <br />
                        <span class="smaller-90"> Cursos </span>
                      </span>

                      <span class="btn btn-app btn-small btn-pink no-hover">
                        <span class="bigger-175"> 4 </span>

                        <br />
                        <span class="smaller-90"> Grups </span>
                      </span>

                      <span class="btn btn-app btn-small btn-grey no-hover">
                        <span class="bigger-175"> 23 </span>

                        <br />
                        <span class="smaller-90"> Mòduls </span>
                      </span>

                      <span class="btn btn-app btn-small btn-success no-hover">
                        <span class="bigger-175"> 7 </span>

                        <br />
                        <span class="smaller-90"> UFs </span>
                      </span>

                      <span class="btn btn-app btn-small btn-primary no-hover">
                        <span class="bigger-175"> 55 </span>

                        <br />
                        <span class="smaller-90"> Alumnes </span>
                      </span>
                    </div>

                    <div class="space-12"></div>

                    <?php //print_r($this->session->userdata);?>

                    <div class="profile-user-info profile-user-info-striped">
                      <div class="profile-info-row">
                        <div class="profile-info-name"> Id usuari </div>

                        <div class="profile-info-value">
                          <span class="editable" id="id">
                            <?php $is_admin = $this->session->userdata('is_admin');
                                  $userid = trim($this->session->userdata('id'));             ?>
                            <?php if ( $is_admin ) : ?>
                              <a href="<?php echo base_url('/index.php/skeleton/users/read/') . '/' . $userid;?>"><?php echo $userid ; ?></a> ( <a href="<?php echo base_url('/index.php/skeleton/users/edit/') . '/' . $userid;?>">edit</a> ) (Número identificador intern de l'aplicació. NOTA: Només útil per administradors)
                            <?php else: ?>
                              <?php echo $userid ; ?> (Número identificador intern de l'aplicació. NOTA: Només útil per administradors)
                            <?php endif; ?>  
                          </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Id persona </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_id">
                            <?php $person_id =$this->session->userdata('person_id');             ?>
                            <?php if ( $is_admin ) : ?>
                              <a href="<?php echo base_url('/index.php/skeleton/users/read/') . '/' . $person_id;?>"><?php echo $person_id ; ?></a> ( <a href="<?php echo base_url('/index.php/skeleton/users/edit/') . '/' . $person_id;?>">edit</a> ) (Número identificador intern de l'aplicació. NOTA: Només útil per administradors)
                            <?php else: ?>
                              <?php echo $person_id ; ?> (Número identificador intern de l'aplicació. NOTA: Només útil per administradors)
                            <?php endif; ?>  
                          </span>
                        </div>


                      </div>



                      <?php $is_teacher = $this->session->userdata('is_teacher') ;?>
                      <?php if ( isset( $is_teacher ) ): ?>
                        <?php if ( $is_teacher ) : ?>
                      
                          <div class="profile-info-row">
                            <div class="profile-info-name"> Id professor </div>

                            <div class="profile-info-value">
                              <span class="editable" id="teacher_id">
                                <?php $teacher_id =$this->session->userdata('teacher_id');             ?>
                                <?php if ( $is_admin ) : ?>
                                  <a href="<?php echo base_url('/index.php/teachers/index/read') . '/' . $teacher_id;?>"><?php echo $teacher_id ; ?></a> ( <a href="<?php echo base_url('/index.php/teachers/index/edit') . '/' . $teacher_id;?>">edit</a> ) (Número identificador intern de l'aplicació. NOTA: Només útil per administradors)
                                <?php else: ?>
                                  <?php echo $teacher_id ; ?> (Número identificador intern de l'aplicació. NOTA: Només útil per administradors)
                                <?php endif; ?>  
                              </span>
                            </div>

                          </div>

                      
                          <div class="profile-info-row">
                            <div class="profile-info-name"> Codi professor </div>

                            <div class="profile-info-value">
                              <span class="editable" id="teacher_code"><?php $teacher_code = trim($this->session->userdata('teacher_code')); echo $teacher_code != '' ? $teacher_code : "No disponible"; ?></span>
                            </div>
                          </div>

                          <div class="profile-info-row">
                            <div class="profile-info-name"> Departament </div>

                            <div class="profile-info-value">
                              <span class="editable" id="department"><?php $department_shortname = trim($this->session->userdata('department_shortname')); echo $department_shortname != '' ? $department_shortname : "No disponible"; ?> (Id: <?php $teacher_department_id = trim($this->session->userdata('teacher_department_id')); echo $teacher_department_id != '' ? $teacher_department_id : "No disponible"; ?>)</span>
                            </div>
                          </div>

                        <?php endif; ?>
                      <?php endif; ?> 
                      

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Nom d'usuari</div>

                        <div class="profile-info-value">
                          <span class="editable" id="username"><?php $username = trim($this->session->userdata('username')); echo $username != '' ? $username : "No disponible"; ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Paraula de pas </div>

                        <div class="profile-info-value">
                          <span class="editable" id="username">La paraula de pas <strong>és privada</strong>. 
                            Si heu perdut la paraula de pas no hi ha cap forma de recuperar-la i només és possible 
                            <a href="<?php echo base_url('/index.php/skeleton_auth/ebre_escool_auth/forgot_password');?>">tornar a generar una paraula de pas nova</a></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Nom complet</div>

                        <div class="profile-info-value">
                          <span class="editable" id="fullname"><?php $fullname = trim($this->session->userdata('fullname')); echo $fullname != "" ? $fullname : "No disponible"; ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Nom</div>

                        <div class="profile-info-value">
                          <span class="editable" id="givenName"><?php $givenName = $this->session->userdata('givenName'); echo $givenName != '' ? $givenName : "No disponible"; ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> 1r Cognom </div>

                        <div class="profile-info-value">
                          <span class="editable" id="sn1"><?php $sn1 = $this->session->userdata('sn1'); echo $sn1 != '' ? $sn1 : "No disponible"; ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> 2n Cognom </div>

                        <div class="profile-info-value">
                          <span class="editable" id="sn2"><?php $sn2 = $this->session->userdata('sn2'); echo $sn2 != '' ? $sn2 : "No disponible"; ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Unitat Organitzativa </div>

                        <div class="profile-info-value">
                          <span class="editable" id="mainOrganizationaUnitId"><?php $mainOrganizationaUnitId = $this->session->userdata('mainOrganizationaUnitId'); echo $mainOrganizationaUnitId != 0 ? $mainOrganizationaUnitId . " " . $organizational_unit_name : "No disponible";?></span>
                        </div>
                      </div>


                        
                      <div class="profile-info-row">
                        <div class="profile-info-name"> Email corporatiu </div>

                        <div class="profile-info-value">
                          <span class="editable" id="email"><?php $email = $this->session->userdata('email'); echo $email != '' ? $email : "No disponible"; ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Email personal 1 </div>

                        <div class="profile-info-value">
                          <span class="editable" id="secondary_email"> <?php $secondary_email = $this->session->userdata('secondary_email'); echo $secondary_email != '' ? $secondary_email : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Email personal 2 </div>

                        <div class="profile-info-value">
                          <span class="editable" id="terciary_email"> <?php $terciary_email = $this->session->userdata('terciary_email'); echo $terciary_email != '' ? $terciary_email : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> DNI/NIF/Passaport </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_official_id"> <?php $person_official_id = $this->session->userdata('person_official_id'); echo $person_official_id != '' ? $person_official_id : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Tipus identificador personal </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_official_id_type"> <?php $person_official_id_type = $this->session->userdata('person_official_id_type'); echo $person_official_id_type != '' ? $person_official_id_type : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Identificador personal 2 (p. ex. TSI) </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_secondary_official_id"> <?php $person_secondary_official_id = $this->session->userdata('person_secondary_official_id'); echo $person_secondary_official_id != '' ? $person_secondary_official_id : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Tipus identificador personal </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_secondary_official_id_type"> <?php $person_secondary_official_id_type = $this->session->userdata('person_secondary_official_id_type'); echo $person_secondary_official_id_type != '' ? $person_secondary_official_id_type : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Adreça </div>

                        <div class="profile-info-value">
                          <i class="icon-map-marker light-orange bigger-110"></i>
                          <span class="editable" id="person_homePostalAddress"><?php $person_homePostalAddress = $this->session->userdata('person_homePostalAddress'); echo $person_homePostalAddress != '' ? $person_homePostalAddress : "No disponible"; ?></span>

                          <!--<span class="editable" id="country">Netherlands</span>
                          <span class="editable" id="city">Amsterdam</span>-->
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Població </div>

                        <div class="profile-info-value">
                          <span class="editable" id="locality"><?php $locality_name = $this->session->userdata('locality_name'); echo $locality_name != '' ? $locality_name : "No disponible"; ?> ( codi intern: <?php $person_locality_id = $this->session->userdata('person_locality_id'); echo $person_locality_id != '' ? $person_locality_id : "No disponible"; ?>)</span>

                          <!--<span class="editable" id="country">Netherlands</span>
                          <span class="editable" id="city">Amsterdam</span>-->
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Data de naixement </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_date_of_birth"> <?php $person_date_of_birth = $this->session->userdata('person_date_of_birth'); echo $person_date_of_birth != '' ? $person_date_of_birth : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Sexe </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_gender"> <?php $person_gender = $this->session->userdata('person_gender'); echo $person_gender != '' ? $person_gender : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Telèfon </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_telephoneNumber"> <?php $person_telephoneNumber = $this->session->userdata('person_telephoneNumber'); echo $person_telephoneNumber != '' ? $person_telephoneNumber : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Mòbil </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_mobile"> <?php $person_mobile = $this->session->userdata('person_mobile'); echo $person_mobile != '' ? $person_mobile : "No disponible"; ?> </span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Data Alta </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_entryDate"><?php $person_entryDate = $this->session->userdata('person_entryDate'); echo $person_entryDate != '' ? $person_entryDate : "No disponible"; ?></span>
                          <!--<span class="editable" id="signup">20/06/2010</span>-->
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Últim cop online </div>

                        <div class="profile-info-value">
                          <span class="editable" id="lastlogin"><?php $old_last_login = $this->session->userdata('old_last_login'); echo $old_last_login != '' ? $old_last_login : "No disponible"; ?></span>
                        </div>
                      </div>


                      <div class="profile-info-row">
                        <div class="profile-info-name"> Ldap info DN </div>

                        <div class="profile-info-value">
                          <span class="editable" id="dn"><?php $dn = $this->session->userdata('dn'); echo $dn != '' ? $dn : "No disponible"; ?> (NOTA: informació útil només per als administradors)</span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Ldap info CN </div>

                        <div class="profile-info-value">
                          <span class="editable" id="cn"><?php $cn = $this->session->userdata('cn'); echo $cn != '' ? $cn : "No disponible"; ?> (NOTA: informació útil només per als administradors)</span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Professor? </div>

                        <div class="profile-info-value">
                          <span class="editable" id="is_teacher"><?php echo $is_teacher == 1 ? "Sí" : "No"; ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Administrador? </div>

                        <div class="profile-info-value">
                          <span class="editable" id="is_admin"><?php echo $is_admin == 1 ? "Sí" : "No"; ?></span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Roles </div>

                        <div class="profile-info-value">
                          <span class="editable" id="roles"><?php $roles = $this->session->userdata('roles'); echo is_array($roles) ? var_export($roles) : "No disponible"; ?> (NOTA: informació útil només per als administradors)</span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Roles DNs </div>

                        <div class="profile-info-value">
                          <span class="editable" id="rolesdn"><?php $rolesdn = $this->session->userdata('rolesdn'); echo is_array($rolesdn) ? var_export($rolesdn) : "No disponible"; ?> (NOTA: informació útil només per als administradors)</span>
                        </div>
                      </div>

                      <div class="profile-info-row">
                        <div class="profile-info-name"> Descripció </div>

                        <div class="profile-info-value">
                          <span class="editable" id="person_notes"><?php $person_notes = $this->session->userdata('person_notes'); echo $person_notes != '' ? $person_notes : "No disponible"; ?></span>
                        </div>
                      </div>

                    </div>

                    <div class="space-20"></div>

                    <div class="widget-box transparent">
                      <div class="widget-header widget-header-small">
                        <h4 class="blue smaller">
                          <i class="icon-rss orange"></i>
                          Activitat recent (pendent implementar)
                        </h4>

                        <div class="widget-toolbar action-buttons">
                          <a href="#" data-action="reload">
                            <i class="icon-refresh blue"></i>
                          </a>

                          &nbsp;
                          <a href="#" class="pink">
                            <i class="icon-trash"></i>
                          </a>
                        </div>
                      </div>

                      <div class="widget-body">
                        <div class="widget-main padding-8">
                          <div id="profile-feed-1" class="profile-feed">
                            <div class="profile-activity clearfix">
                              <div>
                                <img class="pull-left" alt="<?php echo $this->session->userdata('fullname'); ?> avatar" src="<?php echo base_url('assets/avatars/avatar5.png');?>" />
                                <a class="user" href="#"> <?php echo $this->session->userdata('fullname'); ?> </a>
                                ha canviat la seva foto.
                                <a href="#">Take a look</a>

                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  an hour ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <img class="pull-left" alt="Susan Smith's avatar" src="<?php echo base_url('assets/avatars/avatar1.png');?>" />
                                <a class="user" href="#"> Susan Smith </a>

                                és ara amiga de <?php echo $this->session->userdata('fullname'); ?>.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  2 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-ok btn-success no-hover"></i>
                                <a class="user" href="#"> <?php echo $this->session->userdata('fullname'); ?> </a>
                                joined
                                <a href="#">Country Music</a>

                                group.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  5 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-picture btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>
                                uploaded a new photo.
                                <a href="#">Take a look</a>

                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  5 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>



                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-edit btn-pink no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>
                                published a new blog post.
                                <a href="#">Read now</a>

                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  11 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-key btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged in.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  12 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-off btn-inverse no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged out.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  16 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>

                            <div class="profile-activity clearfix">
                              <div>
                                <i class="pull-left thumbicon icon-key btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged in.
                                <div class="time">
                                  <i class="icon-time bigger-110"></i>
                                  16 hours ago
                                </div>
                              </div>

                              <div class="tools action-buttons">
                                <a href="#" class="blue">
                                  <i class="icon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                  <i class="icon-remove bigger-125"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="hr hr2 hr-double"></div>

                    <div class="space-6"></div>

                    <div class="center">
                      <a href="#" class="btn btn-small btn-primary">
                        <i class="icon-rss bigger-150 middle"></i>

                        Veure més activitat
                        <i class="icon-on-right icon-arrow-right"></i>
                      </a>
                    </div>

                    <div class="space-20"></div>

                  </div>
                </div>
              </div>


         </div>
        </div>      




        
	       <!-- PAGE-CONTENT END -->
        </div>
</div>


<script type="text/javascript">

$(function(){

        //////////////////////////////
        $('#profile-feed-1').slimScroll({
        height: '250px',
        alwaysVisible : true
        });

});
</script>

