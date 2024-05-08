<?php
# scraping books to scrape: https://montereysheriff.org/news/
# Scrapper with pagination
# Scrapping data saved in CSV format

require 'vendor/autoload.php';
$client = new \Goutte\Client();

$url = 'https://montereysheriff.org/news/';

while (true)
{
    $crawler = $client->request('GET', $url);

    $file = fopen("montereysheriff.csv", "a"); //print data in CSV file format
    $crawler
        ->filter('article.post div.blog-layout-1 div.post-content header.entry-header h2.entry-title a')
        ->each(function ($node) use ($file) {
            $name = $node->text();
            echo "{$name} \n";
            fputcsv($file, [$name]);
        });
        fclose($file);

    // Try to find the "Next" link
    $next = $crawler->filter('div.nav-links a.next');

    // Stop, if there is no more "Next" link
    if ($next->count() == 0) break;

    $url = $next->link()->getUri();
}