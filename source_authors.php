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
        '12-knih-lekar-choroba-pacient-narativna-medicina' => ['Ted Spiker'],
        '5-kritickych-chyb-manazment-ckm-syndromu-nefrologia' => ['Lisa O\'Mary'],
        'ai-nefrologia-hands-on-primer-klinicka-integracia' => ['Noppawit Aiumtrakul', 'Arjunmohan Mohan', 'Harshil A. Fichadiya', 'Wisit Cheungpasitporn'],
        'ai-scribe-pravne-nastrahy-ambulancia-nefrologia' => ['Ericka L. Adler'],
        'ambulantna-parenteralna-antimikrobialna-liecba-opat' => ['Ann L. Noble', 'Sanjay Patel', 'Ellie Birnie', 'Eileen Dorgan', 'Oyewole C. Durojaiye', 'Caroline Emilie', 'Achyut Guleri', 'Helen Green', 'Sara Hedderwick', 'Lucy Hinds', 'Monica V. Mahoney', 'Katie McIntyre', 'Fekade B. Sime', 'Owen Seddon', 'Julie Statham', 'Marie Woodley', 'Mark Gilchrist', 'R. Andrew Seaton'],
        'anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-checklist-a4-hd-nonhd' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-checklist-kdigo-2026-kdoqi' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-dialyza-ambulancia-checklist' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'anemia-ckd-kdigo-2026-kdoqi-komentar' => ['Diana I. Jalal', 'Nisha Bansal', 'Monique E. Cho', 'Steven Fishbane', 'Orlando M. Gutierrez', 'Csaba P. Kovesdy', 'Abhijit Kshirsagar', 'Bruce Spinowitz', 'Jay Wish'],
        'atacicept-trutakna-iga-nefropatia-fda-proteinuria' => ['Siddhi Mahatole', 'Puyaan Singh'],
        // Autori spracovanej práce J Nephrol 2026, doi 10.1093/joneph/aajag121 (PMID 42598914) -
        // 10 mien overených cez PubMed eutils a Crossref 2026-08-23.
        'anti-pla2r-trombozy-membranozna-nefropatia-hypoalbuminemia' => ['Ayman Al Jurdi', 'Christopher El Mouhayyar', 'Karim Yatim', 'Orhan Efe', 'Saif A. Muhsin', 'Leonardo V. Riella', 'Reza Zonozi', 'Karen Laliberte', 'John L. Niles', 'Anushya Jeyabalan'],
        'antimikrobialna-rezistencia-infekcie-mocovych-ciest-nefrologia' => ['Sibylle von Vietinghoff', 'Olga Shevchuk', 'Ulrich Dobrindt', 'Daniel Robert Engel', 'Selina K. Jorch', 'Christian Kurts', 'Thomas Miethke', 'Florian Wagenlehner'],
        'bartterov-syndrom-diagnostika-geneticke-formy-liecba' => ['Martin Konrad', 'Tom Nijenhuis', 'Gema Ariceta', 'Aurelia Bertholet-Thomas', 'Lorenzo A. Calò', 'Giovambattista Capasso', 'Francesco Emma', 'Karl P. Schlingmann', 'Mandeep Singh', 'Francesco Trepiccione', 'Stephen B. Walsh', 'Kirsty Whitton', 'Rosa Vargas-Poussou', 'Detlef Bockenhauer'],
        'betablokatory-ckd-bez-kardiovaskularneho-ochorenia' => ['Seung Hyun Han', 'Mina Kim', 'Jungkuk Lee', 'Sang Youb Han'],
        'c3-glomerulopatia-c3g-liecba-inhibicia-komplementu' => ['Manuel Praga', 'Richard J. Smith', 'Andrew S. Bomback'],
        // Autorky spracovanej štúdie J Ren Care 2026;52(3):e70075 (PMID 42522761) - presne dve,
        // overené cez PubMed eutils a Crossref 2026-08-23. Priezvisko druhej autorky je dvojslovné.
        'ckd-ap-pruritus-hemodialyza-prevalencia-meranie' => ['Gülay Turgay', 'Çiğdem Özdemir Eler'],
        'ckd-mozog-kognitivne-poruchy-cievne-poskodenie' => ['Mickaël Bobot'],
        'ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba' => ['Paola Fioretto', 'Peter Rossing', 'Hiddo J.L. Heerspink'],
        'ckd-samostatny-faktor-polyfarmacie' => ['Rafael Santamaria', 'Carlos Escobar', 'Ignacio Hernández', 'Beatriz Palacios', 'Unai Aranda', 'Roberto Alcázar'],
        // Autorstvo písacieho výboru usmernenia AHA/ACC/ADA/ASN 2026 (Circulation 2026;154(4):e50-e158,
        // PMID 42263157) — overené v Europe PMC 2026-08-05. Predchádzajúci zoznam obsahoval skomolené
        // krstné mená a šesť mien z iného dokumentu; opravené.
        'ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register' => ['Valeria Valente', 'Lina Benson', 'Carin Corovic Cabrera', 'Raffaele Scorza', 'Felix Lindberg', 'Ida Haugen Löfman', 'Michael Melin', 'Lars H. Lund', 'Giulia Ferrannini', 'Gianluigi Savarese'],
        'ckm-syndrom-stadia-skrining-liecba-usmernenie-2026' => ['Chiadi E. Ndumele', 'Fatima Rodriguez', 'Dave L. Dixon', 'Sadiya S. Khan', 'Debabrata Mukherjee', 'Mandeep Bajaj', 'Sripal Bangalore', 'Biykem Bozkurt', 'Khadijah Breathett', 'Shoa L. Clarke', 'Ian H. de Boer', 'David H. Ellison', 'Lorraine S. Evangelista', 'Sean P. Heffron', 'Dhruv S. Kazi', 'Ambar Kulshreshtha', 'Ildiko Lingvay', 'Cecilia C. Low Wang', 'Claudia A. Mercado', 'John Magaña Morton', 'Ian J. Neeland', 'Neha Pagidipati', 'Tiffany M. Powell-Wiley', 'Janani Rangaswami', 'Goutham Rao', 'Nosheen Reza', 'Anum Saeed', 'Wendy St Peter', 'J. Bradley Starks', 'Madeline Sterling', 'Amy W. Talbot', 'Andrew H. Tran', 'Katherine R. Tuttle', 'Lisa B. VanWagner', 'Amanda R. Vest', 'Salim S. Virani'],
        'ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia' => ['Chiadi E. Ndumele', 'Fatima Rodriguez', 'Dave L. Dixon', 'Sadiya S. Khan', 'Debabrata Mukherjee', 'Mandeep Bajaj', 'Sripal Bangalore', 'Biykem Bozkurt', 'Khadijah Breathett', 'Shoa L. Clarke', 'Ian H. de Boer', 'David H. Ellison', 'Lorraine S. Evangelista', 'Sean P. Heffron', 'Dhruv S. Kazi', 'Ambar Kulshreshtha', 'Ildiko Lingvay', 'Cecilia C. Low Wang', 'Claudia A. Mercado', 'John Magaña Morton', 'Ian J. Neeland', 'Neha Pagidipati', 'Tiffany M. Powell-Wiley', 'Janani Rangaswami', 'Goutham Rao', 'Nosheen Reza', 'Anum Saeed', 'Wendy St Peter', 'J. Bradley Starks', 'Madeline Sterling', 'Amy W. Talbot', 'Andrew H. Tran', 'Katherine R. Tuttle', 'Lisa B. VanWagner', 'Amanda R. Vest', 'Salim S. Virani'],
        'cystatin-c-kreatinin-egfr-biomarkery-reumatoidna-artritida' => ['Sho Fukui', 'Lesley A. Inker', 'Leah M. Santacroce', 'Jon T. Giles', 'Katherine P. Liao', 'Joan M. Bathon', 'Daniel H. Solomon'],
        // Menovaní autori štúdie MERCURI-2 (JAMA 2026, doi 10.1001/jama.2026.9268, PMID 42530910) —
        // overené cez PubMed eutils 2026-08-19. Skupinové spoluautorstvo „MERCURI-2 Study Group“
        // nie je v bibliografickom zázname rozvinuté, preto sa jednotliví členovia neuvádzajú.
        'dapagliflozin-kardiochirurgia-aki-mercuri-2' => ['Maartina J. P. Oosterom-Eijmael', 'Abraham H. Hulst', 'Nelson P. Monteiro de Oliveira', 'Ed D. Niesten', 'Nicobert E. Wietsma', 'Bastiaan M. Gerritse', 'Thierry V. Scohy', 'Thijs C. D. Rettig', 'Ferdinand T. F. Snellen', 'Magiel F. Voogd', 'Marc B. Godfried', 'Rients N. de Boer', 'Jeroen Wink', 'Lisa M. M. van der Werff', 'Christa M. Cobbaert', 'L. Renee Ruhaak', 'Susanne Eberl', 'Benedikt Preckel', 'Markus W. Hollmann', 'Jimmy Schenk', 'Jeroen Hermanides', 'Daniel H. van Raalte'],
        'dennik-semafor-objemovy-manazment-hemodialyza-rct' => ['Amin Li', 'Di Zhang', 'Liheng Zhou', 'Wenwen Lu'],
        'dialyzacny-dysekvilibracny-syndrom-zaciatok-hemodialyzy' => ['Théo Servan-Schreiber', 'Guillaume Lano', 'Matthieu Giot', 'Océane Jehel', 'Marion Pelletier', 'Marion Sallée', 'Philippe Brunet', 'Stéphane Burtey', 'Thomas Robert'],
        'domaca-hemodialyza-kdigo-vychodna-azia-ramec-rozvoja' => ['Ikuto Masakane', 'Paul N. Bennett', 'Chia-Ter Chao', 'Michael Cheung', 'Tsutomu Furuzono', 'Masaki Hara', 'Yung-Ho Hsu', 'Chiu-Ching Huang', 'Sayaka Ishigaki', 'Michel Jadoul', 'Eunjeong Kang', 'Seong Geun Kim', 'Kenichi Kokubo', 'Hirotaka Komaba', 'Huey-Liang Kuo', 'Ki Jeong Kwon', 'Vickie Kwong', 'Wai-Yan Lau', 'Titus Lau', 'Dong Hyung Lee', 'Philip Kam-Tao Li', 'Mark Marshall', 'Sandip Mitra', 'Kojiro Nagai', 'Tomonari Ogawa', 'Hyeong Cheon Park', 'Clara Poon', 'Naoko Tsuji', 'Joseph Wong', 'Po Kwan Wong', 'Sunny Wong', 'Hung-Lai Wu', 'Mei-Yi Wu', 'Kyung Don Yoo', 'Christopher T. Chan'],
        'dress-alopurinol-granulomatozna-ain-pankreatitida' => ['Said Al Zein'],
        'dyslipidemia-ckd-acc-aha-2026-nefrologicka-prax' => ['Amaryllis H Van Craenenbroeck', 'Patrick B Mark', 'Jose M Valdivielso', 'EuReCa-m Working Group of the European Renal Association'],
        'egfr-diabetes-ekfc-ckd-epi-stadia-ckd' => ['YuXia Zi', 'WenXing Fan'],
        'ema-zrusenie-povolenia-tavneos-avacopan-anca-vaskulitida' => ['Rob Hicks'],
        'environmentalne-toxiny-poskodenie-obliciek-nefrolog' => ['Anna Strasma', 'Nishad Jayasundara', 'Shuchi Anand'],
        'estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa' => ['Matthew M. Churpek', 'Aiman Fatima', 'Olasunkanmi Anjorin', 'Ananya Saravanan', 'Benjamin S. Ko', 'Samantha Gunning', 'Megan L. Prochaska', 'Tipu S. Puri', 'Anna L. Zisman', 'Dana P. Edelson', 'Mihai C. Giurcanu', 'Jay L. Koyner'],
        'extremne-horucavy-riziko-ckd-dialyza' => ['Roberta Villa'],
        'farmakologicka-liecba-obezity-pokrocile-ckd-dialyza' => ['Pooja Budhiraja', 'Babak J. Orandi'],
        'finerenon-ckm-syndrom-dm2-ckd-fidelity' => ['Kevin Bryan Lo', 'John W Ostrominski', 'Yasuhiro Hamatani', 'Brian L Claggett', 'Rajiv Agarwal', 'Stefan D Anker', 'Gerasimos Filippatos', 'Peter Rossing', 'Luis M Ruilope', 'Bertram Pitt', 'Alexandros Briasoulis', 'Kimon Stamatelopoulos', 'Meike Brinker', 'Patrick Schloemer', 'Andrea Glasauer', 'Scott D Solomon', 'Muthiah Vaduganathan'],
        'finerenon-zakladna-liecba-ckd-glomerularne-ochorenia' => ['Brendon L. Neuen', 'Hiddo J.L. Heerspink', 'Vlado Perkovic'],
        'frailty-ckd-vyziva-pohyb-stisk-ruky' => ['Fang-Ru Yueh', 'Dongjuan Xu', 'Huan-Fang Lee', 'Junne-Ming Sung', 'Miaofen Yen'],
        'geneticke-prediktory-glp1-semaglutid-tirzepatid' => ['Qiaojuan Jane Su', 'James R. Ashenhurst', 'Wanwan Xu', 'Vinh Tran', 'R. Ryanne Wu', 'Catherine H. Weldon', 'Jingchunzi Shi', 'Barry Hicks', 'Noura S. Abul-Husn', 'Stella Aslibekyan', 'Michael V. Holmes', 'Bertram L. Koelsch', 'Adam Auton'],
        'genotypizacia-apol1-zivy-darca-oblicky' => ['Chi-Yuan Hsu', 'Ying Gao', 'Barry I Freedman', 'Mitchell R Lunn', 'Anthony N Muiru', 'Mark A Schnitzler', 'Jasmin Divers', 'Roslyn B Mannon', 'Nicholette D Palmer', 'Amy B Karger', 'Krista L Lentine', 'Meyeon Park'],
        'glp1-era-novy-model-starostlivosti-o-obezitu-nefrologia' => ['Manuela Callari'],
        'glp1-lieky-renalne-benefity-dokazy-prax-nefrologia' => ['Kashif J. Piracha'],
        'glp1-kompulzivne-spravanie-food-noise-nefrologia' => ['Eric Spitznagel'],
        // Autorka spracovaného článku Medscape Medical News „Weight Down, Steps Down: The GLP-1 Catch“
        // (2026); byline overená vo verejnej tiráži 2026-09-03. Nie sú to autori citovaných štúdií
        // (Maharjan/ENDO 2026, Chae et al., Lieberman/JAMA Perspective).
        'glp1-pokles-krokov-fyzicka-aktivita-nefro-kardiometabolicka-prax' => ['Nancy A. Melville'],
        // Autori spracovanej práce Kidney Medicine 2026, doi 10.1016/j.xkme.2026.101476
        // (article 101476, PII S2590-0595(26)00238-4). Sedem mien overených cez Crossref
        // a sekciu Authors’ Full Names v otvorenom plnom texte 2026-09-03. PMID v PubMed
        // k tomuto dátumu ešte nebolo pridelené (journal pre-proof). Medscape (Javed Choudhury)
        // nie je spracovaný zdroj.
        'glp1-zapal-anemia-hemodialyza-real-world-evidencia' => ['Suman Lama', 'Sheetal Chaudhuri', 'Derek Blankenship', 'Andrea Nandorine Ban', 'Len Usvyat', 'Roberto Pecoits-Filho', 'Benjamin E. Hippen'],
        'hypertenzia-v-tehotenstve-a-po-porode-nefrologicka-rola' => ['Line Malha', 'Phyllis August'],
        // Autori spracovanej práce J Nephrol 2026, doi 10.1093/joneph/aajag149 (PMID 42599085) -
        // 16 mien overených cez PubMed eutils a Crossref 2026-08-23.
        'hyperkaliemia-ckd-realna-prax-recidiva-raasi' => ['María Marques', 'Paula López-Sánchez', 'Enrique Morales', 'M. Auxiliadora Bajo', 'Antolina Rodriguez', 'Milagros Fernández Lucas', 'Vicente Paraiso', 'Laura Bucalo', 'Yolanda Hernandez', 'José C. De La Flor', 'Maite Padrón', 'Hanane Bouarich', 'Fabio Procaccini', 'Coraima Nava Chavez', 'Jose Herrero', 'Fernando Tornero'],
        // Autori primárnej štúdie SYMPHONY-2 (NEJM Evidence 2026;5(7):EVIDoa2500317,
        // PMID 42251702) - 17 mien, AuthorList CompleteYN=Y, overené cez PubMed eutils
        // a Crossref 2026-09-05. Autori doplnkových citácií sa nepridávajú.
        'htd1801-berberin-ursodeoxycholat-diabetes-2-typu' => ['Linong Ji', 'Zhifeng Cheng', 'Jianhua Ma', 'Dexue Liu', 'Xin Zhang', 'Xiaolin Dong', 'Yang Lin', 'Mingming Yang', 'Shenglian Gan', 'Hanqing Cai', 'Xiaomei Wang', 'Yan Liu', 'Xiaoguang Shi', 'Kui Liu', 'Leigh MacConell', 'Meng Yu', 'Liping Liu'],
        'iga-nefropatia-algoritmus-kdigo-2025-kdoqi' => ['Isabelle Ayoub', 'Gaia Coppock', 'Shikha Wadhwani', 'Timothy Yau'],
        'implementacia-intenzivnej-kontroly-tlaku-esprit-nefrologia' => ['Yu-Jie Zuo', 'Ji-Guang Wang'],
        'inhibicia-tmao-fmc-regresia-fibrozy-ckd-model' => ['Joseph A DiDonato', 'Taylor L Weeks', 'Nilaksh Gupta', 'Deepthi P Mallela', 'Jennifer A Buffa', 'Zeneng Wang', 'Xinmin S Li', 'James T Anderson', 'Xiaoming Fu', 'Naseer Sangwan', 'Ina Nemet', 'Scott J Cameron', 'Stanley L Hazen'],
        // Autori spracovanej práce JAMA Dermatol. 2026, doi 10.1001/jamadermatol.2026.2853
        // (PMID 42584887) — 22 mien, AuthorList CompleteYN=Y, overené cez PubMed eutils 2026-09-03.
        'inhibitor-jak1-upadacitinib-tazka-alopecia-areata-faza-3' => ['Arash Mostaghimi', 'Melinda J. Gooderham', 'Charles Lynde', 'Rodney Sinclair', 'Brett King', 'Maria Hordinsky', 'Lidia Rudnicka', 'Emma Guttman-Yassky', 'Rocco Serrao', 'Manabu Ohyama', 'Xingqi Zhang', 'Nina Magnolo', 'Ohsang Kwon', 'Cristina Oddi', 'Sebastian Meerwein', 'Ahmed M. Soliman', 'Xianwei Bu', 'Chenyang Duan', 'Tianshuang Wu', 'Henrique D. Teixeira', 'Andreas Lazar', 'Thierry Passeron'],
        'iga-nefropatia-kdigo-2025-kdoqi' => ['Isabelle Ayoub', 'Gaia Coppock', 'Shikha Wadhwani', 'Timothy Yau'],
        // Autori spracovanej práce JACC 2026, doi 10.1016/j.jacc.2026.07.014
        // (PMID 42584385, NCT06021613) — 13 mien, AuthorList CompleteYN=Y,
        // overené cez PubMed eutils a Crossref 2026-09-03. Nie sú to novinári Medscape.
        'kanabis-inhalacia-kardialna-ektopia-randomizovana-crossover' => ['Adi Elias', 'Gabrielle C. Montenegro', 'Hannah H. Oo', 'Isabella J. Peña', 'Dylan A. Lowe', 'Catherine Lee', 'Janet Tang', 'Kara L. Lynch', 'Lilly Lim', 'Mirna Maamou', 'Nhung Nguyen', 'Matthew L. Springer', 'Gregory M. Marcus'],
        'ked-sa-citime-chori-co-medicina-prehliada-nefrologia' => ['Arya Anthony Kamyab'],
        'kedy-zacat-krt-pri-aki' => ['Marlies Ostermann', 'Sean M Bagshaw', 'Nuttha Lumlertgul', 'Ron Wald'],
        // Autori spracovanej práce Clin Gastroenterol Hepatol 2026, doi 10.1016/j.cgh.2026.04.035
        // (PMID 42385787) — 23 mien overených cez PubMed 2026-08-28.
        'kava-pecen-cirhoza-hcc-uk-biobank-nefrologia' => ['Hyun-Seok Kim', 'Mohammad Saeid Rezaee-Zavareh', 'Yufeng Wang', 'Abdelrahman M. Attia', 'Minsun Kwak', 'Seungwon Burm', 'Derin Celtik', 'Daniel Legaspi', 'Osama Khattab', 'Naomy Kim', 'Beza M. Mengistu', 'Kelsey N. Larios', 'David Sooik Kim', 'Walid Ayoub', 'Alexandar Kuo', 'Paul Martin', 'Aarshi Vipani', 'Yun Wang', 'Suthat Liangpunsakul', 'Debiao Li', 'Shelly C. Lu', 'Stephen Pandol', 'Ju Dong Yang'],
        'ketoacidoza-nefrologicka-prax-hladovanie-euglykemicka-dka' => ['Biff F. Palmer', 'Deborah J. Clegg'],
        // Autori spracovanej meta-analýzy Lancet Public Health 2025;10(8):e668-e681
        // (PMID 40713949, doi 10.1016/S2468-2667(25)00164-1) — 20 mien overených cez PubMed eutils 2026-09-03.
        'kolko-krokov-denne-staci-davkovo-odpovedova-analyza-nefrologia' => ['Ding Ding', 'Binh Nguyen', 'Tracy Nau', 'Mengyun Luo', 'Borja Del Pozo Cruz', 'Paddy C. Dempsey', 'Zachary Munn', 'Barbara J. Jefferis', 'Cathie Sherrington', 'Elizabeth A. Calleja', 'Kar Hau Chong', 'Rochelle Davis', 'Monique E. Francois', 'Anne Tiedemann', 'Stuart J. H. Biddle', 'Anthony Okely', 'Adrian Bauman', 'Ulf Ekelund', 'Philip Clare', 'Katherine Owen'],
        'kreatin-ochorenia-obliciek-bezpecnost-benefit' => ['Juliana Paula Pereira', 'Viviane O Leal', 'Pricilla Trigueira', 'Natália A Borges', 'Ludmila F M F Cardozo', 'Denise Mafra'],
        'kreatin-zdravie-mozgu' => ['Heidi Moawad'],
        'krvna-skupina-a-mortalita-hemodialyza' => ['Masafumi Kurajoh', 'Tetsuo Shoji', 'Shinya Nakatani', 'Yuki Nagata', 'Hisako Fujii', 'Yasuo Imanishi', 'Masanori Emoto', 'Tomoaki Morioka'],
        'krce-kostroveho-svalstva-dialyza-prevalencia-metaanalyza' => ['Seda Babroudi', 'Marcelle Tuttle', 'Eduardo K. Lacson Jr.'],
        'kvalitativny-vyskum-nefrologia-rozhodovanie-pacientov-ckd' => ['Lisa O\'Mary'],
        'lekari-cas-autonomia-vyhorenie-pracovne-podmienky' => ['Jennifer Nelson'],
        'liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki' => ['Pranav Garimella', 'Marc Richards', 'Matthew Breeggemann'],
        // Medscape správa ICO 2026 (verejný byline Astrid Rivera) + kompletné autorstvo
        // US Standard of Care (Herbst et al., Phlebology 2021, PMID 34049453, PMC8652358) —
        // 21 mien overených cez PubMed eutils, PMC a Crossref 2026-09-03; klinický rámec
        // článku sa oň opiera. Autori pacientskych stránok Cleveland Clinic sa neuvádzajú.
        'lipedem-multidisciplinarny-manazment-chirurgia' => ['Astrid Rivera', 'Karen L Herbst', 'Linda Anne Kahn', 'Emily Iker', 'Chuck Ehrlich', 'Thomas Wright', 'Lindy McHutchison', 'Jaime Schwartz', 'Molly Sleigh', 'Paula MC Donahue', 'Kathleen H Lisson', 'Tami Faris', 'Janis Miller', 'Erik Lontok', 'Michael S Schwartz', 'Steven M Dean', 'John R Bartholomew', 'Polly Armour', 'Margarita Correa-Perez', 'Nicholas Pennings', 'Edely L Wallace', 'Ethan Larson'],
        'lipoprotein-a-kardiovaskularne-riziko-primarna-starostlivost' => ['Rajdeep Dhami'],
        // Autor spracovaného komentára Medscape „Lithium: 7 Myths That May Be Keeping It Underused“
        // (28. 8. 2026); byline Nassir Ghaemi overený vo verejnej tiráži 2026-09-03.
        // Nie sú to autori citovaných štúdií (BALANCE, Shine, Aiff, Gomes-da-Costa).
        'litium-sedem-mytov-nefrologicka-perspektiva' => ['Nassir Ghaemi'],
        'lokalny-finasterid-muzska-androgenova-alopecia' => ['Giuseppe Gallo', 'Luca Mastorino', 'Pietro Quaglino', 'Simone Ribero'],
        'malignity-transplantacia-oblicky-skrining-ptld' => ['Christopher D. Blosser', 'Elena-Bianca Barbir', 'Salma Shaikhouni', 'Naoka Murakami'],
        'meduza-hojenie-ran-bez-jaziev-regenerativna-medicina' => ['Jocelyn E. Malamy', 'Maxwell Sassaman', 'Manjula P. Mony'],
        'monoklonalna-gamapatia-klinickeho-vyznamu-mgcs-mimo-mgrs' => ['Patrick Hofmann', 'Sujal I. Shah', 'Helmut G. Rennke', 'Rahel Schwotzer', 'David B. Sykes', 'Nelson Leung', 'Raad B. Chowdhury'],
        'moderne-trendy-v-nefroprotekcii' => ['Hiddo J.L. Heerspink', 'Bergur V. Stefánsson', 'Ricardo Correa-Rotter', 'Glenn M. Chertow', 'Tom Greene', 'Fan-Fan Hou', 'Johannes F.E. Mann', 'John J.V. McMurray', 'Magnus Lindberg', 'Peter Rossing', 'C. David Sjöström', 'Roberto D. Toto', 'Anna-Maria Langkilde', 'David C. Wheeler'],
        'nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou' => ['Jooyeon Yoon', 'Kyungjun Shon', 'Hayne Cho Park', 'Sua Lee', 'Young-Ki Lee', 'Hyungseok Lee', 'Eun Jung Kim', 'Hoon Suk Park', 'Min-Ho Kim', 'Do Hyoung Kim'],
        'nediabeticka-ckd-nehemodynamicke-mechanizmy-nsmra-finerenon' => ['Brendon L. Neuen', 'Beatriz Fernandez-Fernandez'],
        'nekontrolovana-rezistentna-hypertenzia-aldosteronova-os' => ['Pam R. Taub', 'Alta Schutte', 'Krzysztof Narkiewicz', 'Reinhold Kreutz'],
        'neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt' => ['Noriaki Kurita', 'Jun Miyashita', 'Mayumi Nishimura', 'Hiroo Kawarazaki', 'Tadashi Sofue', 'Tatsunori Toida', 'Kosuke Inoue', 'Hiroshi Kado', 'Susumu Toda', 'Hiroki Nishiwaki', 'Seita Sugitani', 'Izaya Nakaya', 'Yosuke Yamada', 'Makoto Yamamoto', 'Shigeru Shibata', 'Atsuhiro Maeda', 'Hideaki Oka', 'Tomoya Nishino', 'Tomo Suzuki', 'Daisuke Komukai', 'Masahide Furusho', 'Ryohei Inanaga', 'Keiko Nishi', 'Yasuhiro Taki', 'Hideki Shimizu', 'Shohei Yamada', 'Kenichiro Asano', 'Hitoshi Miyasato', 'Minoru Murakami', 'Takaaki Tsutsui', 'Takayuki Nakamura', 'Takayuki Adachi', 'Hiroaki Asada', 'Keita Uehara', 'Tatsuo Tsukamoto', 'Ryo Zamami', 'Yoshihiko Raita', 'Ken-Ichi Miyoshi', 'Takeshi Okamoto', 'Takafumi Ito', 'Hiroyuki Terawaki', 'Chisato Fukuhara', 'Mari Yamamoto', 'Tsukasa Naganuma', 'Kei Nagai', 'Kojiro Nagai', 'Kiichiro Fujisaki', 'Yukihiro Tamura', 'Hideaki Shimizu', 'Shuma Hirashio', 'Shohei Nakanishi', 'Satoshi Furukata', 'Nobuyuki Nakano', 'Yugo Shibagaki'],
        'neuroimunitna-architektura-uremickeho-pruritu-ckd-ap' => ['Lucas Maciel de Almeida Corrêa', 'Letícia Esteves Dante', 'Laura de Azevedo Catenaccio', 'Thifanny Rodrigues de Oliveira', 'Beatriz Cossini Bonavita Martins', 'Luiggi Kevin Virgino Brandão', 'Alexandre de Assis Barbosa', 'Gabriel Costa de Santana'],
        'nova-ada-vyskumne-granty-politicky-zasah-dopad-na-nefrologiu' => ['Irl B. Hirsch'],
        'obezita-nakladova-diagnoza-glp1-pristup-nefrologia' => ['Amy Faith Ho'],
        'obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia' => ['Holly J. Kramer', 'Linda-Marie Lavenburg', 'Sankar D. Navaneethan'],
        'oblicka-v-centre-ckm-syndromu-kdigo' => ['Adeera Levin', 'Nisha Bansal', 'Ian H de Boer', 'Morgan E Grams', 'Michel Jadoul', 'Jozine M Ter Maaten', 'Reem A Mustafa', 'Peter Rossing', 'Michael Cheung', 'Jennifer M King', 'Amy Earley', 'Paul E Stevens'],
        'occam-hickam-diagnosticke-uvazovanie-nefrologia' => ['Allegra Ferrara', 'Lucy Mason', 'Peter Ruberto', 'Keegan D\'Mello', 'Amrit Kirpalani'],
        'ochorenie-obliciek-tehotenstvo-multidisciplinarna-starostlivost' => ['Manal E Alotaibi', 'Ghada Ankawi'],
        'ockovanie-ckd-transplantacia-oblicky-vakciny-nacasovanie' => ['Matthias Girndt'],
        'online-hemodiafiltracia-mco-dialyzatory-stredne-molekuly' => ['Karin Bergling', 'Peter J. Blankestijn'],
        'paliativna-starostlivost-nefrologia-krehki-starsi-eskd' => ['Judith Böhm', 'Martin Windpessl', 'Matthias Huemer', 'Eva K. Masel', 'Marcus Säemann', 'Andreas Kronbichler', 'Balazs Odler'],
        // Autor spracovaného prehľadového článku Postgraduální nefrologie 2026;24(2):3–8
        // (verejne dostupný na postgradualninefrologie.cz) — meno overené z titulnej stránky článku.
        'preemptivna-transplantacia-optimalny-sposob-nahrady-funkcie-ledvin' => ['Tomáš Reischig'],
        // Autor spracovaného Medscape článku Five Steps to Earlier Heart Failure Detection;
        // meno je verejne uvedené na stránke (overené 2026-09-03). Nie sú to autori ESC task force.
        'pat-krokov-vcasne-odhalenie-srdcoveho-zlyhavania-ps' => ['Michael van den Heuvel'],
        'pentoxifylin-diabeticka-choroba-obliciek-mini-review' => ['David J. Leehey', 'Rajiv Agarwal'],
        'perzistujuca-hyperparatyreoza-po-transplantacii-oblicky' => ['Daniele Vetrano', 'Simona Barbuto', 'Francesco Aguanno', 'Paolo Mastromauro', 'Valeria Grandinetti', 'Giorgia Comai', 'Gaetano La Manna', 'Giuseppe Cianciolo'],
        'perzistujuca-mikroskopicka-hematuria-podocytopatie-prognoza' => ['Gabriel Ștefan', 'Nicoleta Petre', 'Adrian Zugravu', 'Simona Stancu'],
        'pohybova-aktivita-fibrilacia-predsieni-cmp-mortalita' => ['Kristoffer Robin Johansen', 'Bjarne Martens Nes', 'Vegard Malmo', 'Marius Myrstad', 'Dag S Thelle', 'Kim Arne Heitmann', 'Ellisiv Bøgeberg Mathiesen', 'Anne Elise Eggen', 'Tom Wilsgaard', 'Maja-Lisa Løchen', 'Bente Morseth', 'Norwegian Exercise and Atrial Fibrillation Initiative Investigators'],
        'prader-willi-syndrom-genetika-hyperfagia-starostlivost' => ['Jessica Duis', 'Ashley Shoemaker', 'Anthony P. Goldstone'],
        'predialyzacna-edukacia-volba-peritonealnej-dialyzy' => ['Magdalena Mosakowska', 'Ewelina Jędrych', 'Ewa Kotwica-Strzałek', 'Agnieszka Dorywalska', 'Arkadiusz Lubas', 'Stanisław Niemczyk'],
        'predikcia-vhodnosti-peritonealnej-dialyzy-validacia' => ['Emre Cankaya', 'Yang Yang', 'Helen H. Chen', 'Robert R. Quinn', 'Joel A. Dubin', 'Matthew J. Oliver'],
        'prehlad-vyskum-fsgs-diabeticka-nefropatia-2025-2026' => ['Howard Trachtman', 'Sean Eddy', 'Matthias Kretzler'],
        'primarna-alebo-latkou-vyvolana-psychoza-diagnostika' => ['Adjoa Smalls-Mantey'],
        'protein-kreatin-uz-nie-su-len-fitness-tema-nefrologia' => ['Lou Schuler'],
        'prukaloprid-brain-fog-depresia-kognicia-nefrologia' => ['Pauline Anderson'],
        'rastlinna-strava-nizsia-mortalita-ckd' => ['Guido Gembillo'],
        'recidivujuce-uti-starsie-zeny-gsm' => ['Anne Lenore Ackerman', 'Melissa R. Kaufman'],
        'regulacne-t-lymfocyty-transplantacia-oblicky-tolerancia' => ['Jeffrey A. Bluestone', 'Megan K. Levings', 'Frederick J. Ramsdell', 'Alexander Y. Rudensky', 'Qizhi Tang', 'Piotr Trzonkowski', 'Fadi Issa', 'Kathryn Wood'],
        'renalna-funkcna-rezerva-normalny-egfr-poskodenie-obliciek' => ['Jai Radhakrishnan', 'Leal C. Herlitz'],
        'renalne-riziko-po-preeklampsii-detekcia-albuminuria' => ['Shiuan-Chih Chen', 'Ming-Cheng Lin', 'Jennifer H. Yo', 'Anna Sara Oberg', 'Juan-Jesús Carrero'],
        // Autori zdruzenej analyzy SPRINT MIND + ACCORD MIND (Neurology 2026;107(3):e218302,
        // doi 10.1212/WNL.0000000000218302, PMID 42430676) - overene cez PubMed a Crossref 2026-08-19.
        // Autori spracovanej štúdie PLOS One 2026;21(7):e0347975 (PMID 42490553) - 10 mien
        // overených z otvoreného plného textu, PubMed eutils a Crossref 2026-08-23.
        'urinarny-podocalyxin-diabeticka-nefropatia-biomarker' => ['Md. Sabbir Hossain', 'Shamsia Tasnim Dwipi', 'Nazma Ahmed', 'Khaled Mahbub Murshed', 'Kazi Ali Aftab', 'Abdullah Al Mahdi', 'Md. Mojibul Hoque', 'Md. Jobayer Hossain Taraq', 'Md. Zakir Hussain', 'Md. Abul Kalam Azad'],
        'variabilita-tlaku-lezie-bielej-hmoty-sprint-accord' => ['Wenbo Zhao', 'Yue Qiao', 'Zihan Sun', 'Eric L. Harshfield', 'Lupei Cai', 'Xunming Ji', 'Hugh S. Markus'],
        // Autori studie AL-DON (Kidney360, publikovane online 3.8.2026, doi 10.34067/KID.0000001313,
        // PMID 42545761) - overene cez PubMed eutils a Crossref 2026-08-19.
        // Autori spracovaného editoriálu Braz J Nephrol 2026;48(3):e2026E011 (PMID 42599773) -
        // overené cez PubMed eutils a Crossref 2026-08-23.
        'alopurinol-ckd-asymptomaticka-hyperurikemia-dokazy' => ['Ana Beatriz Vargas-Santos', 'Rosa Weiss Telles', 'Geraldo da Rocha Castelar-Pinheiro'],
        'alopurinol-zivi-darcovia-oblicky-lvm-al-don' => ['Nina Elisabeth Langberg', 'Trond Geir Jenssen', 'Einar Hopp', 'Anders Haugen', 'Anders Åsberg', 'Kåre I. Birkeland', 'Anders Hartmann', 'Dag Olav Dahle'],
        // Autori studie o zavaznosti CKD a vysledkoch na JIS (JAMA Netw Open 2026;9(6):e2620192,
        // doi 10.1001/jamanetworkopen.2026.20192, PMID 42348209) - overene cez PubMed eutils 2026-08-19.
        // Prva autorka je Hajar El Wadia, Gregory L. Hundemer je poslednym (seniornym) autorom.
        'zavaznost-ckd-prognoza-jis-populacna-studia' => ['Hajar El Wadia', 'Nickolas Beauregard', 'Samuel A. Silver', 'Ron Wald', 'Ayub Akbari', 'Deena Fremont', 'Tim Ramsay', 'Gregory A. Knoll', 'Edward G. Clark', 'Gregory L. Hundemer'],
        // Autori studie CREATION (JAMA Netw Open 2026;9(8):e2627376, doi 10.1001/jamanetworkopen.2026.27376,
        // PMID 42560674) - overene cez PubMed eutils 2026-08-19. Skupinovy autor CREATION group
        // nie je v zazname rozvinuty na jednotlivych spolupracovnikov.
        'role-play-vzdelavanie-lekarov-diabetes-creation' => ['Yifei Zhang', 'Ying Peng', 'Yufei Chen', 'Tingyu Ke', 'Fengmei Xu', 'Shengli Wu', 'Yuancheng Dai', 'Lin Sun', 'Qidong Zheng', 'Zhuomeng Hu', 'Qijuan Dong', 'Juan Shi', 'Xueyi Wu', 'Yu Shi', 'Rong Tang', 'Yubo Sha', 'Rongyue Chen', 'Bin Xu', 'Shu Li', 'Lianyong Liu', 'Mingdian Gao', 'Dong Zhao', 'Qinghua Yi', 'Zhiqiang Kang', 'Weiqing Wang'],
        // Autorka spracovaného komentára Medscape Gastroenterology (19. 8. 2026) —
        // Caroline Messer, MD; meno z verejnej sekcie Authors and Disclosures
        // (citácia „Messer C.“), nie obchádzaním paywallu. Autori štúdií o
        // účinnosti retatrutidu sa neuvádzajú — článok spracúva procesný komentár.
        'retatrutid-expanded-access-lekar-pacient-bariery' => ['Caroline Messer'],
        'retatrutid-mimo-schvalenia-neregulovane-pouzivanie' => ['Marilynn Larkin'],
        // Autori spracovaného preprintu nference / Preprints.org (doi 10.20944/preprints202608.1193.v1,
        // posted 18. 8. 2026) — 3 mená overené v PDF, na stránke nference a v Crossref 2026-09-03.
        // Novinárka Medscape (Marilynn Larkin) ani Endpoints News sa neuvádzajú: spracovaný zdroj
        // je RWE analýza, nie spravodajský text.
        'retatrutid-sivy-trh-chudnutie-kardiovaskularne-symptomy' => ['Karthik Murugadoss', 'A. J. Venkatakrishnan', 'Venky Soundararajan'],
        // Autori studie TRANSCEND-T2D-1 (Lancet 2026;407(10546):2402-2413, doi 10.1016/S0140-6736(26)00967-0,
        // PMID 42250575) - overene cez PubMed eutils 2026-08-19.
        'retatrutid-transcend-t2d-1-hba1c-hmotnost-nefrologia' => ['Harpreet S. Bajaj', 'Michelle Welch', 'Parag Shah', 'Eduardo Luna', 'Fatima-Zahra Jaouimaa', 'Bing Liu', 'Rong Liu', 'Yanyun Chen', 'Hiren Patel', 'Amy Bartee'],
        'rodove-rozdiely-dialyza-transplantacia-era-usrds' => ['Vianda S Stel', 'Nicholas C Chesnaye', 'Rianne Boenink', 'Brittany A Boerstra', 'Megan E Astley', 'Shona Methven', 'Line Heylen', 'Halima Resic', 'Marc A G J ten Dam', 'Kristine Hommel', 'Marit D Solbu', 'Maria F Slon Roblero', 'Nuria Aresté-Fosalba', 'Danilo Radunovic', 'Héctor García López', 'Lukas Buchwinkler', 'Rebecca Guidotti', 'Mathilde Lassalle', 'Carmen Santiuste', 'Maria Stendahl', 'Olafur S Indridason', 'Almudena Escribá', 'María Encarnación Bouzas-Caamaño', 'Olga Lucía Rodriguez Arévalo', 'George Moustakas', 'Hermann Hernández Vargas', 'Alberto Ortiz', 'Anneke Kramer'],
        'roxadustat-esa-hyporesponzivita-opakovany-ciel-hb' => ['Mehmet Demir', 'Ilyas Ozturk', 'Merve Aktar', 'Cihan Heybeli', 'Can Huzmeli', 'Orhan Ozdemir', 'Seda Safak Ozturk', 'Tulin Akagun', 'Neriman Sila Koc', 'Mehmet Tuncay', 'Ekrem Kara', 'Tuncay Sahutoglu'],
        // Autori spracovanej prierezovej štúdie Neurogastroenterol Motil 2026;38(5):e70335
        // (PMID 42087489, doi 10.1111/nmo.70335) — 7 mien, AuthorList CompleteYN=Y,
        // overené cez PubMed eutils a Crossref 2026-09-03. Nie sú to autori Rome V.
        'rome-kriteria-ibs-dgbi-dalsie-testovanie-medici' => ['Manuel Linares', 'Catalina Grimaldi', 'Natalia Palma', 'Bryan Vintimilla', 'Sofia Candal', 'David Estrella', 'Miguel Saps'],
        // Menovaní diskutujúci spracovanej Medscape aktivity (ADA 2026); nejde o autorov
        // primárnych štúdií citovaných v článku.
        'sekvencna-simultanna-kombinovana-liecba-diabetes-ckd' => ['Ian de Boer', 'Amy Mottl'],
        'semaglutid-ckd-porovnanie-glp1-realna-prax' => ['Joshua J Neumiller', 'Yihong Deng', 'Kavya Sindhu Swarna', 'Eric C Polley', 'Jeph Herrin', 'Rodolfo J Galindo', 'Guillermo E Umpierrez', 'Joseph S Ross', 'Mindy M Mickelson', 'Kate Dryden', 'Katherine R Tuttle', 'Rozalina G McCoy'],
        'semaglutid-wernickeho-encefalopatia-deficit-tiaminu' => ['Janice Bidesie', 'Erik Oudman'],
        // Autori spracovanej práce Diabetes Res Clin Pract 2026;239:113476 (PMID 42537913) —
        // 9 mien overených cez PubMed 2026-08-28.
        'serove-ketolatky-oblickove-udalosti-diabetes-2-typu' => ['Soo Myoung Shin', 'Jiyoon Lee', 'Young-Eun Kim', 'Jung A Kim', 'Kyoung Jin Kim', 'Kyeong Jin Kim', 'Hee Young Kim', 'Sin Gon Kim', 'Nam Hoon Kim'],
        'spolupraca-vseobecny-lekar-nefrolog-ckd-g5-joint-kd' => ['Minoru Murakami', 'Takuya Aoki', 'Yoshifumi Sugiyama', 'Sho Sasaki', 'Hiroki Nishiwaki', 'Masahiko Yazawa', 'Yoshihiko Raita', 'Hiroo Kawarazaki', 'Hideaki Shimizu', 'Yoshihiro Nakamura', 'Yosuke Saka', 'Masato Matsushima'],
        // Písací výbor konferenčnej správy KDIGO o HF a CKD (Kidney Int 2026;109:1095–1113,
        // PMID 41791738; súčasne JACC Heart Fail 2026;14:102943, PMID 41793402) — 14 menovaných
        // autorov overených cez PubMed/Europe PMC. Skupinové spoluautorstvo „Conference Participants“
        // sa nerozvíja (účastníci sú v appendixe správy).
        'srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026' => ['Carolyn S. P. Lam', 'Biykem Bozkurt', 'David Z. I. Cherney', 'Justin A. Ezekowitz', 'Meg J. Jardine', 'Sadiya S. Khan', 'Magdalena Madero', 'Mark J. Sarnak', 'Jozine M. Ter Maaten', 'Michael Cheung', 'Jennifer M. King', 'Morgan E. Grams', 'Michel Jadoul', 'Nisha Bansal'],
        'swam-technika-tromboza-hemodialyzacneho-pristupu' => ['Lin Li', 'Zhongwang Zhang', 'Hongjie Wang', 'Mingdi Zhu', 'Kun Wang', 'Zheng Liu'],
        'subkutanny-furosemid-readyflow-edemy-hf-ckd' => ['Lois Anzelowitz Levine'],
        'synteticke-wnt-organizatory-oblickove-organoidy' => ['Connor C. Fausto', 'Fokion Glykofrydis', 'Navneet Kumar', 'Jack Schnell', 'Reka L. Csipan', 'Faith De Kuyper', 'Minnal Kunnan', 'Brendan Grubbs', 'Matthew Thornton', 'Michael Thompson', 'Enmian Chang', 'Xuduo Wen', 'Manuel Pelayo', 'MaryAnne Achieng', 'Anoothi Seth', 'Kelly Street', 'Leonardo Morsut', 'Nils O. Lindström'],
        'styridsat-rokov-transplantat-oblicky-ultra-dlhodobe-prezivanie' => ['Michelle Madden', 'Gavin Comerford', 'Patrick O\'Kelly', 'Anne Cooney', 'Liam O\'Neill', 'Elhussein A E Elhassan', 'Alaeldin Abdalla', 'Carol Traynor', 'Peter J Conlon', 'Leonard Browne', 'Julio Chevarria', 'Mike Clarkson', 'David Keane', 'Sarah Cormican', 'Catherine Godson', 'Matt Griffin', 'Luke Harris', 'John Holian', 'Conor Judge', 'Mark Little', 'Liam Martin', 'Sarah Moran', 'Eithne Nic An Riogh', 'Conall O\'Seaghdha', 'Michelle O\'Shaughnessy', 'Liam Plant', 'Brendan Reddy', 'Colm Rowan', 'Jennifer Scott', 'Donal Sexton', 'Andrew Smyth', 'Oonagh Smith', 'Austin Stack', 'Sinead Stoneman', 'Vicki Sandys', 'Jia Wei Teh', 'Vladimir Stoyanov'],
        'taurolidin-relapsujuca-peritonitida-peritonealna-dialyza' => ['Jack Rycen', 'Sofia Santagada', 'Vikas Srivastava'],
        'teclistamab-pred-transplantaciou-oblicky-hla-senzibilizacia' => ['Martina Schatzl', 'Katharina A. Mayer', 'Hermine Agis', 'Susanne Haindl', 'Daniela Kriks', 'Gottfried Fischer', 'Markus Exner', 'Gideon Hönger', 'Nikolina Veljancic', 'Daniela M. Allmer', 'Irene Graf', 'Matthias Diebold', 'Philip F. Halloran', 'Anne Halpin', 'Caishun Li', 'Lori West', 'Nicolas Kozakowski', 'Georg A. Böhmig'],
        // Autori spracovanej práce Clin Kidney J 2026, doi 10.1093/ckj/sfag261 — 11 mien overených
        // cez Crossref 2026-08-28.
        'telesne-zlozenie-tukova-hmota-egfr-populacna-studia' => ['Marlene Agnes Günther', 'Till Ittermann', 'Henry Völzke', 'Sylvia Stracke', 'Karlhans Endlich', 'Robin Bülow', 'Matthias Nauck', 'Mats Wiese', 'Ali Aghdassi', 'Marcello Ricardo Paulista Markus', 'Sabrina von Rheinbaben'],
        'telitacicept-iga-nefropatia-teligan-faza-3-interim' => ['Jicheng Lv', 'Lijun Liu', 'Wenxiang Wang', 'Xinyue Wang', 'Qing Zuraw', 'Vlado Perkovic', 'Jianmin Fang', 'Hong Zhang'],
        'terapie-cielene-na-b-bunky-imunitne-ochorenia-obliciek-kdigo' => ['Jürgen Floege', 'Isabelle Ayoub', 'Silke R. Brix', 'Kirk N. Campbell', 'Richard Furie', 'Patrick H. Nachman', 'Sydney C.W. Tang', 'Nicola M. Tomas', 'Marina Vivarelli', 'Michael Cheung', 'Jennifer M. King', 'Morgan E. Grams', 'Michel Jadoul', 'Brad H. Rovin'],
        // Autori spracovanej primárnej práce SURPASS-CVOT, N Engl J Med 2025;393:2409-2420
        // (PMID 41406444, doi 10.1056/NEJMoa2505928) — 27 menovaných autorov z PubMed efetch
        // CompleteYN=Y (bez skupinového spoluautorstva SURPASS-CVOT Investigators). Overené 2026-09-03.
        // Medscape (Larkin) nie je spracovaný vedecký zdroj.
        'tirzepatid-mounjaro-fda-kardiovaskularne-riziko-t2d-surpass-cvot' => ['Stephen J. Nicholls', 'Imre Pavo', 'Deepak L. Bhatt', 'John B. Buse', 'Stefano Del Prato', 'Steven E. Kahn', 'A. Michael Lincoff', 'Darren K. McGuire', 'Debra Miller', 'Michael A. Nauck', 'Hiroshi Nishiyama', 'Steven E. Nissen', 'Naveed Sattar', 'Govinda Weerakkody', 'Russell J. Wiese', 'Bernard Zinman', 'Sophia Zoungas', 'Jan Basile', 'Melanie J. Davies', 'Francesco Giorgino', 'Monika Kellerer', 'Linong Ji', 'Tamas Varkonyi', 'Venu Menon', 'Jonathan C. Broder', 'Alan Herschtal', 'David D\'Alessio'],
        'tirzepatid-oblickove-vysledky-surpass-nefrologia' => ['Stephen J. Nicholls'],
        'trpc6-inhibicia-fsgs-faza-2-precizna-nefrologia' => ['Luis Sanchez-Russo', 'George Vasquez-Rios', 'Kirk N. Campbell'],
        'tukove-tkanivo-obezita-kardiorenalne-riziko-biologia' => ['Yazmín Macotela', 'Marcelo A. Mori', 'Armando R. Tovar'],
        'ttv-biomarker-imunosupresia-transplantacia-oblicky' => ['Gregor Bond', 'Frederik Haupenthal', 'Felix Herkner', 'Sebastian Kapps', 'Konstantin Doberer', 'Jette Rahn', 'Carole Janis', 'Marta del Álamo', 'Georg Melzer-Venturi', 'Fabrizio Maggi', 'Hannes Neuwirt', 'Kathrin Eller', 'Daniel Cejka', 'Christian Hugo', 'Miriam Banas', 'Klemens Budde', 'Ondřej Viklický', 'Paolo Malvezzi', 'Sophie Caillard', 'Joris Rotmans', 'Jip Jonker', 'Isabel Beneyto', 'David Navarro', 'David Rodriguez-Arias', 'Heinz Regele', 'Matthias Vossen', 'Franz König'],
        'udrzatelna-peritonealna-dialyza-pacienti-zelena-nefrologia' => ['Filipa Trigo', 'João Bessa', 'Joana Tavares', 'Rita Alves', 'Maria João Carvalho', 'Hernâni Gonçalves', 'Paulo Santos', 'Anabela Rodrigues'],
        'umela-inteligencia-nefrologia-co-vieme-limity' => ['Prabhat Singh', 'Lokesh Goyal', 'Deobrat C Mallick', 'Salim R Surani', 'Nayanjyoti Kaushik', 'Deepak Chandramohan', 'Prathap K Simhadri'],
        'umela-inteligencia-sucha-hmotnost-hemodialyza' => ['Hae Ri Kim', 'Hong Jin Bae', 'Jae Wan Jeon', 'Young Rok Ham', 'Ki Ryang Na', 'Kang Wook Lee', 'Yun Kyong Hyon', 'Dae Eun Choi'],
        'vasopresin-nezavisla-cesta-regulacie-vody-adpkd' => ['Mohamad Hadla', 'Jean Marc Mardirossian', 'Daniel G. Bichet', 'Abdul Hamid Borghol', 'Georges Abboud', 'Ahmad Ghanem', 'Eduardo N. Chini', 'Peter C. Harris', 'Vicente E. Torres', 'Seth L. Alper', 'Volker Vallon', 'Fouad T. Chebib'],
        // Autori spracovanej práce Sci Rep 2026;16(1), doi 10.1038/s41598-026-62827-2
        // (PMID 42547796) — 8 mien overených cez PubMed eutils 2026-08-28.
        'vegetarianska-strava-riziko-ckd-uk-biobank' => ['Catharina J. Candussi', 'William Bell', 'Marko Mutapcic', 'Alysha S. Thompson', 'Sabine Rohrmann', 'Aedín Cassidy', 'Tilman Kühn', 'Martina Gaggl'],
        'victory-vitamin-c-tazke-popaleniny-nefrologicke-signaly' => ['Christian Stoppe', 'Aileen Hill', 'Leopoldo C. Cancio', 'Andrew G. Day', 'Kaitlin A. Pruskowski', 'Alexis F. Turgeon', 'Daren K. Heyland'],
        'vitamin-d-klinicka-prax-vysetrovanie-suplementacia-rizika' => ['Marie B. Demay', 'Anastassios G. Pittas', 'Daniel D. Bikle', 'Dima L. Diab', 'Mairead E. Kiely', 'Marise Lazaretti-Castro', 'Paul Lips', 'Deborah M. Mitchell', 'M. Hassan Murad', 'Shelley Powers', 'Sudhaker D. Rao', 'Robert Scragg', 'John A. Tayek', 'Amy M. Valent', 'Judith M. E. Walsh', 'Christopher R. McCartney'],
        'vona-cokolady-vykon-pri-silovom-treningu' => ['Xiaohan Fan', 'Hengzhi Deng', 'Jia Yang Ng', 'Ahmad Amirul Hazim bin Ab Aziz', 'Mohamed Nashrudin bin Naharudin'],
        // Autori spracovanej práce Nephrol Dial Transplant 2026, doi 10.1093/ndt/gfag194 (PMID 42627408) —
        // 4 mená overené cez PubMed 2026-08-28.
        'vychodiskova-egfr-biopsia-imputacia-glomerulove-ochorenia' => ['Jialin Han', 'Mark Canney', 'Lee Er', 'Sean J. Barbour'],
        'vyssi-prijem-bielkovin-merana-gfr-renis' => ['Ludvig Balteskard Rinde', 'Laila A Hopstock', 'Marie W Lundblad', 'Nikoline Balteskard Rinde', 'Karl-Marius Brobak', 'Jon Viljar Norvik', 'Inger-Therese Enoksen', 'Marit D Solbu', 'Ole-Martin Fuskevåg', 'Juan-Jesus Carrero', 'Monica Hauger Carlsen', 'Bjørn Odvar Eriksen', 'Toralf Melsom'],
        // Autori spracovaného komentára Medscape z 19.8.2026 - overené vo verejných metadátach článku.
        'vyzivove-odporucania-usa-2025-2030-masld-ckd' => ['Winston Dunn', 'Ashwani K. Singal'],
        'xenotransplantacia-oblicky-prasa-imunologia-zivy-prijemca' => ['Zhouqi Tang', 'Fadi G. Lakkis', 'Guilherme T. Ribas', 'André F. Cunha', 'Jonathan P. Avila', 'Alessia Giarraputo', 'Leela Morena', 'Karina Lima', 'Rodrigo B. Gassen', 'Jia-Yun Chen', 'Jia-Ren Lin', 'Sandro Santagata', 'Claire T. Avillach', 'Birgitta A. Ryback', 'Martin S. Lindner', 'Sivan Bercovici', 'Ivy A. Rosales', 'Tatsuo Kawai', 'Helder I. Nakaya', 'Robert B. Colvin', 'Thiago J. Borges', 'Leonardo V. Riella'],
        // Autori spracovanej prierezovej štúdie Cureus 2026;18(8):e114700 (doi 10.7759/cureus.114700) -
        // overené v metaúdajoch vydavateľa a v registri Crossref 2026-08-23.
        'krehkost-negeriatricki-dialyzovani-pacienti-frail-skala' => ['Arwa Fareah Ansar', 'Nino Tsertsvadze', 'Barbare Kashibadze', 'Tasnim Tabassum Taundra', 'Vasanthapriya Jeevanandam', 'Mariam Giuashvili', 'Irma Tchokhonelidze'],
        // Autorky spracovaného komentára CodeBlue (Galen Centre) z augusta 2026 - lektorky
        // Fakulty ošetrovateľstva Univerzity Malaya, uvedené v tiráži pôvodného textu.
        // Autori spracovaného prehľadu Sensors 2023;23(3):1361 (PMID 36772401).
        // Autori odporúčaní Talianskej nefrologickej spoločnosti (J Nephrol 2026, doi
        // 10.1093/joneph/aajag225, PMID 42614082) - 20 mien overených cez PubMed eutils 2026-08-23.
        'online-hemodiafiltracia-davkovana-liecba-odporucania-sin' => ['Giovanni F. M. Strippoli', 'Giovanni Pellegrino', 'Jörgen Hegbrant', 'Paolo Fabbrini', 'Paolo Luca Maria Lentini', 'Filippo Aucella', 'Vincenzo Panichi', 'Maurizio Gallieni', 'Bernard Canaud', 'Andrew Davenport', 'Alberto Ortiz', 'Rosa Ramos', 'Jolanta Malyszko', 'Rümeyza Kazancıoğlu', 'Martin Kuhlman', 'Ana Carina Ferreira', 'Krister Cromm', 'Sagar Nigwekar', 'Allen R. Nissenson', 'Luca De Nicola'],
        'wearables-dialyza-nefrologia-dokazy-a-limity' => ['Madelena Stauss', 'Htay Htay', 'Jeroen P. Kooman', 'Thomas Lindsay', 'Alexander Woywodt'],
        // Autori spracovanej suhrnnej analyzy PLOS ONE 2026;21(8):e0356873
        // (doi 10.1371/journal.pone.0356873) - 5 mien overenych cez Crossref 2026-09-06.
        'tenapanor-vyssia-davka-kostna-resorpcia-crevna-pasaz' => ['Nobuo Nagano', 'Shin Tokunaga', 'Shinji Asada', 'Masafumi Fukagawa', 'Tadao Akizawa'],
        // Autori spracovanej kohortovej studie CJASN 2026;21(7):1198-1206
        // (doi 10.2215/CJN.0000001063, PMID 42133950) - 7 mien overenych cez PubMed 2026-09-06.
        'vysokoobjemova-hdf-mortalita-incidentni-dialyzovani-pacienti' => ['Yan Zhang', 'Anke Winter', 'Linda H. Ficociello', 'Smriti Arya', 'Stefano Stuard', 'Len A. Usvyat', 'Kamyar Kalantar-Zadeh'],
        'zastava-obehu-pocas-hemodialyzy-mimotelovy-okruh' => ['Noor Hanita Zaini', 'Noor Hasliza Che Seman'],
    ];
}
