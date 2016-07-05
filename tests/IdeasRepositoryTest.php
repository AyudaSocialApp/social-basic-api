<?php

use App\Models\Ideas;
use App\Repositories\IdeasRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IdeasRepositoryTest extends TestCase
{
    use MakeIdeasTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var IdeasRepository
     */
    protected $ideasRepo;

    public function setUp()
    {
        parent::setUp();
        $this->ideasRepo = App::make(IdeasRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateIdeas()
    {
        $ideas = $this->fakeIdeasData();
        $createdIdeas = $this->ideasRepo->create($ideas);
        $createdIdeas = $createdIdeas->toArray();
        $this->assertArrayHasKey('id', $createdIdeas);
        $this->assertNotNull($createdIdeas['id'], 'Created Ideas must have id specified');
        $this->assertNotNull(Ideas::find($createdIdeas['id']), 'Ideas with given id must be in DB');
        $this->assertModelData($ideas, $createdIdeas);
    }

    /**
     * @test read
     */
    public function testReadIdeas()
    {
        $ideas = $this->makeIdeas();
        $dbIdeas = $this->ideasRepo->find($ideas->id);
        $dbIdeas = $dbIdeas->toArray();
        $this->assertModelData($ideas->toArray(), $dbIdeas);
    }

    /**
     * @test update
     */
    public function testUpdateIdeas()
    {
        $ideas = $this->makeIdeas();
        $fakeIdeas = $this->fakeIdeasData();
        $updatedIdeas = $this->ideasRepo->update($fakeIdeas, $ideas->id);
        $this->assertModelData($fakeIdeas, $updatedIdeas->toArray());
        $dbIdeas = $this->ideasRepo->find($ideas->id);
        $this->assertModelData($fakeIdeas, $dbIdeas->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteIdeas()
    {
        $ideas = $this->makeIdeas();
        $resp = $this->ideasRepo->delete($ideas->id);
        $this->assertTrue($resp);
        $this->assertNull(Ideas::find($ideas->id), 'Ideas should not exist in DB');
    }
}
