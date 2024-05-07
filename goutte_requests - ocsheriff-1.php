<?php
# scraping books to scrape: https://ocsheriff.gov/news/
# Scrapper with pagination
# Scrapping data saved in CSV format

require 'vendor/autoload.php';
$client = new \Goutte\Client();

$postCount = 0;
while (true) {
    $url = 'https://ocsheriff.gov/news?page=' . $postCount;
    $crawler = $client->request('GET', $url);

    $file = fopen("books.csv", "a"); //print data in CSV file format
    $crawler
        ->filter('.results div.views-row a.card-bordered-link div.card-bordered div.card-bordered__content h2 span')
        ->each(function ($node) use ($file) {
            $name = $node->text();
            // $scraped_data[] = [$node->text()];
            echo "{$name} \n";
            fputcsv($file, [$name]);
        });
        fclose($file);
    if ($postCount == 3) break; //put number of pages here to scrape
    $postCount++;
    echo "{$postCount} \n";
}