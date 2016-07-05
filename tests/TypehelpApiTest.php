<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypehelpApiTest extends TestCase
{
    use MakeTypehelpTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTypehelp()
    {
        $typehelp = $this->fakeTypehelpData();
        $this->json('POST', '/api/v1/typehelps', $typehelp);

        $this->assertApiResponse($typehelp);
    }

    /**
     * @test
     */
    public function testReadTypehelp()
    {
        $typehelp = $this->makeTypehelp();
        $this->json('GET', '/api/v1/typehelps/'.$typehelp->id);

        $this->assertApiResponse($typehelp->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTypehelp()
    {
        $typehelp = $this->makeTypehelp();
        $editedTypehelp = $this->fakeTypehelpData();

        $this->json('PUT', '/api/v1/typehelps/'.$typehelp->id, $editedTypehelp);

        $this->assertApiResponse($editedTypehelp);
    }

    /**
     * @test
     */
    public function testDeleteTypehelp()
    {
        $typehelp = $this->makeTypehelp();
        $this->json('DELETE', '/api/v1/typehelps/'.$typehelp->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/typehelps/'.$typehelp->id);

        $this->assertResponseStatus(404);
    }
}
