[![Coverage Status](https://coveralls.io/repos/acacha/ebre-escool/badge.svg)](https://coveralls.io/r/acacha/ebre-escool)

Ebre-escool
==

Ebre-escool és una aplicació web per gestió de centres d'ensenyament. En ús a [l'Institut de l'Ebre](https://www.iesebre.com). Més informació a http://acacha.org/mediawiki/index.php/Ebre-escool

Funcionalitats
==

+ __Gestió de dades personals alumnes, professorats, personal laboral...__: La gestió dels alumnes es realitza principalment mitjançant la matrícula però es poden fer modificacions de les dades personals de qualsevol persona associada al centre mitjançant una manteniment web fàcils d'utilitzar
+ __Manteniment de dades de centre__: mitjançant una interficie web àgil i intuitiva es poden gestionar les següents dades del centre:
  +__Currículum__: permet definir el currículum del centre d'una forma flexible que suporta tots els tipus d'estudis reglats actuals (ESO, Batxillerat, Formació Professional LOGSE, LOE). Es poden gestionar per exemple:
    + __Períodes acadèmics__: l'aplicació suporta dades històriques ja que totes les dades estan associades.
    + __Estudis__: manteniment dels estudis que imparteix el centre
    + __Unitats organitzatives estudis__: ESO, Batxillerat, Formació professional o altres
    + __Cicles__: suport per a estudis amb múltiples cicles
    + __Cursos i grups de classe__: assignació d'alumnes a grups de classe durant la matrícula i a posteriori, gestió d'aules...
    + __Assignatures/crèdits/mòduls professionals i subdivisions com Unitats Formatives, Unitats didàctiques, etc__.
    + __Lliçons__: una llicó és una unitat de classe (1 hora de classe normalment). Permet gestionar amb el màxim nivell de detall per exemple els horaris.
    + __Dades matrícula__: es poden modificar mitjançant un assistent o wizard o per manteniment de taules
    + __Horaris__: hores no lectives, torns
    + __Departaments, families professionals i altres unitats organitzatives de centre__: assignació de professors i estudis a departaments o families professionals.
    + __Espais/Aules__: gestió dels espais de centre. Es poden associar a grups de classe i horaris.
+ __Gestió de faltes d'assistència__: suport per passar falta a nivell d'unitat didàctica o unitat formativa, sistema àgil per passar faltes, llistes de classe a mida, etc
+ __Horaris__: El professorat i els alumnes (opcional) poden consultar els horaris en format web. Es poden veure tant els horaris per a cada professor com els horaris de grups de classe.
+ __Inventari de centre__
+ __Panell de control__: permet veure un resum de dades resum del centre com número d'alumnes, alumnes per cicles, estudis, grups de classe, etc
+ Integració amb xarxes socials com Facebook, Twitter o Google+


Qui utilitza ebre-escool?
==

Actualment ebre-escool s'està utilitzant a [l'Institut de l'Ebre](https://www.iesebre.com) per tal de gestionar:

+ __Matrícula d'alumnes__. La matrícula es realitza mitjançant un wizard molt simple. Un cop matriculat l'alumne ja té accés a tots els sistemes TIC del centre de forma immediata assignant-li un usuari i paraula de pas.
+ __Gestió de dades de centre__: Currículum del centre, professorat, alumnat, personal laboral, horaris
+ __Gestió de l'assistència__
+ __Informes__: faltes d'assistència de l'alumnat, llistes de professorat, llistes de classe. Els informes es poden trobar tant en format web com PDF i són exportables a aplicacions externes com Microsoft Office o OpenOffice
+ __Horaris__: consulta dels horaris
+ __Tutoria__: els tutors tenen funcionalitats extres com gestionar les faltes de tot el grup, informes mensuals de faltes, etc. per tal de facilitar la tasca docent.

Requeriments
==

Ebre-escool és una aplicació web que es pot instal·lar en qualsevol servidor web, ja sigui un servidor propi del centre o en servidors externs contractats. Ebre-escool és una aplicació __[LAMP](http://acacha.org/mediawiki/index.php/LAMP)__, és a dir que està dissenyada per executar-se a un servidor __[Linux](http://acacha.org/mediawiki/index.php/Linux)__ (L), amb el servidor d'aplicacions web __[Apache](http://acacha.org/mediawiki/index.php/Apache)__ (A), que està programada en __[PHP](http://acacha.org/mediawiki/index.php/PHP)__ (i altres llenguatges de suport com __[Javascript](http://acacha.org/mediawiki/index.php/Javascript)__) i que guarda les dades a un servidor __[MySQL](http://acacha.org/mediawiki/index.php/MySQL)__. Tot  i que no s'ha provat podria ser possible instal·lar ebre-escool en altres entorns com Windows, altres gestors de bases de dades, etc.

A més Ebre-escool utilitza les següents llibreries o tecnologies:

+ __[CodeIgniter](http://acacha.org/mediawiki/index.php/CodeIgniter)__: Ebre-escool està desenvolupat seguint el [MVC](http://acacha.org/mediawiki/index.php/CodeIgniter) mitjançant el framework de desenvolupament CodeIgniter.
+ __[Ldap](http://acacha.org/mediawiki/index.php/Ldap)__: és opcional. a més de guardar les dades dels usuaris a la base de dades SQL, també es creen i actualitzen els comptes d'usuari en un servidor Ldap. Això és especialment útil per integrar els usuaris en sistemes experts com per exemple servidors de fitxers Windows/Samba, Moodle, Google Apps For Education o qualsevol versió de Google Apps. Ldap és el sistema estàndard que utilitzen les aplicacions per a centralitzar els comptes d'usuari. Multitud d'aplicacions web com Wordpress, PrestaShop, GLPI per indicar algunes tenen suport o es pot afegir el suport mitjançant plugins per a Ldap
+__Suport [Google Apps](http://acacha.org/mediawiki/index.php/)__: s'automatitza la creació de comptes d'usuari per a Google Apps for education ja sigui utilitzant GADS i Ldap o la pròpia aplicació
+ __[Datatables](http://acacha.org/mediawiki/index.php/Datatables)__: utilitzem aquesta llibreria per a la creació de informes en format taula web amb una presentació i funcionalitats millorades ( ordenar columnes, ordenar files, guardar en format Excel/OpenOffice/CSV, Imprimir)
+ __[Grocery Crud](http://acacha.org/mediawiki/index.php/Grocery_Crud)__: S'utilitza per a les tasques de manteniment de dades de l'aplicació
+ __[Ajax](http://acacha.org/mediawiki/index.php/Ajax)__: Ebre-escool fa un ús intensiu d'Ajax fet que millora l'usabilitat de l'aplicació i la fa especialment àgil i fàcil d'utilitzar.
+ Altres llibreries menors com __[FPDF](http://acacha.org/mediawiki/index.php/FPDF)__ per a la creació automàtica de PDFs

En el procés d'instal·lació que podeu trobar a la [wiki](http://acacha.org/mediawiki/index.php/Ebre-escool) s'indica com instal·lar aquestes llibreries.

Instal·lació
==

Consulteu http://acacha.org/mediawiki/index.php/Ebre-escool#Instal.C2.B7laci.C3.B3

Ebre-escool a les Xarxes socials
==

+Facebook: https://www.facebook.com/ebreescool
+Twitter: https://twitter.com/ebre_escool
+Google Plus: https://plus.google.com/b/113949469354046983710/

Skeleton
== 

Ebre-escool utilitza com a aplicació "carcassa" [skeleton](https://github.com/acacha/skeleton).

http://acacha.org/mediawiki/index.php/Skeleton

Documentació tècnica
==

Consulteu la wiki d'ebre-escool a acacha.org:

 http://acacha.org/mediawiki/index.php/Ebre-escool

Codi font
==

El codi font està disponible a

 https://github.com/acacha/ebre-escool

Roadmap. Possibles funcionalitats futures
==

+ Wizard instal·lació
+ Consulta d'horaris d'espais/aules
+ Carrega de dades externes
+ Assistent canvi de perìode acadèmic
+ Pagament de matrícula per TPV
+ Mòdul avaluació

Contribuïdors
==

L'aplicació ha estat creada principalment per Sergi Tur Badenas (http://acacha.org | https://github.com/acacha)

Altres contribuidors codi font

+ __Oscar Adan__: https://github.com/oadan79

També agrair la contribució en la detecció d'errors i en manteniment de dades a les persones encarregades del manteniment informàtic del Institut de l'Ebre:

+ __Paolo Dàvila__: https://github.com/pdavila13
+ __Roger Melich__: https://github.com/ebrematic


I agraïr especialment la col·laboració de l'Institut de l'Ebre com a centre pilot ebre-escool!
