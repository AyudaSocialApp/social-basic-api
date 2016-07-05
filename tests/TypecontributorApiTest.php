<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypecontributorApiTest extends TestCase
{
    use MakeTypecontributorTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTypecontributor()
    {
        $typecontributor = $this->fakeTypecontributorData();
        $this->json('POST', '/api/v1/typecontributors', $typecontributor);

        $this->assertApiResponse($typecontributor);
    }

    /**
     * @test
     */
    public function testReadTypecontributor()
    {
        $typecontributor = $this->makeTypecontributor();
        $this->json('GET', '/api/v1/typecontributors/'.$typecontributor->id);

        $this->assertApiResponse($typecontributor->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTypecontributor()
    {
        $typecontributor = $this->makeTypecontributor();
        $editedTypecontributor = $this->fakeTypecontributorData();

        $this->json('PUT', '/api/v1/typecontributors/'.$typecontributor->id, $editedTypecontributor);

        $this->assertApiResponse($editedTypecontributor);
    }

    /**
     * @test
     */
    public function testDeleteTypecontributor()
    {
        $typecontributor = $this->makeTypecontributor();
        $this->json('DELETE', '/api/v1/typecontributors/'.$typecontributor->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/typecontributors/'.$typecontributor->id);

        $this->assertResponseStatus(404);
    }
}
