(: Q1: Liste des membres avec catégories :)
<results>{
  for $m in //membre
  let $cat := //categorie[@id = $m/@categorieRef]
  return <info>{concat($m/prenom, ' ', $m/nom)} - {$cat/@libelle/string()}</info>
}</results>