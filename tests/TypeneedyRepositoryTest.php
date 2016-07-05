<?php

use App\Models\Typeneedy;
use App\Repositories\TypeneedyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypeneedyRepositoryTest extends TestCase
{
    use MakeTypeneedyTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TypeneedyRepository
     */
    protected $typeneedyRepo;

    public function setUp()
    {
        parent::setUp();
        $this->typeneedyRepo = App::make(TypeneedyRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTypeneedy()
    {
        $typeneedy = $this->fakeTypeneedyData();
        $createdTypeneedy = $this->typeneedyRepo->create($typeneedy);
        $createdTypeneedy = $createdTypeneedy->toArray();
        $this->assertArrayHasKey('id', $createdTypeneedy);
        $this->assertNotNull($createdTypeneedy['id'], 'Created Typeneedy must have id specified');
        $this->assertNotNull(Typeneedy::find($createdTypeneedy['id']), 'Typeneedy with given id must be in DB');
        $this->assertModelData($typeneedy, $createdTypeneedy);
    }

    /**
     * @test read
     */
    public function testReadTypeneedy()
    {
        $typeneedy = $this->makeTypeneedy();
        $dbTypeneedy = $this->typeneedyRepo->find($typeneedy->id);
        $dbTypeneedy = $dbTypeneedy->toArray();
        $this->assertModelData($typeneedy->toArray(), $dbTypeneedy);
    }

    /**
     * @test update
     */
    public function testUpdateTypeneedy()
    {
        $typeneedy = $this->makeTypeneedy();
        $fakeTypeneedy = $this->fakeTypeneedyData();
        $updatedTypeneedy = $this->typeneedyRepo->update($fakeTypeneedy, $typeneedy->id);
        $this->assertModelData($fakeTypeneedy, $updatedTypeneedy->toArray());
        $dbTypeneedy = $this->typeneedyRepo->find($typeneedy->id);
        $this->assertModelData($fakeTypeneedy, $dbTypeneedy->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTypeneedy()
    {
        $typeneedy = $this->makeTypeneedy();
        $resp = $this->typeneedyRepo->delete($typeneedy->id);
        $this->assertTrue($resp);
        $this->assertNull(Typeneedy::find($typeneedy->id), 'Typeneedy should not exist in DB');
    }
}
