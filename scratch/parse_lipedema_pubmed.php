<?php
declare(strict_types=1);

function dumpPmid(string $file): void
{
    $xml = simplexml_load_file($file);
    if ($xml === false) {
        fwrite(STDERR, "FAIL load $file\n");
        return;
    }
    foreach ($xml->PubmedArticle as $art) {
        $a = $art->MedlineCitation->Article;
        echo "FILE: $file\n";
        echo 'TITLE: ' . (string) $a->ArticleTitle . "\n";
        echo 'JOURNAL: ' . (string) $a->Journal->Title . "\n";
        echo 'YEAR: ' . (string) $a->Journal->JournalIssue->PubDate->Year . "\n";
        echo 'VOLUME: ' . (string) $a->Journal->JournalIssue->Volume . "\n";
        echo 'ISSUE: ' . (string) $a->Journal->JournalIssue->Issue . "\n";
        echo 'PAGES: ' . (string) $a->Pagination->MedlinePgn . "\n";
        echo 'PMID: ' . (string) $art->MedlineCitation->PMID . "\n";
        foreach ($art->PubmedData->ArticleIdList->ArticleId as $id) {
            echo 'ID[' . (string) $id['IdType'] . ']: ' . (string) $id . "\n";
        }
        echo "AUTHORS:\n";
        $i = 0;
        $phpList = [];
        foreach ($a->AuthorList->Author as $au) {
            $i++;
            $col = (string) $au->CollectiveName;
            if ($col !== '') {
                echo "$i. COLLECTIVE: $col\n";
                $phpList[] = $col;
                continue;
            }
            $fore = (string) $au->ForeName;
            $last = (string) $au->LastName;
            $suf = (string) $au->Suffix;
            $name = trim($fore . ' ' . $last . ($suf !== '' ? ' ' . $suf : ''));
            echo "$i. $name\n";
            $phpList[] = $name;
        }
        echo "PHP_ARRAY: ['" . implode("', '", array_map(static fn ($n) => str_replace("'", "\\'", $n), $phpList)) . "']\n";
        echo "ABSTRACT:\n";
        if (isset($a->Abstract->AbstractText)) {
            foreach ($a->Abstract->AbstractText as $t) {
                echo (string) $t . "\n\n";
            }
        }
        echo str_repeat('=', 80) . "\n";
    }
}

dumpPmid(__DIR__ . '/pmid34049453.xml');
dumpPmid(__DIR__ . '/pmid41519859.xml');
