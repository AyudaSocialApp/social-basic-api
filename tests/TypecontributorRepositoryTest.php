<?php

use App\Models\Typecontributor;
use App\Repositories\TypecontributorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypecontributorRepositoryTest extends TestCase
{
    use MakeTypecontributorTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TypecontributorRepository
     */
    protected $typecontributorRepo;

    public function setUp()
    {
        parent::setUp();
        $this->typecontributorRepo = App::make(TypecontributorRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTypecontributor()
    {
        $typecontributor = $this->fakeTypecontributorData();
        $createdTypecontributor = $this->typecontributorRepo->create($typecontributor);
        $createdTypecontributor = $createdTypecontributor->toArray();
        $this->assertArrayHasKey('id', $createdTypecontributor);
        $this->assertNotNull($createdTypecontributor['id'], 'Created Typecontributor must have id specified');
        $this->assertNotNull(Typecontributor::find($createdTypecontributor['id']), 'Typecontributor with given id must be in DB');
        $this->assertModelData($typecontributor, $createdTypecontributor);
    }

    /**
     * @test read
     */
    public function testReadTypecontributor()
    {
        $typecontributor = $this->makeTypecontributor();
        $dbTypecontributor = $this->typecontributorRepo->find($typecontributor->id);
        $dbTypecontributor = $dbTypecontributor->toArray();
        $this->assertModelData($typecontributor->toArray(), $dbTypecontributor);
    }

    /**
     * @test update
     */
    public function testUpdateTypecontributor()
    {
        $typecontributor = $this->makeTypecontributor();
        $fakeTypecontributor = $this->fakeTypecontributorData();
        $updatedTypecontributor = $this->typecontributorRepo->update($fakeTypecontributor, $typecontributor->id);
        $this->assertModelData($fakeTypecontributor, $updatedTypecontributor->toArray());
        $dbTypecontributor = $this->typecontributorRepo->find($typecontributor->id);
        $this->assertModelData($fakeTypecontributor, $dbTypecontributor->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTypecontributor()
    {
        $typecontributor = $this->makeTypecontributor();
        $resp = $this->typecontributorRepo->delete($typecontributor->id);
        $this->assertTrue($resp);
        $this->assertNull(Typecontributor::find($typecontributor->id), 'Typecontributor should not exist in DB');
    }
}
