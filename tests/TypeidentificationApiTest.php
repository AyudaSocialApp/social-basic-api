<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypeidentificationApiTest extends TestCase
{
    use MakeTypeidentificationTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTypeidentification()
    {
        $typeidentification = $this->fakeTypeidentificationData();
        $this->json('POST', '/api/v1/typeidentifications', $typeidentification);

        $this->assertApiResponse($typeidentification);
    }

    /**
     * @test
     */
    public function testReadTypeidentification()
    {
        $typeidentification = $this->makeTypeidentification();
        $this->json('GET', '/api/v1/typeidentifications/'.$typeidentification->id);

        $this->assertApiResponse($typeidentification->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTypeidentification()
    {
        $typeidentification = $this->makeTypeidentification();
        $editedTypeidentification = $this->fakeTypeidentificationData();

        $this->json('PUT', '/api/v1/typeidentifications/'.$typeidentification->id, $editedTypeidentification);

        $this->assertApiResponse($editedTypeidentification);
    }

    /**
     * @test
     */
    public function testDeleteTypeidentification()
    {
        $typeidentification = $this->makeTypeidentification();
        $this->json('DELETE', '/api/v1/typeidentifications/'.$typeidentification->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/typeidentifications/'.$typeidentification->id);

        $this->assertResponseStatus(404);
    }
}
