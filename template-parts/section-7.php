<?php 
$placesCartagena = [
    [
        "img" => "cartagena-1.png",
        "name" => "Teatro Heredia",
        "copy" => "Magnífico de estilo ecléctico diseñado por Luis Felipe Jaspe, el mismo arquitecto que creó la Torre del Reloj de Cartagena.",
    ],
    [
        "img" => "cartagena-2.png",
        "name" => "Murallas de Cartagena",
        "copy" => "Fortificación que tardó más de cien años en completarse, llevada a cabo por etapas desde 1586 hasta 1699, abarcando el perímetro del centro de la ciudad vieja, San Diego y Getsemaní.",
    ],
    [
        "img" => "cartagena-3.png",
        "name" => "Torre del Reloj",
        "copy" => "Famosa puerta de entrada a la ciudad amurallada, caracterizada por su portada barroca de piedra que precede a una imponente estructura.",
    ],
    [
        "img" => "cartagena-4.png",
        "name" => "Letrero de Cartagena",
        "copy" => "El letrero está ubicado en la carretera que lleva a Bocagrande, el sector donde se encuentran la mayoría de los hoteles de la ciudad y donde hay bonitas playas públicas para nadar.",
    ],
    [
        "img" => "cartagena-5.png",
        "name" => "Barrio Getsemaní",
        "copy" => "Es uno de los lugares más visitados de la ciudad. Aquí encontrarás grafitis, hoteles, cervecerías e increíble música que sin duda te harán volver a este lugar.",
    ],
    [
        "img" => "cartagena-6.png",
        "name" => "Convento Santa Cruz de la Popa",
        "copy" => "El convento, claustro y capilla de Nuestra Señora de la Candelaria de la Popa se encuentran en la cima del Cerro de la Popa en Cartagena. Multitudes de devotos hacen una peregrinación a pie hasta la cima del cerro de la Popa.",
    ],
    [
        "img" => "cartagena-7.png",
        "name" => "Castillo San Felipe",
        "copy" => "Uno de los sitios más famosos, corresponde a un castillo construido en el siglo XVII, obra de la ingeniería militar española en América.",
    ],
    [
        "img" => "cartagena-9.png",
        "name" => "Monumento de las Botas Viejas",
        "copy" => "Ubicado en la base del Castillo de San Felipe, el Monumento a los Zapatos Viejos es una escultura gigante de un par de botas viejas. Un lugar popular para tomarse una selfie, el monumento fue creado por Héctor Lombana Piñeres.",
    ],
    [
        "img" => "cartagena-7.jpg",
        "name" => "Islas del Rosario",
        "copy" => "En las Islas del Rosario se puede disfrutar de un destino paradisíaco de hermosas playas de arena blanca y las cálidas y cristalinas aguas del Mar Caribe. (¡Estaremos en la Isla Barú el 25 de julio!)",
    ],
];
?>
<section class="section7" id="cartagena">
    <p class="heading--96 text--center color--836923">Places to Visit</p>
    <p class="heading--32 text--center color--836923">LUGARES PARA VISITAR</p>
    <span class="space space--20"></span>
    <span class="line line--small"></span>
    <span class="space space--10"></span>
    <span class="space space--20"></span>
    <div class="sectionPlaces">
      <div class="sectionPlaces__wrapper">
        <div class="slickPlaces">
          <?php foreach ($placesCartagena as $idx => $cartagena) { ?>
            <div class="sectionPlaces__padding">
              <div class="sectionPlaces__item">
                <img src="<?php echo IMG_BASE . $cartagena['img']; ?>" alt="">
                <div class="sectionPlaces__info">
                  <h3 class="heading--26 color--836923 uppercase text--left"><?php echo $cartagena['name']; ?></h3>
                  <div class="space space--20"></div>
                  <div class="line line--small line--left"></div>
                  <div class="space space--20"></div>
                  <p class="heading--22 color--000 spacing--1"><?php echo $cartagena['copy']; ?></p>
                </div>
              </div>
            </div>
          <?php } ?>  
        </div>
      </div>
    </div>
 
</section>