<h1>Bienvenue sur le pupitre digital </h1>

<div class='row'>

   <div class='col-md-6'>
        <p>Sur le pupitre digital, on aime la musique et les nouvelles technologies.</p>
        <p>On aime jouer et écouter de la musique, mais aussi composer, mixer, arranger.</p>
        <p>On aime les instruments et aussi tous les objets connectés qui vont avec.</p>
        <p>Les ordinateurs et les logiciels de compositions, de lecture de partitions ...</p>
        <p>Les smartphones et tablettes tactiles, les guitares connectées, les baguettes connectées...</p>
   </div>
    <div class='col-md-6'>
        <img src='images/pupitredigital.jpg' style='height:300px' />
    </div>

    <div class='col-md-12'  style='border-top:1px solid grey; width:100%'></div>
    <div class='col-md-6'>
      <img src='images/blog.jpg' style='height:300px' />
    </div>


    <div class='col-md-6'>

    <h2>Notre blog consacré aux nouvelles technologies</h2>
    <p>Nous publions régulièrement nos trouvailles et les nouveautés que l'on déniche à droite à gauche.</p>
    <P>Des guitares connectées, des applications et logiciels, il y en a pour tous les gouts.</p>
    <p>Notre blog est un espace de convivialité  ouvert. Alors participez, donnez-nous votre avis, n'hésitez pas à nous proposer aussi vos trouvailles ou vos projets musicaux.</p>
</div>

<div class='col-md-12'  style='border-top:1px solid grey; width:100%'></div>

<div class='col-md-6'>
<h2>Acteur de ce monde connecté</h2>
<p>Ce monde connecté qui nous passione nous a donner envie de concevoir notre propre logiciel de musique.</p>
<p>Ce projet est nè d'un constat simple : </p>
<ul>
  <li>Il est toujours de difficile de trouver rapidement tous les éléments nécessaires  pour jouer un morceau.</li>
  <li>Il faut aller sur un site pour trouver les partitions et avoir le bon logiciel.</li>
  <li>Il faut ensuite aller sur un autre pour trouver les paroles.</li>
  <li>Enfin il faut parcourir le web pour trouver une bande son sans tel ou tel instrument.</li>
</ul>
<h3>Et ce n'est pas fini</h3>
<p>Si ensuite on veut <b>Jouer</b> il faut :
<ul>
  <li>Ouvrir une fenêtre avec les paroles.</li>
  <li>Ouvrir le logiciel pour les partitions ou tablatures.</li>
  <li>Enfin avoir lançer le mp3 avant ou Youtube.</li>
</ul>
</p>

<p>Rien de simple là-dedans. Et en plus il faut faire cette manœuvre  pour chaque morceau ! </p>
</div>
<div class='col-md-6' >
  <img src='images/logiciel.png' style='height:300px' />
</div>

<div class='col-md-12' style='text-align:center'>
<h3>Ne cherchez plus <b>Notre logiciel</b>, fait tout ça pour vous.</h3>

<h4>Venez le découvir en Exclusivité. </h4>

Comment faire ?

<div>C'est simple. Cliquer sur le bouton ci-dessous.</div>
  <div class='btn btn-success' style='width:60%;margin:10px;'>
      {{downloader}}
    </div>
</div>

<div class='col-md-12'  style='border-top:1px solid grey; width:100%'>
  <h3>Les derniers articles</h3>
  {{foreach Articles}}
    <div class='col-md-4'>
      {{element->GetImage()}}<br/>
      <h4><a href='{{GetPath(/Blog/Article/)}}{{element->GetUrlCode()}}'>
        
              {{element->Name->Value}}</a></h4>
          
         {{element->GetSmallDescription()}}
     
   </div>
     </li>
 {{/foreach Articles}}


</div>
