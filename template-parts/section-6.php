<?php 
$places = [
  [
    "id" => "hoteles",
    "title-en" => "HOTELS",
    "title-es" => "HOTELES",
    "img" => IMG_BASE . 'icon-hotels.svg',
  ],
  [
    "id" => "restaurantes",
    "title-en" => "RESTAURANTS",
    "title-es" => "RESTAURANTES",
    "img" => IMG_BASE . 'icon-restaurants.svg',
  ],
  [
    "id" => "postres",
    "title-en" => "BRUNCH & DESSERTS",
    "title-es" => "BRUNCH Y POSTRES",
    "img" => IMG_BASE . 'icon-brunch.svg',
  ],
  [
    "id" => "bares",
    "title-en" => "BARS & PUBS",
    "title-es" => "BARES Y DISCOTECAS",
    "img" => IMG_BASE . 'icon-bars.svg',
  ],
  [
    "id" => "boutiques",
    "title-en" => "BOUTIQUES",
    "title-es" => "TIENDAS",
    "img" => IMG_BASE . 'icon-boutiques.svg',
  ],
  [
    "id" => "salones",
    "title-en" => "BEAUTY SALONS",
    "title-es" => "SALONES DE BELLEZA",
    "img" => IMG_BASE . 'icon-beauty.svg',
  ],
]
?>
<section class="section6">
    <img class="section6__img desktop" src="<?php echo IMG_BASE . 'img-10.webp'?>" alt="">
    <img class="section6__img mobile" src="<?php echo IMG_BASE . 'img-10-mobile.webp'?>" alt="">
    <p class="heading--24 color--FCF0E3 name" id="cartagena">#SpencerAndDaniela</p>
    <div class="section6__content">
      <div class="box">
        <h2 class="font--blancha heading--72 color--836923">
          Enjoy
          <img class="" src="<?php echo IMG_BASE . 'airplane.png'?>" alt="">
        </h2>
        <p class="heading--65 color--836923 uppercase">CARTAGENA</p>
        <span class="space space--20"></span>
        <p class="heading--32 color--836923">DISFRUTA CARTAGENA</p>
        <span class="space space--20"></span>
        <span class="line line--small"></span>
        <span class="space space--20"></span>
        <span class="space space--10"></span>
        <div class="text-traslate-es">
          <p class="heading--24 color--000">
          We are thrilled to be hosting our wedding in Cartagena, Colombia's coastal gem. This city, designated as a UNESCO world heritage site, stands as one of South America's most significant cultural treasures. The walls of Cartagena de Indias grace the historical center, known as "the walled city," where you can discover squares, cobblestone streets, and exquisite, vibrant colonial buildings.
          </p>
          <span class="space space--20"></span>
          <p class="heading--24 color--000">
          The ultimate way to experience Cartagena is by strolling through it, immersing yourself in the maze of narrow streets and lush green plazas. We highly recommend lodging within the walled city, where everything is conveniently within walking distance. The streets are alive with constant live music, splendid restaurants, and quirky bars, all contributing to the vibrant atmosphere of Cartagena.
          </p>
        </div>
        <div class="text-traslate-en" style="display: none">
          <p class="heading--24 color--000">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolor pariatur dignissimos provident molestias, deserunt eius iure harum, officia fugit sapiente velit consequuntur recusandae sunt, ipsam porro natus! Odit, animi delectus.
          </p>
          <span class="space space--20"></span>
          <p class="heading--24 color--000">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates mollitia blanditiis assumenda laudantium ad, ipsa eaque nesciunt! In beatae ab sunt porro, aspernatur, adipisci totam eum rerum magnam, ipsum hic!
          </p>
        </div>
        <span class="space space--20"></span>
        <button type="button" class="traslate color--A07F2B" data-traslate>Leer en Español</button>
        <span class="space space--20"></span>
        <span class="space space--20"></span>
        <div class="places">
          <?php foreach ($places as $key => $place) { ?>
            <a href="/cartagena/#<?php echo $place['id']; ?>">
              <img src="<?php echo $place['img']; ?>" alt="">
              <div>
                <p class="heading--36 color--836923"><?php echo $place['title-en']; ?></p>
                <p class="heading--20 color--836923"><?php echo $place['title-es']; ?></p>
              </div>
            </a>
          <?php } ?>
        </div>
      </div>
    </div>
</section>