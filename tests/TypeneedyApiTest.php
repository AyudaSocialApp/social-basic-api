<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypeneedyApiTest extends TestCase
{
    use MakeTypeneedyTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTypeneedy()
    {
        $typeneedy = $this->fakeTypeneedyData();
        $this->json('POST', '/api/v1/typeneedies', $typeneedy);

        $this->assertApiResponse($typeneedy);
    }

    /**
     * @test
     */
    public function testReadTypeneedy()
    {
        $typeneedy = $this->makeTypeneedy();
        $this->json('GET', '/api/v1/typeneedies/'.$typeneedy->id);

        $this->assertApiResponse($typeneedy->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTypeneedy()
    {
        $typeneedy = $this->makeTypeneedy();
        $editedTypeneedy = $this->fakeTypeneedyData();

        $this->json('PUT', '/api/v1/typeneedies/'.$typeneedy->id, $editedTypeneedy);

        $this->assertApiResponse($editedTypeneedy);
    }

    /**
     * @test
     */
    public function testDeleteTypeneedy()
    {
        $typeneedy = $this->makeTypeneedy();
        $this->json('DELETE', '/api/v1/typeneedies/'.$typeneedy->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/typeneedies/'.$typeneedy->id);

        $this->assertResponseStatus(404);
    }
}
