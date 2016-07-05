<?php

use Faker\Factory as Faker;
use App\Models\Typeidentification;
use App\Repositories\TypeidentificationRepository;

trait MakeTypeidentificationTrait
{
    /**
     * Create fake instance of Typeidentification and save it in database
     *
     * @param array $typeidentificationFields
     * @return Typeidentification
     */
    public function makeTypeidentification($typeidentificationFields = [])
    {
        /** @var TypeidentificationRepository $typeidentificationRepo */
        $typeidentificationRepo = App::make(TypeidentificationRepository::class);
        $theme = $this->fakeTypeidentificationData($typeidentificationFields);
        return $typeidentificationRepo->create($theme);
    }

    /**
     * Get fake instance of Typeidentification
     *
     * @param array $typeidentificationFields
     * @return Typeidentification
     */
    public function fakeTypeidentification($typeidentificationFields = [])
    {
        return new Typeidentification($this->fakeTypeidentificationData($typeidentificationFields));
    }

    /**
     * Get fake data of Typeidentification
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTypeidentificationData($typeidentificationFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $typeidentificationFields);
    }
}
