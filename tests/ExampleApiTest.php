<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleApiTest extends TestCase
{
    use MakeExampleTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateExample()
    {
        $example = $this->fakeExampleData();
        $this->json('POST', '/api/v1/examples', $example);

        $this->assertApiResponse($example);
    }

    /**
     * @test
     */
    public function testReadExample()
    {
        $example = $this->makeExample();
        $this->json('GET', '/api/v1/examples/'.$example->id);

        $this->assertApiResponse($example->toArray());
    }

    /**
     * @test
     */
    public function testUpdateExample()
    {
        $example = $this->makeExample();
        $editedExample = $this->fakeExampleData();

        $this->json('PUT', '/api/v1/examples/'.$example->id, $editedExample);

        $this->assertApiResponse($editedExample);
    }

    /**
     * @test
     */
    public function testDeleteExample()
    {
        $example = $this->makeExample();
        $this->json('DELETE', '/api/v1/examples/'.$example->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/examples/'.$example->id);

        $this->assertResponseStatus(404);
    }
}
