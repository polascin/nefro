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
        'antimikrobialna-rezistencia-infekcie-mocovych-ciest-nefrologia' => ['Sibylle von Vietinghoff', 'Olga Shevchuk', 'Ulrich Dobrindt', 'Daniel Robert Engel', 'Selina K. Jorch', 'Christian Kurts', 'Thomas Miethke', 'Florian Wagenlehner'],
        'betablokatory-ckd-bez-kardiovaskularneho-ochorenia' => ['Seung Hyun Han', 'Mina Kim', 'Jungkuk Lee', 'Sang Youb Han'],
        'c3-glomerulopatia-c3g-liecba-inhibicia-komplementu' => ['Manuel Praga', 'Richard J. Smith', 'Andrew S. Bomback'],
        'ckd-mozog-kognitivne-poruchy-cievne-poskodenie' => ['Mickaël Bobot'],
        'ckd-samostatny-faktor-polyfarmacie' => ['Rafael Santamaria', 'Carlos Escobar', 'Ignacio Hernández', 'Beatriz Palacios', 'Unai Aranda', 'Roberto Alcázar'],
        // Autorstvo písacieho výboru usmernenia AHA/ACC/ADA/ASN 2026 (Circulation 2026;154(4):e50-e158,
        // PMID 42263157) — overené v Europe PMC 2026-08-05. Predchádzajúci zoznam obsahoval skomolené
        // krstné mená a šesť mien z iného dokumentu; opravené.
        'ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register' => ['Valeria Valente', 'Lina Benson', 'Carin Corovic Cabrera', 'Raffaele Scorza', 'Felix Lindberg', 'Ida Haugen Löfman', 'Michael Melin', 'Lars H. Lund', 'Giulia Ferrannini', 'Gianluigi Savarese'],
        'ckm-syndrom-stadia-skrining-liecba-usmernenie-2026' => ['Chiadi E. Ndumele', 'Fatima Rodriguez', 'Dave L. Dixon', 'Sadiya S. Khan', 'Debabrata Mukherjee', 'Mandeep Bajaj', 'Sripal Bangalore', 'Biykem Bozkurt', 'Khadijah Breathett', 'Shoa L. Clarke', 'Ian H. de Boer', 'David H. Ellison', 'Lorraine S. Evangelista', 'Sean P. Heffron', 'Dhruv S. Kazi', 'Ambar Kulshreshtha', 'Ildiko Lingvay', 'Cecilia C. Low Wang', 'Claudia A. Mercado', 'John Magaña Morton', 'Ian J. Neeland', 'Neha Pagidipati', 'Tiffany M. Powell-Wiley', 'Janani Rangaswami', 'Goutham Rao', 'Nosheen Reza', 'Anum Saeed', 'Wendy St Peter', 'J. Bradley Starks', 'Madeline Sterling', 'Amy W. Talbot', 'Andrew H. Tran', 'Katherine R. Tuttle', 'Lisa B. VanWagner', 'Amanda R. Vest', 'Salim S. Virani'],
        'ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia' => ['Chiadi E. Ndumele', 'Fatima Rodriguez', 'Dave L. Dixon', 'Sadiya S. Khan', 'Debabrata Mukherjee', 'Mandeep Bajaj', 'Sripal Bangalore', 'Biykem Bozkurt', 'Khadijah Breathett', 'Shoa L. Clarke', 'Ian H. de Boer', 'David H. Ellison', 'Lorraine S. Evangelista', 'Sean P. Heffron', 'Dhruv S. Kazi', 'Ambar Kulshreshtha', 'Ildiko Lingvay', 'Cecilia C. Low Wang', 'Claudia A. Mercado', 'John Magaña Morton', 'Ian J. Neeland', 'Neha Pagidipati', 'Tiffany M. Powell-Wiley', 'Janani Rangaswami', 'Goutham Rao', 'Nosheen Reza', 'Anum Saeed', 'Wendy St Peter', 'J. Bradley Starks', 'Madeline Sterling', 'Amy W. Talbot', 'Andrew H. Tran', 'Katherine R. Tuttle', 'Lisa B. VanWagner', 'Amanda R. Vest', 'Salim S. Virani'],
        'cystatin-c-kreatinin-egfr-biomarkery-reumatoidna-artritida' => ['Sho Fukui', 'Lesley A. Inker', 'Leah M. Santacroce', 'Jon T. Giles', 'Katherine P. Liao', 'Joan M. Bathon', 'Daniel H. Solomon'],
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
        'glp1-kompulzivne-spravanie-food-noise-nefrologia' => ['Eric Spitznagel'],
        'hypertenzia-v-tehotenstve-a-po-porode-nefrologicka-rola' => ['Line Malha', 'Phyllis August'],
        'iga-nefropatia-algoritmus-kdigo-2025-kdoqi' => ['Isabelle Ayoub', 'Gaia Coppock', 'Shikha Wadhwani', 'Timothy Yau'],
        'implementacia-intenzivnej-kontroly-tlaku-esprit-nefrologia' => ['Yu-Jie Zuo', 'Ji-Guang Wang'],
        'inhibicia-tmao-fmc-regresia-fibrozy-ckd-model' => ['Joseph A DiDonato', 'Taylor L Weeks', 'Nilaksh Gupta', 'Deepthi P Mallela', 'Jennifer A Buffa', 'Zeneng Wang', 'Xinmin S Li', 'James T Anderson', 'Xiaoming Fu', 'Naseer Sangwan', 'Ina Nemet', 'Scott J Cameron', 'Stanley L Hazen'],
        'iga-nefropatia-kdigo-2025-kdoqi' => ['Isabelle Ayoub', 'Gaia Coppock', 'Shikha Wadhwani', 'Timothy Yau'],
        'ked-sa-citime-chori-co-medicina-prehliada-nefrologia' => ['Arya Anthony Kamyab'],
        'kedy-zacat-krt-pri-aki' => ['Marlies Ostermann', 'Sean M Bagshaw', 'Nuttha Lumlertgul', 'Ron Wald'],
        'ketoacidoza-nefrologicka-prax-hladovanie-euglykemicka-dka' => ['Biff F. Palmer', 'Deborah J. Clegg'],
        'kreatin-ochorenia-obliciek-bezpecnost-benefit' => ['Juliana Paula Pereira', 'Viviane O Leal', 'Pricilla Trigueira', 'Natália A Borges', 'Ludmila F M F Cardozo', 'Denise Mafra'],
        'kreatin-zdravie-mozgu' => ['Heidi Moawad'],
        'krvna-skupina-a-mortalita-hemodialyza' => ['Masafumi Kurajoh', 'Tetsuo Shoji', 'Shinya Nakatani', 'Yuki Nagata', 'Hisako Fujii', 'Yasuo Imanishi', 'Masanori Emoto', 'Tomoaki Morioka'],
        'krce-kostroveho-svalstva-dialyza-prevalencia-metaanalyza' => ['Seda Babroudi', 'Marcelle Tuttle', 'Eduardo K. Lacson Jr.'],
        'kvalitativny-vyskum-nefrologia-rozhodovanie-pacientov-ckd' => ['Lisa O\'Mary'],
        'lekari-cas-autonomia-vyhorenie-pracovne-podmienky' => ['Jennifer Nelson'],
        'liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki' => ['Pranav Garimella', 'Marc Richards', 'Matthew Breeggemann'],
        'malignity-transplantacia-oblicky-skrining-ptld' => ['Christopher D. Blosser', 'Elena-Bianca Barbir', 'Salma Shaikhouni', 'Naoka Murakami'],
        'meduza-hojenie-ran-bez-jaziev-regenerativna-medicina' => ['Jocelyn E. Malamy', 'Maxwell Sassaman', 'Manjula P. Mony'],
        'monoklonalna-gamapatia-klinickeho-vyznamu-mgcs-mimo-mgrs' => ['Patrick Hofmann', 'Sujal I. Shah', 'Helmut G. Rennke', 'Rahel Schwotzer', 'David B. Sykes', 'Nelson Leung', 'Raad B. Chowdhury'],
        'moderne-trendy-v-nefroprotekcii' => ['Hiddo J.L. Heerspink', 'Bergur V. Stefánsson', 'Ricardo Correa-Rotter', 'Glenn M. Chertow', 'Tom Greene', 'Fan-Fan Hou', 'Johannes F.E. Mann', 'John J.V. McMurray', 'Magnus Lindberg', 'Peter Rossing', 'C. David Sjöström', 'Roberto D. Toto', 'Anna-Maria Langkilde', 'David C. Wheeler'],
        'nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou' => ['Jooyeon Yoon', 'Kyungjun Shon', 'Hayne Cho Park', 'Sua Lee', 'Young-Ki Lee', 'Hyungseok Lee', 'Eun Jung Kim', 'Hoon Suk Park', 'Min-Ho Kim', 'Do Hyoung Kim'],
        'nediabeticka-ckd-nehemodynamicke-mechanizmy-nsmra-finerenon' => ['Brendon L. Neuen', 'Beatriz Fernandez-Fernandez'],
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
        'pentoxifylin-diabeticka-choroba-obliciek-mini-review' => ['David J. Leehey', 'Rajiv Agarwal'],
        'perzistujuca-hyperparatyreoza-po-transplantacii-oblicky' => ['Daniele Vetrano', 'Simona Barbuto', 'Francesco Aguanno', 'Paolo Mastromauro', 'Valeria Grandinetti', 'Giorgia Comai', 'Gaetano La Manna', 'Giuseppe Cianciolo'],
        'perzistujuca-mikroskopicka-hematuria-podocytopatie-prognoza' => ['Gabriel Ștefan', 'Nicoleta Petre', 'Adrian Zugravu', 'Simona Stancu'],
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
        'retatrutid-mimo-schvalenia-neregulovane-pouzivanie' => ['Marilynn Larkin'],
        'rodove-rozdiely-dialyza-transplantacia-era-usrds' => ['Vianda S Stel', 'Nicholas C Chesnaye', 'Rianne Boenink', 'Brittany A Boerstra', 'Megan E Astley', 'Shona Methven', 'Line Heylen', 'Halima Resic', 'Marc A G J ten Dam', 'Kristine Hommel', 'Marit D Solbu', 'Maria F Slon Roblero', 'Nuria Aresté-Fosalba', 'Danilo Radunovic', 'Héctor García López', 'Lukas Buchwinkler', 'Rebecca Guidotti', 'Mathilde Lassalle', 'Carmen Santiuste', 'Maria Stendahl', 'Olafur S Indridason', 'Almudena Escribá', 'María Encarnación Bouzas-Caamaño', 'Olga Lucía Rodriguez Arévalo', 'George Moustakas', 'Hermann Hernández Vargas', 'Alberto Ortiz', 'Anneke Kramer'],
        'roxadustat-esa-hyporesponzivita-opakovany-ciel-hb' => ['Mehmet Demir', 'Ilyas Ozturk', 'Merve Aktar', 'Cihan Heybeli', 'Can Huzmeli', 'Orhan Ozdemir', 'Seda Safak Ozturk', 'Tulin Akagun', 'Neriman Sila Koc', 'Mehmet Tuncay', 'Ekrem Kara', 'Tuncay Sahutoglu'],
        'semaglutid-ckd-porovnanie-glp1-realna-prax' => ['Joshua J Neumiller', 'Yihong Deng', 'Kavya Sindhu Swarna', 'Eric C Polley', 'Jeph Herrin', 'Rodolfo J Galindo', 'Guillermo E Umpierrez', 'Joseph S Ross', 'Mindy M Mickelson', 'Kate Dryden', 'Katherine R Tuttle', 'Rozalina G McCoy'],
        'semaglutid-wernickeho-encefalopatia-deficit-tiaminu' => ['Janice Bidesie', 'Erik Oudman'],
        'spolupraca-vseobecny-lekar-nefrolog-ckd-g5-joint-kd' => ['Minoru Murakami', 'Takuya Aoki', 'Yoshifumi Sugiyama', 'Sho Sasaki', 'Hiroki Nishiwaki', 'Masahiko Yazawa', 'Yoshihiko Raita', 'Hiroo Kawarazaki', 'Hideaki Shimizu', 'Yoshihiro Nakamura', 'Yosuke Saka', 'Masato Matsushima'],
        'swam-technika-tromboza-hemodialyzacneho-pristupu' => ['Lin Li', 'Zhongwang Zhang', 'Hongjie Wang', 'Mingdi Zhu', 'Kun Wang', 'Zheng Liu'],
        'synteticke-wnt-organizatory-oblickove-organoidy' => ['Connor C. Fausto', 'Fokion Glykofrydis', 'Navneet Kumar', 'Jack Schnell', 'Reka L. Csipan', 'Faith De Kuyper', 'Minnal Kunnan', 'Brendan Grubbs', 'Matthew Thornton', 'Michael Thompson', 'Enmian Chang', 'Xuduo Wen', 'Manuel Pelayo', 'MaryAnne Achieng', 'Anoothi Seth', 'Kelly Street', 'Leonardo Morsut', 'Nils O. Lindström'],
        'styridsat-rokov-transplantat-oblicky-ultra-dlhodobe-prezivanie' => ['Michelle Madden', 'Gavin Comerford', 'Patrick O\'Kelly', 'Anne Cooney', 'Liam O\'Neill', 'Elhussein A E Elhassan', 'Alaeldin Abdalla', 'Carol Traynor', 'Peter J Conlon', 'Leonard Browne', 'Julio Chevarria', 'Mike Clarkson', 'David Keane', 'Sarah Cormican', 'Catherine Godson', 'Matt Griffin', 'Luke Harris', 'John Holian', 'Conor Judge', 'Mark Little', 'Liam Martin', 'Sarah Moran', 'Eithne Nic An Riogh', 'Conall O\'Seaghdha', 'Michelle O\'Shaughnessy', 'Liam Plant', 'Brendan Reddy', 'Colm Rowan', 'Jennifer Scott', 'Donal Sexton', 'Andrew Smyth', 'Oonagh Smith', 'Austin Stack', 'Sinead Stoneman', 'Vicki Sandys', 'Jia Wei Teh', 'Vladimir Stoyanov'],
        'taurolidin-relapsujuca-peritonitida-peritonealna-dialyza' => ['Jack Rycen', 'Sofia Santagada', 'Vikas Srivastava'],
        'teclistamab-pred-transplantaciou-oblicky-hla-senzibilizacia' => ['Martina Schatzl', 'Katharina A. Mayer', 'Hermine Agis', 'Susanne Haindl', 'Daniela Kriks', 'Gottfried Fischer', 'Markus Exner', 'Gideon Hönger', 'Nikolina Veljancic', 'Daniela M. Allmer', 'Irene Graf', 'Matthias Diebold', 'Philip F. Halloran', 'Anne Halpin', 'Caishun Li', 'Lori West', 'Nicolas Kozakowski', 'Georg A. Böhmig'],
        'telitacicept-iga-nefropatia-teligan-faza-3-interim' => ['Jicheng Lv', 'Lijun Liu', 'Wenxiang Wang', 'Xinyue Wang', 'Qing Zuraw', 'Vlado Perkovic', 'Jianmin Fang', 'Hong Zhang'],
        'terapie-cielene-na-b-bunky-imunitne-ochorenia-obliciek-kdigo' => ['Jürgen Floege', 'Isabelle Ayoub', 'Silke R. Brix', 'Kirk N. Campbell', 'Richard Furie', 'Patrick H. Nachman', 'Sydney C.W. Tang', 'Nicola M. Tomas', 'Marina Vivarelli', 'Michael Cheung', 'Jennifer M. King', 'Morgan E. Grams', 'Michel Jadoul', 'Brad H. Rovin'],
        'tirzepatid-oblickove-vysledky-surpass-nefrologia' => ['Stephen J. Nicholls'],
        'trpc6-inhibicia-fsgs-faza-2-precizna-nefrologia' => ['Luis Sanchez-Russo', 'George Vasquez-Rios', 'Kirk N. Campbell'],
        'tukove-tkanivo-obezita-kardiorenalne-riziko-biologia' => ['Yazmín Macotela', 'Marcelo A. Mori', 'Armando R. Tovar'],
        'ttv-biomarker-imunosupresia-transplantacia-oblicky' => ['Gregor Bond', 'Frederik Haupenthal', 'Felix Herkner', 'Sebastian Kapps', 'Konstantin Doberer', 'Jette Rahn', 'Carole Janis', 'Marta del Álamo', 'Georg Melzer-Venturi', 'Fabrizio Maggi', 'Hannes Neuwirt', 'Kathrin Eller', 'Daniel Cejka', 'Christian Hugo', 'Miriam Banas', 'Klemens Budde', 'Ondřej Viklický', 'Paolo Malvezzi', 'Sophie Caillard', 'Joris Rotmans', 'Jip Jonker', 'Isabel Beneyto', 'David Navarro', 'David Rodriguez-Arias', 'Heinz Regele', 'Matthias Vossen', 'Franz König'],
        'udrzatelna-peritonealna-dialyza-pacienti-zelena-nefrologia' => ['Filipa Trigo', 'João Bessa', 'Joana Tavares', 'Rita Alves', 'Maria João Carvalho', 'Hernâni Gonçalves', 'Paulo Santos', 'Anabela Rodrigues'],
        'umela-inteligencia-nefrologia-co-vieme-limity' => ['Prabhat Singh', 'Lokesh Goyal', 'Deobrat C Mallick', 'Salim R Surani', 'Nayanjyoti Kaushik', 'Deepak Chandramohan', 'Prathap K Simhadri'],
        'umela-inteligencia-sucha-hmotnost-hemodialyza' => ['Hae Ri Kim', 'Hong Jin Bae', 'Jae Wan Jeon', 'Young Rok Ham', 'Ki Ryang Na', 'Kang Wook Lee', 'Yun Kyong Hyon', 'Dae Eun Choi'],
        'vasopresin-nezavisla-cesta-regulacie-vody-adpkd' => ['Mohamad Hadla', 'Jean Marc Mardirossian', 'Daniel G. Bichet', 'Abdul Hamid Borghol', 'Georges Abboud', 'Ahmad Ghanem', 'Eduardo N. Chini', 'Peter C. Harris', 'Vicente E. Torres', 'Seth L. Alper', 'Volker Vallon', 'Fouad T. Chebib'],
        'victory-vitamin-c-tazke-popaleniny-nefrologicke-signaly' => ['Christian Stoppe', 'Aileen Hill', 'Leopoldo C. Cancio', 'Andrew G. Day', 'Kaitlin A. Pruskowski', 'Alexis F. Turgeon', 'Daren K. Heyland'],
        'vitamin-d-klinicka-prax-vysetrovanie-suplementacia-rizika' => ['Marie B. Demay', 'Anastassios G. Pittas', 'Daniel D. Bikle', 'Dima L. Diab', 'Mairead E. Kiely', 'Marise Lazaretti-Castro', 'Paul Lips', 'Deborah M. Mitchell', 'M. Hassan Murad', 'Shelley Powers', 'Sudhaker D. Rao', 'Robert Scragg', 'John A. Tayek', 'Amy M. Valent', 'Judith M. E. Walsh', 'Christopher R. McCartney'],
        'vona-cokolady-vykon-pri-silovom-treningu' => ['Xiaohan Fan', 'Hengzhi Deng', 'Jia Yang Ng', 'Ahmad Amirul Hazim bin Ab Aziz', 'Mohamed Nashrudin bin Naharudin'],
        'xenotransplantacia-oblicky-prasa-imunologia-zivy-prijemca' => ['Zhouqi Tang', 'Fadi G. Lakkis', 'Guilherme T. Ribas', 'André F. Cunha', 'Jonathan P. Avila', 'Alessia Giarraputo', 'Leela Morena', 'Karina Lima', 'Rodrigo B. Gassen', 'Jia-Yun Chen', 'Jia-Ren Lin', 'Sandro Santagata', 'Claire T. Avillach', 'Birgitta A. Ryback', 'Martin S. Lindner', 'Sivan Bercovici', 'Ivy A. Rosales', 'Tatsuo Kawai', 'Helder I. Nakaya', 'Robert B. Colvin', 'Thiago J. Borges', 'Leonardo V. Riella'],
    ];
}
