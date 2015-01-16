Ebre-escool
==

Ebre-escool és una aplicació web per gestió de centres d'ensenyament. En ús a l'Institut de l'Ebre

Funcionalitats
==

* Dades personals alumnes, professorats, personal laboral...: La gestió dels alumnes es realitza principalment mitjançant la matrícula però es poden fer modificacions de les dades personals de qualsevol persona associada al centre mitjançant una manteniment web fàcils d'utilitzar
* Manteniment de dades de centre: mitjançant una interficie web àgil i intuitiva es poden gestionar les següents dades del centre:
**Currículum: permet definir el currículum del centre d'una forma flexible que suporta tots els tipus d'estudis reglats actuals (ESO, Batxillerat, Formació Professional LOGSE, LOE). Es poden gestionar per exemple:
*** Períodes acadèmics: l'aplicació suporta dades històriques ja que totes les dades estan associades.
*** Estudis: manteniment dels estudis que imparteix el centre
*** Unitats organitzatives estudis: ESO, Batxillerat, Formació professional o altres
*** Cicles: suport per a estudis amb múltiples cicles
*** Cursos i grups de classe
*** Assignatures/crèdits/mòduls professionals i subdivisions com Unitats Formatives, Unitats didàctiques, etc.
*** Lliçons: una llicó és una unitat de classe (1 hora de classe normalment). Permet gestionar amb el màxim nivell de detall per exemple els horaris.
*** Dades matrícula: es poden modificar mitjançant un assistent o wizard o per manteniment de taules
*** Horaris: hores no lectives, torns
* Horaris: El professorat i els alumnes (opcional) poden consultar els horaris en format web. Es poden veure tant els horaris per a cada professor com els horaris de grups de classe.
* Departaments, families professionals i altres unitats organitzatives de centre.
*Espais/Aules: gestió dels espais de centre. Es poden associar a grups de classe i horaris.
*Inventari de centre
* Integració amb xarxes socials com Facebook, Twitter o Google+
* Panell de control: permet veure un resum de dades resum del centre com número d'alumnes, alumnes per cicles, estudis, grups de classe, etc

Qui utilitza ebre-escool?
==

Actualment ebre-escool s'està utilitzant a [l'Institut de l'Ebre](https://www.iesebre.com) per tal de gestionar:

* Matrícula d'alumnes. La matrícula es realitza mitjançant un wizard molt simple. Un cop matriculat l'alumne ja té accés a tots els sistemes TIC del centre de forma immediata assignant-li un usuari i paraula de pas.
* Gestió de dades de centre: Currículum del centre, professorat, alumnat, personal laboral, horaris
* Gestió de l'assistència
* Informes: faltes d'assistència de l'alumnat, llistes de professorat, llistes de classe. Els informes es poden trobar tant en format web com PDF i són exportables a aplicacions externes com Microsoft Office o OpenOffice
* Horaris: consulta dels horaris
* Tutoria: els tutors tenen funcionalitats extres com gestionar les faltes de tot el grup, informes mensuals de faltes, etc. per tal de facilitar la tasca docent.

Requeriments
==

Ebre-escool és una aplicació web que es pot instal·lar en qualsevol servidor web, ja sigui un servidor propi del centre o en servidors externs contractats. Ebre-escool és una aplicació LAMP, és a dir que està dissenyada per executar-se a un servidor Linux (L), amb el servidor d'aplicacions web Apache (A), que està programada en PHP (i altres llenguatges de suport com Javascript) i que guarda les dades a un servidor MySQL. Tot  i que no s'ha provat podria ser possible instal·lar ebre-escool en altres entorns com Windows, altres gestors de bases de dades, etc.

A més Ebre-escool utilitza les següents llibreries o tecnologies:

* Ldap(Opcional): a més de guardar les dades dels usuaris a la base de dades SQL, també es creen i actualitzen els comptes d'usuari en un servidor Ldap. Això és especialment útil per integrar els usuaris en sistemes experts com per exemple servidors de fitxers Windows/Samba, Moodle, Google Apps For Education o qualsevol versió de Google Apps. Ldap és el sistema estàndard que utilitzen les aplicacions per a centralitzar els comptes d'usuari. Multitud d'aplicacions web com Wordpress, PrestaShop, GLPI per indicar algunes tenen suport o es pot afegir el suport mitjançant plugins per a Ldap
*Suport Google Apps: s'automatitza la creació de comptes d'usuari per a Google Apps for education ja sigui utilitzant GADS i Ldap o la pròpia aplicació
* Datatables: utilitzem aquesta llibreria per a la creació de informes en format taula web amb una presentació i funcionalitats millorades ( ordenar columnes, ordenar files, guardar en format Excel/OpenOffice/CSV, Imprimir)
* Grocery Crud: S'utilitza per a les tasques de manteniment de dades de l'aplicació
* Ajax: Ebre-escool fa un ús intensiu d'Ajax fet que millora l'usabilitat de l'aplicació i la fa especialment àgil i fàcil d'utilitzar.
* Altres llibreries menors com FPDF per a la creació automàtica de PDFs

En el procés d'instal·lació que podeu trobar a la [wiki](http://acacha.org/mediawiki/index.php/Ebre-escool) s'indica com instal·lar aquestes llibreries

Ebre-escool a les Xarxes socials
==

Facebook: https://www.facebook.com/ebreescool
Twitter: https://twitter.com/ebre_escool
Google Plus: https://plus.google.com/b/113949469354046983710/

Skeleton
== 

Ebre-escool utilitza com a aplicació "carcassa" [skeleton](https://github.com/acacha/skeleton).

http://acacha.org/mediawiki/index.php/Skeleton

Codi font
==

El codi font està disponible a

 https://github.com/acacha/ebre-escool

Roadmap. Possibles funcionalitats futures
==
* Consulta d'horaris d'espais/aules
* Carrega de dades externes
* Assistent canvi de perìode acadèmic
* Pagament de matrícula per TPV
* Mòdul avaluació