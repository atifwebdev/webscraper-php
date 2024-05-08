<?php
# scraping books to scrape: https://ocsheriff.gov/news/
# Scrapper with pagination
# Scrapping data saved in CSV format

require 'vendor/autoload.php';
$client = new \Goutte\Client();

$url = 'https://ocsheriff.gov/news';

while (true)
{
    $crawler = $client->request('GET', $url);

    $file = fopen("ocsheriff.csv", "a"); //print data in CSV file format
    $crawler
        ->filter('.results div.views-row a.card-bordered-link div.card-bordered div.card-bordered__content h2 span')
        ->each(function ($node) use ($file) {
            $name = $node->text();
            echo "{$name} \n";
            fputcsv($file, [$name]);
        });
        fclose($file);

    // Try to find the "Next" link
    $next = $crawler->filter('a.pager__link--next');

    // Stop, if there is no more "Next" link
    if ($next->count() == 0) break;

    $url = $next->link()->getUri();
}