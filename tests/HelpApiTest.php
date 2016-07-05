<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelpApiTest extends TestCase
{
    use MakeHelpTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateHelp()
    {
        $help = $this->fakeHelpData();
        $this->json('POST', '/api/v1/helps', $help);

        $this->assertApiResponse($help);
    }

    /**
     * @test
     */
    public function testReadHelp()
    {
        $help = $this->makeHelp();
        $this->json('GET', '/api/v1/helps/'.$help->id);

        $this->assertApiResponse($help->toArray());
    }

    /**
     * @test
     */
    public function testUpdateHelp()
    {
        $help = $this->makeHelp();
        $editedHelp = $this->fakeHelpData();

        $this->json('PUT', '/api/v1/helps/'.$help->id, $editedHelp);

        $this->assertApiResponse($editedHelp);
    }

    /**
     * @test
     */
    public function testDeleteHelp()
    {
        $help = $this->makeHelp();
        $this->json('DELETE', '/api/v1/helps/'.$help->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/helps/'.$help->id);

        $this->assertResponseStatus(404);
    }
}
