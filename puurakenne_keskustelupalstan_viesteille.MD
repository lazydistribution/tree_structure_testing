# Puurakenne keskustelupalstan viesteille

Kun index.php-sivu avataan, php-toteutus lataa selaimeen html-tiedoston, javascript-tiedoston ja css-tiedoston. Sitten javascript-tiedosto tekee API-kutsun samaiseen PHP-backendiin, joka hakee tietokannasta kaikki post-taulussa löytyvät viestit. Backend jäsentää viestit PHP:lla kaksiulotteisiksi arayksi niin, että aina kun topic_id arvo vaihtuu, vaihtuu sisempi array. Tämänkin jäsentelyn voisi varmaan tehdä javascriptissä selaimessa, mutta tässä versiosa backend käy tietokantadataa tämän verran läpi. Sitten backend palauttaa tuon kaksiulotteisen arrayn json-muodossa javascript-tiedostolle selaimeen. Javascript-tiedosto jäsentelee jokaisessa sisemmässä arrayssa olevat viestit toistensa alihakemistoiksi sillä perusteella, mikä on tietueen id ja mikä on tietueen parent_id.

Javascript toteutus tiedostossa
```
.../public/js/index.js
```
HTML-toteutus tiedostossa
```
.../app/Views/index/index.php
```

PHP:ssa toteutusjärjestys
```
.../public/index.php -> .../app/Controllers/PostController@index -> .../app/Services/PostService@index -> .../app/Model/Model@all -> PostService@index -> PostController@index -> .../app/Bootstrap/Response@json
```
