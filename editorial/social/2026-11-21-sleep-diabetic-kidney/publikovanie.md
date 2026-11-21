# Publikovanie: dĺžka spánku a albuminúria pri diabete

Dátum: 2026-11-21, Europe/Bratislava.
Článok: https://nefro.polascin.net/article.php?slug=dlhsi-spanok-diabetes-albuminuria-kohorta
Záznam v DB: 2612. Zdrojový commit: d0537d94.

## Zdroje a rozsah kontroly

Východisková správa: Batya Swift Yasgur, Medscape, 20. november 2026. Verejný celý text a byline načítané priamym HTTP GET, HTTP 200 po použití štandardného User-Agent. Spracovaná pôvodná práca Fuki Ikeda a spoluautori, DOI 10.1210/jendso/bvag201, PMID 42852320, PMCID PMC13648002. Úplný text načítaný priamym Europe PMC API, vrátane metodiky, tabuliek 1 až 4, výsledkov, diskusie a obmedzení. Všetkých 11 autorov overených v NCBI EFetch XML. Žiadny údaj o retrakcii v načítanom zázname.

Doplňujúca kohorta UK Biobank (Niu a spoluautori, 2025, PMID 39929336): úplný abstrakt a bibliografia z EFetch. ADA Standards of Care 2026 (PMID 41358881): bibliografické metadáta z EFetch, relevantné plné pasáže o opakovanom potvrdení albuminúrie cez webový nástroj na PMC. Konsenzus AASM/SRS (PMID 26039963): všetci bibliografickí autori z EFetch a úplné odporúčanie cez webový nástroj na PMC. Bibliografia obsahuje všetkých autorov, skupinové autorstvo ADA je zachované.

Samostatný suplement: metadáta Figshare API overené, DOI 10.6084/m9.figshare.32407353, súbor 20260731 JES Supplementary Table.docx. Priame stiahnutie cez odkaz dodaný API vracalo HTTP 403. Suplement sa preto neoznačuje za načítaný. Detailné podskupinové závery sa nepreberajú. V hlavnom texte je navyše rozdielny slovný opis významnosti podskupín podľa vstupnej albuminúrie medzi Results a Discussion. Bez suplementu sa tento rozpor nedá nezávisle rozhodnúť, preto článok nepreberá tvrdenie o preukázanej asociácii v tejto podskupine. Hlavná tabuľka výsledkov a tabuľka spojitej analýzy sú dostupné a súladné; odlišná významnosť vyplýva z odlišných modelov.

## Odborná kontrola

- Rozlíšená celá kohorta 678 osôb a 215 udalostí od kategóriovej analýzy 677 osôb a 214 udalostí. Jeden účastník nemal údaj o spánku pred udalosťou. Počty skupín a udalostí overené v tabuľkách 3 a 4.
- Uvádzané HR 1,08; 1,56; 1,92 aj intervaly spoľahlivosti overené proti tabuľke 4. Ide o hazard albuminurickej udalosti, nie absolútne riziko zlyhania obličiek.
- Výslovne uvedený nevýznamný spojitý model: HR 1,13 na hodinu, 95 % IS 0,98 až 1,30, p = 0,082, tabuľka 2. Kategóriová analýza má p pre trend 0,003. Neprítomnosť korekcie početných analýz na viacnásobné testovanie uvedená podľa diskusie autorov.
- Jednorazové ročné vyšetrenie albuminúrie odlíšené od klinického potvrdenia patologických dvoch z troch vzoriek za tri až šesť mesiacov podľa ADA 2026.
- Asociácia sa nezamieňa s kauzalitou. Referenčný spánok pod šesť hodín sa neprezentuje ako ochranný. Bez odporúčania skracovať spánok, meniť nefroprotektívnu liečbu či vytvárať nový skríningový interval.
- Zohľadnené subjektívne hodnotenie spánku, možná opačná kauzalita, rozdielny vstupný zdravotný stav, reziduálne skreslenie a nezachytené zmeny liečby počas sledovania. Vstupné nepoužívanie SGLT2 inhibítorov overené v tabuľke 1.
- Uvedené vekové vymedzenie konsenzu AASM/SRS od 18 do 60 rokov; bez mechanického prenesenia na starších či chorých pacientov.
- Slovenská vecná, terminologická, gramatická a štylistická kontrola a následná kontrola zachovania významu. Bez dlhých pomlčiek, skrytých znakov alebo textGrain.

