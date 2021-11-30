# Puurakenne keskustelupalstan viesteille

Kun index.php-sivu avataan, php-toteutus lataa selaimeen html-tiedoston, javascript-tiedoston ja css-tiedoston. Sitten javascript-tiedosto tekee API-kutsun samaiseen backendiin, joka hakee tietokannasta kaikki post-taulussa löytyvät viestit. Back-end jäsentää viestit kaksiulotteisiksi arayksi niin että aina kun  topic_id arvo vaihtuu un kyseessä eri viestiketju. tämänkin voisi varmaan tehdä javascriptissä mutta tässä versiosa backend käy tietokantadataa sen verran läpi. Sitten backend palauttaa tuon kaksiulotteisen arrayn json-muodossa javascript tiedostolle selaimeen. Javascript-tiedosto jäsentelee viestit jokaisessa sisemmässä arrayssa olevat viestit toistensa alihakemistoiksi sillä perusteella, mikä on tietueen id ja mikä paren_id.

Javascript toteutus tiedostossa
```
.../public/js/index.js
```
HTML-toteutus tiedostossa
```
.../public/app/Views/index/index.php
```

PHP:ssa toteutusjärjestys
```
index.php -> PostController@index -> PostService@index -> Model@all -> PostService@index -> Response@json
```
