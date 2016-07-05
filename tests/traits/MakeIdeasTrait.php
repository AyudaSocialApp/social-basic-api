<?php

use Faker\Factory as Faker;
use App\Models\Ideas;
use App\Repositories\IdeasRepository;

trait MakeIdeasTrait
{
    /**
     * Create fake instance of Ideas and save it in database
     *
     * @param array $ideasFields
     * @return Ideas
     */
    public function makeIdeas($ideasFields = [])
    {
        /** @var IdeasRepository $ideasRepo */
        $ideasRepo = App::make(IdeasRepository::class);
        $theme = $this->fakeIdeasData($ideasFields);
        return $ideasRepo->create($theme);
    }

    /**
     * Get fake instance of Ideas
     *
     * @param array $ideasFields
     * @return Ideas
     */
    public function fakeIdeas($ideasFields = [])
    {
        return new Ideas($this->fakeIdeasData($ideasFields));
    }

    /**
     * Get fake data of Ideas
     *
     * @param array $postFields
     * @return array
     */
    public function fakeIdeasData($ideasFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'content' => $fake->text,
            'users_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $ideasFields);
    }
}
