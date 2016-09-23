<?php

namespace App\AssisteAi;

use App\Movie;
use App\Thread;
use Curl\Curl;
use Illuminate\Support\Str;

class TelegramBot
{

    private $url;

    public function getUpdates()
    {
        $this->url = 'https://api.telegram.org/bot' . env('TELEGRAM_TOKEN') . '/getUpdates';

        return $this->execute();
    }

    public function sendMessage(Thread $thread)
    {
        $this->url = 'https://api.telegram.org/bot' . env('TELEGRAM_TOKEN') . '/sendMessage';

        if($thread->comment !== null) {
            $content = $thread->comment;
        } else {
            $content = shorten($thread->movie->description, 180);
        }

        $data = [
            'chat_id'    => env('TELEGRAM_CHATID'),
            'text'       => '[' . $thread->movie->original_title . ' (' . $thread->movie->year . ')](http://assisteai.com.br/#' . $thread->id . '-' . Str::slug($thread->movie->original_title) . ')' . PHP_EOL . PHP_EOL .
                '_' . $content . '_' . PHP_EOL . PHP_EOL .
                '*' . $thread->rating . '* - ' . $thread->user->name,
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => true,
        ];

        return $this->execute($data);
    }

    private function execute($data = null)
    {
        $curl = new Curl();
        if($data !== null) {
            $result = $curl->post($this->url, $data);
        } else {
            $result = $curl->get($this->url);
        }
        $curl->close();

        return $result;
    }

}
