<?php

namespace App\Console\Commands;

use App\NewsCategory;
use Illuminate\Console\Command;

class SyncNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:news {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get top news';
    private $numberOfNews = 200;
    private $newsSourcesLink = 'https://newsapi.org/v2/sources?language=en&country=us';
    private $headlinesLink = 'https://newsapi.org/v2/top-headlines?sources=';
    private $apiKey = '&apiKey=3788b71ad3b44ec2ad35cc44037644c9';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->numberOfNews = $this->newsCount();
        $newsSources = $this->getNewsSources();
        echo 'Creating news ...' . PHP_EOL;
        $bar = $this->output->createProgressBar($this->numberOfNews);
        $bar->start();
        foreach ($newsSources as $source) {
            if ($this->numberOfNews < 0) {
                break;
            }
            $category = NewsCategory::firstOrCreate(['name' => $source['category']]);
            $file = file_get_contents($this->headlinesLink . $source['id'] . $this->apiKey);
            $news = json_decode($file, true);

            foreach ($news['articles'] as $article) {
                if ($article['title'] && $article['description'] && $article['content'] && $article['urlToImage']) {
                    $category->news()->create($article);
                    $bar->advance();
                    $this->numberOfNews--;
                }
                if ($this->numberOfNews < 0) {
                    $bar->finish();
                    break;
                }
            }
        }

        echo PHP_EOL . 'Synchronization completed successfully...' . PHP_EOL;
    }


    private function getNewsSources()
    {
        echo 'Download news sources ...' . PHP_EOL;

        $file = file_get_contents($this->newsSourcesLink . $this->apiKey);
        $result = json_decode($file, true);
        return $result['sources'];
    }

    private function newsCount()
    {
        $question = $this->option('force') === true
            ? 200
            : $this->ask('number of news?');
        if (!is_numeric($question)) {
            echo 'Please inter number...' . PHP_EOL;
            $this->newsCount();
        }
        return $question;
    }
}
