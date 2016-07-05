<?php

use Faker\Factory as Faker;
use App\Models\Needy;
use App\Repositories\NeedyRepository;

trait MakeNeedyTrait
{
    /**
     * Create fake instance of Needy and save it in database
     *
     * @param array $needyFields
     * @return Needy
     */
    public function makeNeedy($needyFields = [])
    {
        /** @var NeedyRepository $needyRepo */
        $needyRepo = App::make(NeedyRepository::class);
        $theme = $this->fakeNeedyData($needyFields);
        return $needyRepo->create($theme);
    }

    /**
     * Get fake instance of Needy
     *
     * @param array $needyFields
     * @return Needy
     */
    public function fakeNeedy($needyFields = [])
    {
        return new Needy($this->fakeNeedyData($needyFields));
    }

    /**
     * Get fake data of Needy
     *
     * @param array $postFields
     * @return array
     */
    public function fakeNeedyData($needyFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'names' => $fake->word,
            'last_names' => $fake->word,
            'identification' => $fake->word,
            'type_identifications_id' => $fake->word,
            'history' => $fake->text,
            'contributor' => $fake->word,
            'cellphone_telephone_contact' => $fake->word,
            'users_id' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $needyFields);
    }
}
