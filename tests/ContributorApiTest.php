<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContributorApiTest extends TestCase
{
    use MakeContributorTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateContributor()
    {
        $contributor = $this->fakeContributorData();
        $this->json('POST', '/api/v1/contributors', $contributor);

        $this->assertApiResponse($contributor);
    }

    /**
     * @test
     */
    public function testReadContributor()
    {
        $contributor = $this->makeContributor();
        $this->json('GET', '/api/v1/contributors/'.$contributor->id);

        $this->assertApiResponse($contributor->toArray());
    }

    /**
     * @test
     */
    public function testUpdateContributor()
    {
        $contributor = $this->makeContributor();
        $editedContributor = $this->fakeContributorData();

        $this->json('PUT', '/api/v1/contributors/'.$contributor->id, $editedContributor);

        $this->assertApiResponse($editedContributor);
    }

    /**
     * @test
     */
    public function testDeleteContributor()
    {
        $contributor = $this->makeContributor();
        $this->json('DELETE', '/api/v1/contributors/'.$contributor->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/contributors/'.$contributor->id);

        $this->assertResponseStatus(404);
    }
}
