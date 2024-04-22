<?php
# scraping books to scrape: https://books.toscrape.com/
require 'vendor/autoload.php';
$client = new \Goutte\Client();

$url = 'https://books.toscrape.com/';

while (true)
{
    $crawler = $client->request('GET', $url);

    $crawler
        ->filter('.row li article h3 a')
        ->each(function ($node) use ($client) {
            $name = $node->text();
            echo "{$name} \n";
        });

    // Try to find the "Next" link
    $next = $crawler->filter('li.next a');

    // Stop, if there is no more "Next" link
    if ($next->count() == 0) break;

    $url = $next->link()->getUri();
}