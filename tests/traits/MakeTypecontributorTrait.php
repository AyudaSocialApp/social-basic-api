<?php

use Faker\Factory as Faker;
use App\Models\Typecontributor;
use App\Repositories\TypecontributorRepository;

trait MakeTypecontributorTrait
{
    /**
     * Create fake instance of Typecontributor and save it in database
     *
     * @param array $typecontributorFields
     * @return Typecontributor
     */
    public function makeTypecontributor($typecontributorFields = [])
    {
        /** @var TypecontributorRepository $typecontributorRepo */
        $typecontributorRepo = App::make(TypecontributorRepository::class);
        $theme = $this->fakeTypecontributorData($typecontributorFields);
        return $typecontributorRepo->create($theme);
    }

    /**
     * Get fake instance of Typecontributor
     *
     * @param array $typecontributorFields
     * @return Typecontributor
     */
    public function fakeTypecontributor($typecontributorFields = [])
    {
        return new Typecontributor($this->fakeTypecontributorData($typecontributorFields));
    }

    /**
     * Get fake data of Typecontributor
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTypecontributorData($typecontributorFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $typecontributorFields);
    }
}
