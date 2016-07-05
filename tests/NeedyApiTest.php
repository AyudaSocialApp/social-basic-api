<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NeedyApiTest extends TestCase
{
    use MakeNeedyTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateNeedy()
    {
        $needy = $this->fakeNeedyData();
        $this->json('POST', '/api/v1/needies', $needy);

        $this->assertApiResponse($needy);
    }

    /**
     * @test
     */
    public function testReadNeedy()
    {
        $needy = $this->makeNeedy();
        $this->json('GET', '/api/v1/needies/'.$needy->id);

        $this->assertApiResponse($needy->toArray());
    }

    /**
     * @test
     */
    public function testUpdateNeedy()
    {
        $needy = $this->makeNeedy();
        $editedNeedy = $this->fakeNeedyData();

        $this->json('PUT', '/api/v1/needies/'.$needy->id, $editedNeedy);

        $this->assertApiResponse($editedNeedy);
    }

    /**
     * @test
     */
    public function testDeleteNeedy()
    {
        $needy = $this->makeNeedy();
        $this->json('DELETE', '/api/v1/needies/'.$needy->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/needies/'.$needy->id);

        $this->assertResponseStatus(404);
    }
}
