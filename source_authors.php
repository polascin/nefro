<?php
declare(strict_types=1);

// Ochrana pred priamym prístupom k súboru
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit("Prístup odmietnutý.");
}

/**
 * Zoznam pôvodných autorov zdrojového článku pre každý článok (podľa slugu).
 * Mená sú vyťažené z odkazu „Zdroj:" cez otvorené bibliografické API
 * (Crossref/PubMed/eutils) a z verejných tlačových správ — nie scrapovaním
 * za paywallom. Doplnkový zdroj identít pre widget „Zúčastnení autori"
 * a filter ?autor= (viď articleAuthorIdentities() v db_config.php).
 *
 * @return array<string,array<int,string>>  slug => zoznam mien autorov
 */
function getSourceArticleAuthors(): array {
    return [
        'anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-checklist-a4-hd-nonhd' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-checklist-kdigo-2026-kdoqi' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-dialyza-ambulancia-checklist' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-kdigo-2026-kdoqi-komentar' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'c3-glomerulopatia-c3g-liecba-inhibicia-komplementu' => ['Manuel Praga', 'Richard J. Smith', 'Andrew S. Bomback'],
        'cystatin-c-kreatinin-egfr-biomarkery-reumatoidna-artritida' => ['Sho Fukui', 'Lesley A. Inker', 'Leah M. Santacroce', 'Jon T. Giles', 'Katherine P. Liao', 'Joan M. Bathon', 'Daniel H. Solomon'],
        'dress-alopurinol-granulomatozna-ain-pankreatitida' => ['Said Al Zein'],
        'farmakologicka-liecba-obezity-pokrocile-ckd-dialyza' => ['Pooja Budhiraja', 'Babak J. Orandi'],
        'finerenon-zakladna-liecba-ckd-glomerularne-ochorenia' => ['Brendon L. Neuen', 'Hiddo J.L. Heerspink', 'Vlado Perkovic'],
        'iga-nefropatia-algoritmus-kdigo-2025-kdoqi' => ['Isabelle Ayoub', 'Gaia Coppock', 'Shikha Wadhwani', 'Timothy Yau'],
        'iga-nefropatia-kdigo-2025-kdoqi' => ['Isabelle Ayoub', 'Gaia Coppock', 'Shikha Wadhwani', 'Timothy Yau'],
        'kedy-zacat-krt-pri-aki' => ['Marlies Ostermann', 'Sean M Bagshaw', 'Nuttha Lumlertgul', 'Ron Wald'],
        'malignity-transplantacia-oblicky-skrining-ptld' => ['Christopher D. Blosser', 'Elena-Bianca Barbir', 'Salma Shaikhouni', 'Naoka Murakami'],
        'moderne-trendy-v-nefroprotekcii' => ['Hiddo J.L. Heerspink', 'Bergur V. Stefánsson', 'Ricardo Correa-Rotter', 'Glenn M. Chertow', 'Tom Greene', 'Fan-Fan Hou', 'Johannes F.E. Mann', 'John J.V. McMurray', 'Magnus Lindberg', 'Peter Rossing', 'C. David Sjöström', 'Roberto D. Toto', 'Anna-Maria Langkilde', 'David C. Wheeler'],
        'nediabeticka-ckd-nehemodynamicke-mechanizmy-nsmra-finerenon' => ['Brendon L. Neuen', 'Beatriz Fernandez-Fernandez'],
        'obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia' => ['Holly J. Kramer', 'Linda-Marie Lavenburg', 'Sankar D. Navaneethan'],
        'ockovanie-ckd-transplantacia-oblicky-vakciny-nacasovanie' => ['Matthias Girndt'],
        'pentoxifylin-diabeticka-choroba-obliciek-mini-review' => ['David J. Leehey', 'Rajiv Agarwal'],
        'prehlad-vyskum-fsgs-diabeticka-nefropatia-2025-2026' => ['Howard Trachtman', 'Sean Eddy', 'Matthias Kretzler'],
        'rastlinna-strava-nizsia-mortalita-ckd' => ['Guido Gembillo'],
        'rodove-rozdiely-dialyza-transplantacia-era-usrds' => ['Vianda S Stel', 'Nicholas C Chesnaye', 'Rianne Boenink', 'Brittany A Boerstra', 'Megan E Astley', 'Shona Methven', 'Line Heylen', 'Halima Resic', 'Marc A G J ten Dam', 'Kristine Hommel', 'Marit D Solbu', 'Maria F Slon Roblero', 'Nuria Aresté-Fosalba', 'Danilo Radunovic', 'Héctor García López', 'Lukas Buchwinkler', 'Rebecca Guidotti', 'Mathilde Lassalle', 'Carmen Santiuste', 'Maria Stendahl', 'Olafur S Indridason', 'Almudena Escribá', 'María Encarnación Bouzas-Caamaño', 'Olga Lucía Rodriguez Arévalo', 'George Moustakas', 'Hermann Hernández Vargas', 'Alberto Ortiz', 'Anneke Kramer'],
        'trpc6-inhibicia-fsgs-faza-2-precizna-nefrologia' => ['Luis Sanchez-Russo', 'George Vasquez-Rios', 'Kirk N. Campbell'],
        'ttv-biomarker-imunosupresia-transplantacia-oblicky' => ['Gregor Bond', 'Frederik Haupenthal', 'Felix Herkner', 'Sebastian Kapps', 'Konstantin Doberer', 'Jette Rahn', 'Carole Janis', 'Marta del Álamo', 'Georg Melzer-Venturi', 'Fabrizio Maggi', 'Hannes Neuwirt', 'Kathrin Eller', 'Daniel Cejka', 'Christian Hugo', 'Miriam Banas', 'Klemens Budde', 'Ondřej Viklický', 'Paolo Malvezzi', 'Sophie Caillard', 'Joris Rotmans', 'Jip Jonker', 'Isabel Beneyto', 'David Navarro', 'David Rodriguez-Arias', 'Heinz Regele', 'Matthias Vossen', 'Franz König'],
        'umela-inteligencia-nefrologia-co-vieme-limity' => ['Prabhat Singh', 'Lokesh Goyal', 'Deobrat C Mallick', 'Salim R Surani', 'Nayanjyoti Kaushik', 'Deepak Chandramohan', 'Prathap K Simhadri'],
    ];
}