HTTP kontroly všetkých externých odkazov uložené v editorial/research/2026-11-21-sleep-diabetic-kidney/http-links.json. Medscape HTTP 200; PubMed HTTP 203; DOI britskej práce HTTP 200 s presmerovaním na Elsevier. Ostatné DOI vracajú HTTP 403, automatizovaný prístup obmedzený. Žiadny 404/410. Bibliografické identity overené priamo cez NCBI. Priamy pokus o KDIGO PDF a AASM PDF vracal 403; použité dostupné primárne zdroje ADA a PMC, bez predstierania načítania odmietnutých PDF.

## Nasadenie a PDF

PHPStan nového článku bez chyby. Lokálna brána pred nasadením: 795 PHP súborov bez syntaktickej chyby, 64 regresných súborov PASS, JavaScript syntax v poriadku. Sken tajomstiev prešiel. Nasadenie cez miestne hooky a SSH alias websupport, bez GitHub Actions deployu.

Pred vložením slug v databáze neexistoval. Prvý beh: inserted=1, updated=0, queued=0, errors=[]. Opakovanie: skipped=1, inserted=0, updated=0, queued=0. Obe fronty article_newsletter_queue a nl_sub_queue pre article_id=2612 obsahovali 0 záznamov. Newsletter ani avízo sa neodosielali.

Článok aj domovská stránka HTTP 200. Domovská stránka obsahuje nový slug, telo článku obsahuje správnu ilustráciu, podstatné výsledky a celú bibliografiu.

PDF: 3 strany, 227108 bajtov. Vytvorené na produkcii a cielene stiahnuté cez scp -O s aliasom websupport. Text vrátane bibliografie extrahovaný a skontrolovaný, prvá strana vizuálne overená. Lokálny aj produkčný SHA-256: 4c372d82dd5f355a0e248e5b23b003495161bee5b2aac39b27c1c01bc8c35128. Hromadný sync sa nepoužil, aby sa nemiešali cudzie PDF a nepoužil pevne zadaný SSH cieľ skriptu.

## Ilustrácie a siete

Dve pôvodné generované ilustrácie upravené na 1600 × 1000: článková scéna s obličkami a nočným pozadím, sociálna scéna s posteľou a modelom obličky. Bez textu alebo log podľa zadania. Webová verzia WebP, zdrojové PNG a sociálny PNG v repozitári. Kópie v G:/Môj disk/nefro.polascin.net/obrazky/2026-11 overené SHA-256, nezávislá existencia oboch cloudových súborov overená Drive konektorom. V rovnakom priečinku uložené aj anotácie v Markdown.

SK a EN texty aj obrázky zobrazené používateľovi pred zverejnením. X: SK a EN vo vlákne, každý príspevok pod 280 znakmi pri zohľadnení t.co. Threads: SK a EN vo vlákne. Facebook a LinkedIn: jeden dvojjazyčný príspevok, na LinkedIn štyri odborné hashtagy. Alternatívny text doplnený na všetkých sieťach, Facebook AI label on. Chránený účet X zostal chránený.

Publikovanie overené v rozhraní na profiloch po dokončení. X: obe jazykové časti, správny odkaz a obrázok. LinkedIn: oba jazyky, obrázok a permalink po obnovení. Threads: obe časti a obrázok. Facebook: oba jazyky, odkaz a fotografia na profile po dokončení. Snímky X, LinkedIn a Threads sú uložené v tomto priečinku.

- x_sk: https://x.com/polascin/status/2124267130787148210
- x_en: https://x.com/polascin/status/2124267134989599180
- facebook: https://www.facebook.com/photo/?fbid=10245940878315638&set=a.1137300272261
- linkedin: https://www.linkedin.com/feed/update/urn:li:activity:7530032847575801856/
- threads_sk: https://www.threads.com/@lubomirpolascin/post/DgBSt-WCKSL
- threads_en: https://www.threads.com/@lubomirpolascin/post/DgBSvSuCCE8
- drive_article_image: https://drive.google.com/file/d/1Vn7IttBtsbxu1YjaLyt_cnIbHnFgjNRl/view
- drive_social_image: https://drive.google.com/file/d/1WUfu_9G4Ouo2rAWMfSNVa-FHq6xgyZ1S/view

Otvorené zostáva nezávislé preverenie samostatného suplementu. Toto obmedzenie je priznané aj v článku a neoverené podskupinové závery sa nepublikovali. Žiadna ďalšia používateľská akcia nie je potrebná na dokončenie tejto publikácie.
