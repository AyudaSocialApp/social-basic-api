<?php

use Faker\Factory as Faker;
use App\Models\Typehelp;
use App\Repositories\TypehelpRepository;

trait MakeTypehelpTrait
{
    /**
     * Create fake instance of Typehelp and save it in database
     *
     * @param array $typehelpFields
     * @return Typehelp
     */
    public function makeTypehelp($typehelpFields = [])
    {
        /** @var TypehelpRepository $typehelpRepo */
        $typehelpRepo = App::make(TypehelpRepository::class);
        $theme = $this->fakeTypehelpData($typehelpFields);
        return $typehelpRepo->create($theme);
    }

    /**
     * Get fake instance of Typehelp
     *
     * @param array $typehelpFields
     * @return Typehelp
     */
    public function fakeTypehelp($typehelpFields = [])
    {
        return new Typehelp($this->fakeTypehelpData($typehelpFields));
    }

    /**
     * Get fake data of Typehelp
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTypehelpData($typehelpFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $typehelpFields);
    }
}
