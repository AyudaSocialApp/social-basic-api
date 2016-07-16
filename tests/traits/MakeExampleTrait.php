<?php

use Faker\Factory as Faker;
use App\Models\Example;
use App\Repositories\ExampleRepository;

trait MakeExampleTrait
{
    /**
     * Create fake instance of Example and save it in database
     *
     * @param array $exampleFields
     * @return Example
     */
    public function makeExample($exampleFields = [])
    {
        /** @var ExampleRepository $exampleRepo */
        $exampleRepo = App::make(ExampleRepository::class);
        $theme = $this->fakeExampleData($exampleFields);
        return $exampleRepo->create($theme);
    }

    /**
     * Get fake instance of Example
     *
     * @param array $exampleFields
     * @return Example
     */
    public function fakeExample($exampleFields = [])
    {
        return new Example($this->fakeExampleData($exampleFields));
    }

    /**
     * Get fake data of Example
     *
     * @param array $postFields
     * @return array
     */
    public function fakeExampleData($exampleFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'age' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $exampleFields);
    }
}
