# Publikácia článku ACEI a ARB pri CKD G5

Dátum: 2026-11-17, Europe/Bratislava.

Článok: https://nefro.polascin.net/article.php?slug=acei-arb-ckd-g5-indikacie-off-label
Databázový záznam: 2597. Kategória: odborné články. Zdrojový commit: 5b8381a0.

## Vecná a jazyková kontrola

Pôvodný odborný prehľad s 11 bibliografickými položkami. Zdroje: KDIGO 2024, STOP ACEi, metaanalýza individuálnych údajov Ku et al. 2024, ARCADIA, štúdia Li et al. pri peritoneálnej dialýze, prehľad liečby HFrEF pri CKD a dve doplňujúce práce z roku 2026. Overené slovenské SPC RAMIMED 04/2022 a Losartan Zentiva 07/2026. Zohľadnená časová verzia zákona č. 362/2011 Z. z. účinná 17. novembra 2026.

Kontrola rozlišovala pokračovanie a prvé nasadenie, G5 a G5D, eGFR a klírens kreatinínu, klinickú indikáciu a registračný status konkrétneho lieku, kontraindikáciu a situáciu vyžadujúcu opatrnosť, randomizovaný dôkaz a observačnú asociáciu. Všetci autori uvedení podľa bibliografických záznamov. Kontrola percent, intervalov spoľahlivosti, dávok, jednotiek a citácií. Slovenská redakcia, terminologická konzistencia, gramatika, diakritika a interpunkcia skontrolované. Bez textGrain, textúr, šumu alebo skrytých znakov v autorskom texte.

Rozsah prístupu: relevantné časti KDIGO a SPC overené v plných dokumentoch. Štúdie overené pomocou PubMed Connector a NCBI EFetch vrátane úplných abstraktov a bibliografie. Plné texty a suplementy všetkých štúdií neboli dostupné. Tento limit je výslovne uvedený aj v článku. Nepredstiera sa plnotextová revízia všetkých prác.

## Technická a produkčná kontrola

- PHP lint: 787 súborov bez chyby.
- Regresná sada: 64 súborov PASS; JavaScript bez syntaktickej chyby.
- Samostatná statická analýza publikačného súboru bez chyby.
- Lokálne nasadenie cez SSH alias websupport. Žiadny GitHub Actions deploy.
- Pred vložením slug v databáze neexistoval. Prvé spustenie: jeden vložený článok. Opakovanie: jeden preskočený článok, žiadna zmena a žiadna duplicita.
- enqueue_newsletter=false. Obe fronty article_newsletter_queue a nl_sub_queue: 0 záznamov pre article_id=2597.
- Článok a úvodná stránka HTTP 200; úvodná stránka obsahuje nový slug.
- PDF vytvorené na produkcii, stiahnuté cielene cez SCP: 5 strán, 283393 bajtov. Obrázok vložený v PDF v rozmere 1586 x 992. Text vrátane záverečných zdrojov a diakritiky extrahovaný a skontrolovaný; prvá strana vizuálne skontrolovaná.
- SHA-256 lokálneho a produkčného PDF: ca2403f3aa3687b991d186e24bda155bbd9d51e82a94b8ed0ee1d301db4f5e59.
- Verejná cesta download_pdf.php?slug=acei-arb-ckd-g5-indikacie-off-label vracia neprihlásenému HTTP 302 na login.php. Priamy adresár pdf je chránený HTTP 403. Prihlásené sťahovanie používateľom nebolo samostatne skúšané.

## Ilustrácie a anotácie

Dve pôvodné generované ilustrácie: článková oblička s tabletou a svetelnými oblúkmi; sociálna ilustrácia priehľadných obličiek nad váhami s tabletou a srdcom. Pomer približne 16:10, natívne 1586 x 992. Žiadny textový šum, zrno ani textúrový prekryv. Na webovej ilustrácii štandardný portálový vodoznak a WebP. Pôvodné obrázky uložené na Google Disk v Nefro/Ilustracie, sociálny obrázok v podpriečinku Slovenske-a-anglicke-anotacie/acei-arb-ckd-g5-indikacie-off-label. Existencia oboch cloudových súborov overená konektorom.

Krátke slovenské a anglické anotácie sú v anotacie-sk-en.md a posts.json. Na každej sieti jeden dvojjazyčný príspevok s vlastným nahraným obrázkom. Texty boli pred publikovaním jazykovo skontrolované.

## Sociálne publikovanie

- X: https://x.com/polascin/status/2122725884868034860
- Facebook: https://www.facebook.com/photo/?fbid=10245843810369000&set=a.1137300272261
- LinkedIn: https://www.linkedin.com/feed/update/urn:li:activity:7528492738883973122/
- Threads: https://www.threads.com/@lubomirpolascin/post/Df2WkafiKml

Všetky štyri výsledky overené cez používateľské rozhranie: správny účet, oba jazyky, odkaz a obrazová príloha. X je chránený účet, jeho nastavenie sa nemenilo. Facebook, X a Threads uvádzajú označenie AI; LinkedIn zachoval content credentials. X, LinkedIn a Threads majú vlastný alternatívny text. Na Facebooku bola obrazová príloha doplnená úpravou už vytvoreného textového príspevku, výsledok overený. Pri riešení nahratia zostal na Facebooku uložený pomocný koncept iba s obrázkom, nebol zverejnený. Snímky výsledkov LinkedIn a Threads sú v tomto priečinku.

Google Disk, článkový originál: https://drive.google.com/file/d/1-y6IpVrEQ6spcrwQv-UnN47Q61W9sUv3/view
Google Disk, sociálna ilustrácia: https://drive.google.com/file/d/1KA23w40ljpOe-pkMfw7X3zPJkys2T9MD/view

Pracovné rešeršné súbory ostávajú lokálne v editorial/research/2026-11-17-acei-arb-g5. Cudzie rozpracované súbory sa nemenili.