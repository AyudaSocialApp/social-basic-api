<?php

use Faker\Factory as Faker;
use App\Models\Contributor;
use App\Repositories\ContributorRepository;

trait MakeContributorTrait
{
    /**
     * Create fake instance of Contributor and save it in database
     *
     * @param array $contributorFields
     * @return Contributor
     */
    public function makeContributor($contributorFields = [])
    {
        /** @var ContributorRepository $contributorRepo */
        $contributorRepo = App::make(ContributorRepository::class);
        $theme = $this->fakeContributorData($contributorFields);
        return $contributorRepo->create($theme);
    }

    /**
     * Get fake instance of Contributor
     *
     * @param array $contributorFields
     * @return Contributor
     */
    public function fakeContributor($contributorFields = [])
    {
        return new Contributor($this->fakeContributorData($contributorFields));
    }

    /**
     * Get fake data of Contributor
     *
     * @param array $postFields
     * @return array
     */
    public function fakeContributorData($contributorFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'names' => $fake->word,
            'last_names' => $fake->word,
            'privacy' => $fake->word,
            'type_identifications_id' => $fake->randomDigitNotNull,
            'nit_id' => $fake->word,
            'type_contributors_id' => $fake->randomDigitNotNull,
            'base64' => $fake->word,
            'filetype' => $fake->word,
            'cellphone_telephone_contact' => $fake->word,
            'users_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $contributorFields);
    }
}
