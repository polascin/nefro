<?php
declare(strict_types=1);

$file = $argv[1] ?? (__DIR__ . '/lithium_pmids.xml');
$xml = simplexml_load_file($file);
if ($xml === false) {
    fwrite(STDERR, "XML fail\n");
    exit(1);
}
foreach ($xml->PubmedArticle as $a) {
    $m = $a->MedlineCitation;
    $pmid = (string) $m->PMID;
    $art = $m->Article;
    $title = (string) $art->ArticleTitle;
    $journal = (string) $art->Journal->ISOAbbreviation;
    $year = (string) $art->Journal->JournalIssue->PubDate->Year;
    if ($year === '') {
        $year = (string) $art->Journal->JournalIssue->PubDate->MedlineDate;
    }
    $vol = (string) $art->Journal->JournalIssue->Volume;
    $issue = (string) $art->Journal->JournalIssue->Issue;
    $pages = (string) $art->Pagination->MedlinePgn;
    $authors = [];
    $complete = '';
    if (isset($art->AuthorList)) {
        $complete = (string) $art->AuthorList['CompleteYN'];
        foreach ($art->AuthorList->Author as $au) {
            $col = (string) $au->CollectiveName;
            if ($col !== '') {
                $authors[] = $col;
                continue;
            }
            $authors[] = trim((string) $au->ForeName . ' ' . (string) $au->LastName);
        }
    }
    $doi = '';
    if (isset($a->PubmedData->ArticleIdList->ArticleId)) {
        foreach ($a->PubmedData->ArticleIdList->ArticleId as $id) {
            if ((string) $id['IdType'] === 'doi') {
                $doi = (string) $id;
            }
        }
    }
    $abs = '';
    if (isset($art->Abstract->AbstractText)) {
        foreach ($art->Abstract->AbstractText as $t) {
            $label = (string) $t['Label'];
            $abs .= ($label !== '' ? $label . ': ' : '') . (string) $t . "\n";
        }
    }
    echo "===== PMID $pmid =====\n";
    echo "$title\n$journal. $year;$vol($issue):$pages\nDOI: $doi\nCompleteYN=$complete\n";
    echo 'Authors (' . count($authors) . '): ' . implode('; ', $authors) . "\n";
    echo "ABSTRACT:\n" . trim($abs) . "\n\n";
}
