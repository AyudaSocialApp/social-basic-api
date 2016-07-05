<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IdeasApiTest extends TestCase
{
    use MakeIdeasTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateIdeas()
    {
        $ideas = $this->fakeIdeasData();
        $this->json('POST', '/api/v1/ideas', $ideas);

        $this->assertApiResponse($ideas);
    }

    /**
     * @test
     */
    public function testReadIdeas()
    {
        $ideas = $this->makeIdeas();
        $this->json('GET', '/api/v1/ideas/'.$ideas->id);

        $this->assertApiResponse($ideas->toArray());
    }

    /**
     * @test
     */
    public function testUpdateIdeas()
    {
        $ideas = $this->makeIdeas();
        $editedIdeas = $this->fakeIdeasData();

        $this->json('PUT', '/api/v1/ideas/'.$ideas->id, $editedIdeas);

        $this->assertApiResponse($editedIdeas);
    }

    /**
     * @test
     */
    public function testDeleteIdeas()
    {
        $ideas = $this->makeIdeas();
        $this->json('DELETE', '/api/v1/ideas/'.$ideas->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/ideas/'.$ideas->id);

        $this->assertResponseStatus(404);
    }
}
