<?php

use Faker\Factory as Faker;
use App\Models\Help;
use App\Repositories\HelpRepository;

trait MakeHelpTrait
{
    /**
     * Create fake instance of Help and save it in database
     *
     * @param array $helpFields
     * @return Help
     */
    public function makeHelp($helpFields = [])
    {
        /** @var HelpRepository $helpRepo */
        $helpRepo = App::make(HelpRepository::class);
        $theme = $this->fakeHelpData($helpFields);
        return $helpRepo->create($theme);
    }

    /**
     * Get fake instance of Help
     *
     * @param array $helpFields
     * @return Help
     */
    public function fakeHelp($helpFields = [])
    {
        return new Help($this->fakeHelpData($helpFields));
    }

    /**
     * Get fake data of Help
     *
     * @param array $postFields
     * @return array
     */
    public function fakeHelpData($helpFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'type_helps_id' => $fake->randomDigitNotNull,
            'description' => $fake->text,
            'date' => $fake->word,
            'contributors_id' => $fake->randomDigitNotNull,
            'needy_id' => $fake->randomDigitNotNull,
            'place_delivery' => $fake->text,
            'date_hour' => $fake->word,
            'delivered' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $helpFields);
    }
}
