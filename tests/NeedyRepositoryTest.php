<?php

use App\Models\Needy;
use App\Repositories\NeedyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NeedyRepositoryTest extends TestCase
{
    use MakeNeedyTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var NeedyRepository
     */
    protected $needyRepo;

    public function setUp()
    {
        parent::setUp();
        $this->needyRepo = App::make(NeedyRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateNeedy()
    {
        $needy = $this->fakeNeedyData();
        $createdNeedy = $this->needyRepo->create($needy);
        $createdNeedy = $createdNeedy->toArray();
        $this->assertArrayHasKey('id', $createdNeedy);
        $this->assertNotNull($createdNeedy['id'], 'Created Needy must have id specified');
        $this->assertNotNull(Needy::find($createdNeedy['id']), 'Needy with given id must be in DB');
        $this->assertModelData($needy, $createdNeedy);
    }

    /**
     * @test read
     */
    public function testReadNeedy()
    {
        $needy = $this->makeNeedy();
        $dbNeedy = $this->needyRepo->find($needy->id);
        $dbNeedy = $dbNeedy->toArray();
        $this->assertModelData($needy->toArray(), $dbNeedy);
    }

    /**
     * @test update
     */
    public function testUpdateNeedy()
    {
        $needy = $this->makeNeedy();
        $fakeNeedy = $this->fakeNeedyData();
        $updatedNeedy = $this->needyRepo->update($fakeNeedy, $needy->id);
        $this->assertModelData($fakeNeedy, $updatedNeedy->toArray());
        $dbNeedy = $this->needyRepo->find($needy->id);
        $this->assertModelData($fakeNeedy, $dbNeedy->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteNeedy()
    {
        $needy = $this->makeNeedy();
        $resp = $this->needyRepo->delete($needy->id);
        $this->assertTrue($resp);
        $this->assertNull(Needy::find($needy->id), 'Needy should not exist in DB');
    }
}
