(: 1. Ajouter un nouveau membre :)
insert node 
  <membre id="M009" categorieRef="C2">
    <nom>Ziri</nom><prenom>Fouad</prenom><email>f.ziri@club.dz</email>
  </membre>
as last into doc("club.xml")//membres,

(: 2. Modifier le coefficient d'un concours :)
replace value of node doc("club.xml")//concours[@id="CO1"]/@coefficient with "2.0",

(: 3. Supprimer un participant :)
delete node doc("club.xml")//concours[@id="CO1"]//participant[@membreRef="M004"]