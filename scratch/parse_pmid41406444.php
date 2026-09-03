<?php
$xml = simplexml_load_file(__DIR__ . '/pmid41406444.xml');
$a = $xml->PubmedArticle->MedlineCitation->Article;
echo 'TITLE: ' . (string) $a->ArticleTitle . PHP_EOL;
echo 'JOURNAL: ' . (string) $a->Journal->Title . PHP_EOL;
echo 'ABBR: ' . (string) $a->Journal->ISOAbbreviation . PHP_EOL;
echo 'YEAR: ' . (string) $a->Journal->JournalIssue->PubDate->Year . PHP_EOL;
echo 'MONTH: ' . (string) $a->Journal->JournalIssue->PubDate->Month . PHP_EOL;
echo 'VOL: ' . (string) $a->Journal->JournalIssue->Volume . PHP_EOL;
echo 'ISSUE: ' . (string) $a->Journal->JournalIssue->Issue . PHP_EOL;
echo 'PAGES: ' . (string) $a->Pagination->MedlinePgn . PHP_EOL;
foreach ($a->ELocationID as $e) {
    echo 'EID ' . (string) $e['EIdType'] . ': ' . (string) $e . PHP_EOL;
}
echo PHP_EOL . 'ABSTRACT:' . PHP_EOL;
foreach ($a->Abstract->AbstractText as $t) {
    $label = (string) $t['Label'];
    echo '--- ' . $label . ' ---' . PHP_EOL;
    echo (string) $t . PHP_EOL . PHP_EOL;
}
echo 'AUTHORS CompleteYN:' . PHP_EOL;
$list = $a->AuthorList;
echo 'CompleteYN=' . (string) $list['CompleteYN'] . PHP_EOL;
$i = 0;
$names = [];
foreach ($list->Author as $au) {
    $i++;
    $fore = (string) $au->ForeName;
    $last = (string) $au->LastName;
    $col = (string) $au->CollectiveName;
    $valid = (string) $au['ValidYN'];
    if ($col !== '') {
        echo $i . '. COLLECTIVE: ' . $col . ' Valid=' . $valid . PHP_EOL;
    } else {
        $name = trim($fore . ' ' . $last);
        $names[] = $name;
        echo $i . '. ' . $name . ' Valid=' . $valid . PHP_EOL;
    }
}
echo 'COUNT=' . $i . PHP_EOL;
echo PHP_EOL . 'PHP_ARRAY:' . PHP_EOL;
echo "['" . implode("', '", $names) . "']" . PHP_EOL;
echo 'NAMED_COUNT=' . count($names) . PHP_EOL;

$mc = $xml->PubmedArticle->MedlineCitation;
echo PHP_EOL . 'PMID: ' . (string) $mc->PMID . PHP_EOL;
if (isset($xml->PubmedArticle->PubmedData->ArticleIdList)) {
    foreach ($xml->PubmedArticle->PubmedData->ArticleIdList->ArticleId as $id) {
        echo 'ID ' . (string) $id['IdType'] . ': ' . (string) $id . PHP_EOL;
    }
}
