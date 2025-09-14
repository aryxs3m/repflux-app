<?php

namespace App\Services;

use ArdaGnsrn\Ollama\Ollama;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Exceptions\CouldNotLoadImage;
use Spatie\Image\Image;

class AiService
{
    protected Ollama|null $client = null;

    protected function getClient(): Ollama|null
    {
        if ($this->client !== null) {
            return $this->client;
        }

        // TODO: move to services config
        $this->client = Ollama::client('http://ollama-1.kecskemet.pvga.hu');

        return $this->client;
    }

    /**
     * @throws CouldNotLoadImage
     */
    public function parseThreadmill(string $imagePath): array
    {
        $resized = Image::load($imagePath)
            ->fit(Fit::Max, 2048)
            ->optimize()
            ->save('test.jpg')
            ->base64('jpeg', false);

        $client = $this->getClient();

        $completions = $client->completions()->create([
            'model' => 'llava',
            'prompt' => "The attached image is a photo from a threadmill's display that showing the workout results. Please return the values from the display in a json like this: {\"calories\": 0, \"distance\": 0, \"incline\": 0, \"speed\": 0, \"error\": false}. If you cant see something on the screen, set the json value null for that key. Your response only should contain the JSON. If there is any problem, set the error key to true. Don't format the result.",
            'format' => 'json',
            'raw' => true,
            'images' => [
                $resized
            ],
        ]);

        return json_decode($completions->response, true);
    }
}
