<?php

use Faker\Factory as Faker;
use App\Models\Typeneedy;
use App\Repositories\TypeneedyRepository;

trait MakeTypeneedyTrait
{
    /**
     * Create fake instance of Typeneedy and save it in database
     *
     * @param array $typeneedyFields
     * @return Typeneedy
     */
    public function makeTypeneedy($typeneedyFields = [])
    {
        /** @var TypeneedyRepository $typeneedyRepo */
        $typeneedyRepo = App::make(TypeneedyRepository::class);
        $theme = $this->fakeTypeneedyData($typeneedyFields);
        return $typeneedyRepo->create($theme);
    }

    /**
     * Get fake instance of Typeneedy
     *
     * @param array $typeneedyFields
     * @return Typeneedy
     */
    public function fakeTypeneedy($typeneedyFields = [])
    {
        return new Typeneedy($this->fakeTypeneedyData($typeneedyFields));
    }

    /**
     * Get fake data of Typeneedy
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTypeneedyData($typeneedyFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $typeneedyFields);
    }
}
