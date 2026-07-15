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
 * a filter ?autor= (pozri articleAuthorIdentities() v db_config.php).
 *
 * LEN pre články, ktoré sú spracovaním JEDNÉHO konkrétneho zdrojového článku —
 * uvádzaj jeho pôvodných autorov. NEUVÁDZAJ autorov štúdií/odporúčaní len
 * citovaných v pôvodnom (originálnom) článku; pôvodný text bez konkrétneho
 * zdroja ostáva len pod autorom projektu.
 *
 * @return array<string,array<int,string>>  slug => zoznam mien autorov
 */
function getSourceArticleAuthors(): array {
    return [
        '5-kritickych-chyb-manazment-ckm-syndromu-nefrologia' => ['Lisa O\'Mary'],
        'ai-nefrologia-hands-on-primer-klinicka-integracia' => ['Noppawit Aiumtrakul', 'Arjunmohan Mohan', 'Harshil A. Fichadiya', 'Wisit Cheungpasitporn'],
        'ai-scribe-pravne-nastrahy-ambulancia-nefrologia' => ['Ericka L. Adler'],
        'anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-checklist-a4-hd-nonhd' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-checklist-kdigo-2026-kdoqi' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-dialyza-ambulancia-checklist' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-kdigo-2026-kdoqi-komentar' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'atacicept-trutakna-iga-nefropatia-fda-proteinuria' => ['Siddhi Mahatole', 'Puyaan Singh'],
        'antimikrobialna-rezistencia-infekcie-mocovych-ciest-nefrologia' => ['Sibylle von Vietinghoff', 'Olga Shevchuk', 'Ulrich Dobrindt', 'Daniel Robert Engel', 'Selina K. Jorch', 'Christian Kurts', 'Thomas Miethke', 'Florian Wagenlehner'],
        'betablokatory-ckd-bez-kardiovaskularneho-ochorenia' => ['Seung Hyun Han', 'Mina Kim', 'Jungkuk Lee', 'Sang Youb Han'],
        'c3-glomerulopatia-c3g-liecba-inhibicia-komplementu' => ['Manuel Praga', 'Richard J. Smith', 'Andrew S. Bomback'],
        'ckd-samostatny-faktor-polyfarmacie' => ['Rafael Santamaria', 'Carlos Escobar', 'Ignacio Hernández', 'Beatriz Palacios', 'Unai Aranda', 'Roberto Alcázar'],
        'ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia' => ['Chiadi E Ndumele', 'Fatima Rodriguez', 'Gurusher S Panjrath', 'Morgane Cibotti-Sun', 'Mykela M Moore', 'Noreen T Nazir', 'Sandra M Oliver-McNeil', 'Sean Pinney', 'Dave L Dixon', 'Sadiya S Khan', 'Debabrata Mukherjee', 'Mandeep Bajaj', 'Sripal Bangalore', 'Burak Bozkurt', 'Kristen Breathett', 'Sarah L Clarke', 'Ingrid H de Boer', 'David H Ellison', 'Lisa S Evangelista', 'Suzanne P Heffron', 'Daichi S Kazi', 'Anuja Kulshreshtha', 'Ileana Lingvay', 'Chyong-Cyril Low Wang', 'Carlos A Mercado', 'Jason M Morton', 'Ian J Neeland', 'Neha Pagidipati', 'Tiffany M Powell-Wiley', 'Jayoung Rangaswami', 'G K Rao', 'N Reza', 'A Saeed', 'William St Peter', 'John B Starks', 'Megan Sterling', 'Ashley W Talbot', 'Amy H Tran', 'Karen R Tuttle', 'Linda B VanWagner', 'Alice R Vest', 'Salim S Virani'],
        'cystatin-c-kreatinin-egfr-biomarkery-reumatoidna-artritida' => ['Sho Fukui', 'Lesley A. Inker', 'Leah M. Santacroce', 'Jon T. Giles', 'Katherine P. Liao', 'Joan M. Bathon', 'Daniel H. Solomon'],
        'dialyzacny-dysekvilibracny-syndrom-zaciatok-hemodialyzy' => ['Théo Servan-Schreiber', 'Guillaume Lano', 'Matthieu Giot', 'Océane Jehel', 'Marion Pelletier', 'Marion Sallée', 'Philippe Brunet', 'Stéphane Burtey', 'Thomas Robert'],
        'dress-alopurinol-granulomatozna-ain-pankreatitida' => ['Said Al Zein'],
        'dyslipidemia-ckd-acc-aha-2026-nefrologicka-prax' => ['Amaryllis H Van Craenenbroeck', 'Patrick B Mark', 'Jose M Valdivielso', 'EuReCa-m Working Group of the European Renal Association'],
        'egfr-diabetes-ekfc-ckd-epi-stadia-ckd' => ['YuXia Zi', 'WenXing Fan'],
        'ema-zrusenie-povolenia-tavneos-avacopan-anca-vaskulitida' => ['Rob Hicks'],
        'farmakologicka-liecba-obezity-pokrocile-ckd-dialyza' => ['Pooja Budhiraja', 'Babak J. Orandi'],
        'finerenon-ckm-syndrom-dm2-ckd-fidelity' => ['Kevin Bryan Lo', 'John W Ostrominski', 'Yasuhiro Hamatani', 'Brian L Claggett', 'Rajiv Agarwal', 'Stefan D Anker', 'Gerasimos Filippatos', 'Peter Rossing', 'Luis M Ruilope', 'Bertram Pitt', 'Alexandros Briasoulis', 'Kimon Stamatelopoulos', 'Meike Brinker', 'Patrick Schloemer', 'Andrea Glasauer', 'Scott D Solomon', 'Muthiah Vaduganathan'],
        'finerenon-zakladna-liecba-ckd-glomerularne-ochorenia' => ['Brendon L. Neuen', 'Hiddo J.L. Heerspink', 'Vlado Perkovic'],
        'frailty-ckd-vyziva-pohyb-stisk-ruky' => ['Fang-Ru Yueh', 'Dongjuan Xu', 'Huan-Fang Lee', 'Junne-Ming Sung', 'Miaofen Yen'],
        'genotypizacia-apol1-zivy-darca-oblicky' => ['Chi-Yuan Hsu', 'Ying Gao', 'Barry I Freedman', 'Mitchell R Lunn', 'Anthony N Muiru', 'Mark A Schnitzler', 'Jasmin Divers', 'Roslyn B Mannon', 'Nicholette D Palmer', 'Amy B Karger', 'Krista L Lentine', 'Meyeon Park'],
        'glp1-era-novy-model-starostlivosti-o-obezitu-nefrologia' => ['Manuela Callari'],
        'glp1-kompulzivne-spravanie-food-noise-nefrologia' => ['Eric Spitznagel'],
        'iga-nefropatia-algoritmus-kdigo-2025-kdoqi' => ['Isabelle Ayoub', 'Gaia Coppock', 'Shikha Wadhwani', 'Timothy Yau'],
        'implementacia-intenzivnej-kontroly-tlaku-esprit-nefrologia' => ['Yu-Jie Zuo', 'Ji-Guang Wang'],
        'inhibicia-tmao-fmc-regresia-fibrozy-ckd-model' => ['Joseph A DiDonato', 'Taylor L Weeks', 'Nilaksh Gupta', 'Deepthi P Mallela', 'Jennifer A Buffa', 'Zeneng Wang', 'Xinmin S Li', 'James T Anderson', 'Xiaoming Fu', 'Naseer Sangwan', 'Ina Nemet', 'Scott J Cameron', 'Stanley L Hazen'],
        'iga-nefropatia-kdigo-2025-kdoqi' => ['Isabelle Ayoub', 'Gaia Coppock', 'Shikha Wadhwani', 'Timothy Yau'],
        'ked-sa-citime-chori-co-medicina-prehliada-nefrologia' => ['Arya Anthony Kamyab'],
        'kedy-zacat-krt-pri-aki' => ['Marlies Ostermann', 'Sean M Bagshaw', 'Nuttha Lumlertgul', 'Ron Wald'],
        'kvalitativny-vyskum-nefrologia-rozhodovanie-pacientov-ckd' => ['Lisa O\'Mary'],
        'kreatin-zdravie-mozgu' => ['Heidi Moawad'],
        'malignity-transplantacia-oblicky-skrining-ptld' => ['Christopher D. Blosser', 'Elena-Bianca Barbir', 'Salma Shaikhouni', 'Naoka Murakami'],
        'meduza-hojenie-ran-bez-jaziev-regenerativna-medicina' => ['Jocelyn E. Malamy', 'Maxwell Sassaman', 'Manjula P. Mony'],
        'moderne-trendy-v-nefroprotekcii' => ['Hiddo J.L. Heerspink', 'Bergur V. Stefánsson', 'Ricardo Correa-Rotter', 'Glenn M. Chertow', 'Tom Greene', 'Fan-Fan Hou', 'Johannes F.E. Mann', 'John J.V. McMurray', 'Magnus Lindberg', 'Peter Rossing', 'C. David Sjöström', 'Roberto D. Toto', 'Anna-Maria Langkilde', 'David C. Wheeler'],
        'nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou' => ['Jooyeon Yoon', 'Kyungjun Shon', 'Hayne Cho Park', 'Sua Lee', 'Young-Ki Lee', 'Hyungseok Lee', 'Eun Jung Kim', 'Hoon Suk Park', 'Min-Ho Kim', 'Do Hyoung Kim'],
        'nediabeticka-ckd-nehemodynamicke-mechanizmy-nsmra-finerenon' => ['Brendon L. Neuen', 'Beatriz Fernandez-Fernandez'],
        'nova-ada-vyskumne-granty-politicky-zasah-dopad-na-nefrologiu' => ['Irl B. Hirsch'],
        'obezita-nakladova-diagnoza-glp1-pristup-nefrologia' => ['Amy Faith Ho'],
        'obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia' => ['Holly J. Kramer', 'Linda-Marie Lavenburg', 'Sankar D. Navaneethan'],
        'oblicka-v-centre-ckm-syndromu-kdigo' => ['Adeera Levin', 'Nisha Bansal', 'Ian H de Boer', 'Morgan E Grams', 'Michel Jadoul', 'Jozine M Ter Maaten', 'Reem A Mustafa', 'Peter Rossing', 'Michael Cheung', 'Jennifer M King', 'Amy Earley', 'Paul E Stevens'],
        'ochorenie-obliciek-tehotenstvo-multidisciplinarna-starostlivost' => ['Manal E Alotaibi', 'Ghada Ankawi'],
        'ockovanie-ckd-transplantacia-oblicky-vakciny-nacasovanie' => ['Matthias Girndt'],
        'pentoxifylin-diabeticka-choroba-obliciek-mini-review' => ['David J. Leehey', 'Rajiv Agarwal'],
        'perzistujuca-hyperparatyreoza-po-transplantacii-oblicky' => ['Daniele Vetrano', 'Simona Barbuto', 'Francesco Aguanno', 'Paolo Mastromauro', 'Valeria Grandinetti', 'Giorgia Comai', 'Gaetano La Manna', 'Giuseppe Cianciolo'],
        'predialyzacna-edukacia-volba-peritonealnej-dialyzy' => ['Magdalena Mosakowska', 'Ewelina Jędrych', 'Ewa Kotwica-Strzałek', 'Agnieszka Dorywalska', 'Arkadiusz Lubas', 'Stanisław Niemczyk'],
        'prehlad-vyskum-fsgs-diabeticka-nefropatia-2025-2026' => ['Howard Trachtman', 'Sean Eddy', 'Matthias Kretzler'],
        'protein-kreatin-uz-nie-su-len-fitness-tema-nefrologia' => ['Lou Schuler'],
        'prukaloprid-brain-fog-depresia-kognicia-nefrologia' => ['Pauline Anderson'],
        'rastlinna-strava-nizsia-mortalita-ckd' => ['Guido Gembillo'],
        'recidivujuce-uti-starsie-zeny-gsm' => ['Anne Lenore Ackerman', 'Melissa R. Kaufman'],
        'retatrutid-mimo-schvalenia-neregulovane-pouzivanie' => ['Marilynn Larkin'],
        'rodove-rozdiely-dialyza-transplantacia-era-usrds' => ['Vianda S Stel', 'Nicholas C Chesnaye', 'Rianne Boenink', 'Brittany A Boerstra', 'Megan E Astley', 'Shona Methven', 'Line Heylen', 'Halima Resic', 'Marc A G J ten Dam', 'Kristine Hommel', 'Marit D Solbu', 'Maria F Slon Roblero', 'Nuria Aresté-Fosalba', 'Danilo Radunovic', 'Héctor García López', 'Lukas Buchwinkler', 'Rebecca Guidotti', 'Mathilde Lassalle', 'Carmen Santiuste', 'Maria Stendahl', 'Olafur S Indridason', 'Almudena Escribá', 'María Encarnación Bouzas-Caamaño', 'Olga Lucía Rodriguez Arévalo', 'George Moustakas', 'Hermann Hernández Vargas', 'Alberto Ortiz', 'Anneke Kramer'],
        'roxadustat-esa-hyporesponzivita-opakovany-ciel-hb' => ['Mehmet Demir', 'Ilyas Ozturk', 'Merve Aktar', 'Cihan Heybeli', 'Can Huzmeli', 'Orhan Ozdemir', 'Seda Safak Ozturk', 'Tulin Akagun', 'Neriman Sila Koc', 'Mehmet Tuncay', 'Ekrem Kara', 'Tuncay Sahutoglu'],
        'semaglutid-ckd-porovnanie-glp1-realna-prax' => ['Joshua J Neumiller', 'Yihong Deng', 'Kavya Sindhu Swarna', 'Eric C Polley', 'Jeph Herrin', 'Rodolfo J Galindo', 'Guillermo E Umpierrez', 'Joseph S Ross', 'Mindy M Mickelson', 'Kate Dryden', 'Katherine R Tuttle', 'Rozalina G McCoy'],
        'spolupraca-vseobecny-lekar-nefrolog-ckd-g5-joint-kd' => ['Minoru Murakami', 'Takuya Aoki', 'Yoshifumi Sugiyama', 'Sho Sasaki', 'Hiroki Nishiwaki', 'Masahiko Yazawa', 'Yoshihiko Raita', 'Hiroo Kawarazaki', 'Hideaki Shimizu', 'Yoshihiro Nakamura', 'Yosuke Saka', 'Masato Matsushima'],
        'swam-technika-tromboza-hemodialyzacneho-pristupu' => ['Lin Li', 'Zhongwang Zhang', 'Hongjie Wang', 'Mingdi Zhu', 'Kun Wang', 'Zheng Liu'],
        'synteticke-wnt-organizatory-oblickove-organoidy' => ['Connor C. Fausto', 'Fokion Glykofrydis', 'Navneet Kumar', 'Jack Schnell', 'Reka L. Csipan', 'Faith De Kuyper', 'Minnal Kunnan', 'Brendan Grubbs', 'Matthew Thornton', 'Michael Thompson', 'Enmian Chang', 'Xuduo Wen', 'Manuel Pelayo', 'MaryAnne Achieng', 'Anoothi Seth', 'Kelly Street', 'Leonardo Morsut', 'Nils O. Lindström'],
        'styridsat-rokov-transplantat-oblicky-ultra-dlhodobe-prezivanie' => ['Michelle Madden', 'Gavin Comerford', 'Patrick O\'Kelly', 'Anne Cooney', 'Liam O\'Neill', 'Elhussein A E Elhassan', 'Alaeldin Abdalla', 'Carol Traynor', 'Peter J Conlon', 'Leonard Browne', 'Julio Chevarria', 'Mike Clarkson', 'David Keane', 'Sarah Cormican', 'Catherine Godson', 'Matt Griffin', 'Luke Harris', 'John Holian', 'Conor Judge', 'Mark Little', 'Liam Martin', 'Sarah Moran', 'Eithne Nic An Riogh', 'Conall O\'Seaghdha', 'Michelle O\'Shaughnessy', 'Liam Plant', 'Brendan Reddy', 'Colm Rowan', 'Jennifer Scott', 'Donal Sexton', 'Andrew Smyth', 'Oonagh Smith', 'Austin Stack', 'Sinead Stoneman', 'Vicki Sandys', 'Jia Wei Teh', 'Vladimir Stoyanov'],
        'taurolidin-relapsujuca-peritonitida-peritonealna-dialyza' => ['Jack Rycen', 'Sofia Santagada', 'Vikas Srivastava'],
        'telitacicept-iga-nefropatia-teligan-faza-3-interim' => ['Jicheng Lv', 'Lijun Liu', 'Wenxiang Wang', 'Xinyue Wang', 'Qing Zuraw', 'Vlado Perkovic', 'Jianmin Fang', 'Hong Zhang'],
        'terapie-cielene-na-b-bunky-imunitne-ochorenia-obliciek-kdigo' => ['Jürgen Floege', 'Isabelle Ayoub', 'Silke R. Brix', 'Kirk N. Campbell', 'Richard Furie', 'Patrick H. Nachman', 'Sydney C.W. Tang', 'Nicola M. Tomas', 'Marina Vivarelli', 'Michael Cheung', 'Jennifer M. King', 'Morgan E. Grams', 'Michel Jadoul', 'Brad H. Rovin'],
        'tirzepatid-oblickove-vysledky-surpass-nefrologia' => ['Stephen J. Nicholls'],
        'trpc6-inhibicia-fsgs-faza-2-precizna-nefrologia' => ['Luis Sanchez-Russo', 'George Vasquez-Rios', 'Kirk N. Campbell'],
        'ttv-biomarker-imunosupresia-transplantacia-oblicky' => ['Gregor Bond', 'Frederik Haupenthal', 'Felix Herkner', 'Sebastian Kapps', 'Konstantin Doberer', 'Jette Rahn', 'Carole Janis', 'Marta del Álamo', 'Georg Melzer-Venturi', 'Fabrizio Maggi', 'Hannes Neuwirt', 'Kathrin Eller', 'Daniel Cejka', 'Christian Hugo', 'Miriam Banas', 'Klemens Budde', 'Ondřej Viklický', 'Paolo Malvezzi', 'Sophie Caillard', 'Joris Rotmans', 'Jip Jonker', 'Isabel Beneyto', 'David Navarro', 'David Rodriguez-Arias', 'Heinz Regele', 'Matthias Vossen', 'Franz König'],
        'udrzatelna-peritonealna-dialyza-pacienti-zelena-nefrologia' => ['Filipa Trigo', 'João Bessa', 'Joana Tavares', 'Rita Alves', 'Maria João Carvalho', 'Hernâni Gonçalves', 'Paulo Santos', 'Anabela Rodrigues'],
        'umela-inteligencia-nefrologia-co-vieme-limity' => ['Prabhat Singh', 'Lokesh Goyal', 'Deobrat C Mallick', 'Salim R Surani', 'Nayanjyoti Kaushik', 'Deepak Chandramohan', 'Prathap K Simhadri'],
        'umela-inteligencia-sucha-hmotnost-hemodialyza' => ['Hae Ri Kim', 'Hong Jin Bae', 'Jae Wan Jeon', 'Young Rok Ham', 'Ki Ryang Na', 'Kang Wook Lee', 'Yun Kyong Hyon', 'Dae Eun Choi'],
        'vasopresin-nezavisla-cesta-regulacie-vody-adpkd' => ['Mohamad Hadla', 'Jean Marc Mardirossian', 'Daniel G. Bichet', 'Abdul Hamid Borghol', 'Georges Abboud', 'Ahmad Ghanem', 'Eduardo N. Chini', 'Peter C. Harris', 'Vicente E. Torres', 'Seth L. Alper', 'Volker Vallon', 'Fouad T. Chebib'],
        'victory-vitamin-c-tazke-popaleniny-nefrologicke-signaly' => ['Christian Stoppe', 'Aileen Hill', 'Leopoldo C. Cancio', 'Andrew G. Day', 'Kaitlin A. Pruskowski', 'Alexis F. Turgeon', 'Daren K. Heyland'],
    ];
}
