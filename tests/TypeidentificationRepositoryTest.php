<?php

use App\Models\Typeidentification;
use App\Repositories\TypeidentificationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypeidentificationRepositoryTest extends TestCase
{
    use MakeTypeidentificationTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TypeidentificationRepository
     */
    protected $typeidentificationRepo;

    public function setUp()
    {
        parent::setUp();
        $this->typeidentificationRepo = App::make(TypeidentificationRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTypeidentification()
    {
        $typeidentification = $this->fakeTypeidentificationData();
        $createdTypeidentification = $this->typeidentificationRepo->create($typeidentification);
        $createdTypeidentification = $createdTypeidentification->toArray();
        $this->assertArrayHasKey('id', $createdTypeidentification);
        $this->assertNotNull($createdTypeidentification['id'], 'Created Typeidentification must have id specified');
        $this->assertNotNull(Typeidentification::find($createdTypeidentification['id']), 'Typeidentification with given id must be in DB');
        $this->assertModelData($typeidentification, $createdTypeidentification);
    }

    /**
     * @test read
     */
    public function testReadTypeidentification()
    {
        $typeidentification = $this->makeTypeidentification();
        $dbTypeidentification = $this->typeidentificationRepo->find($typeidentification->id);
        $dbTypeidentification = $dbTypeidentification->toArray();
        $this->assertModelData($typeidentification->toArray(), $dbTypeidentification);
    }

    /**
     * @test update
     */
    public function testUpdateTypeidentification()
    {
        $typeidentification = $this->makeTypeidentification();
        $fakeTypeidentification = $this->fakeTypeidentificationData();
        $updatedTypeidentification = $this->typeidentificationRepo->update($fakeTypeidentification, $typeidentification->id);
        $this->assertModelData($fakeTypeidentification, $updatedTypeidentification->toArray());
        $dbTypeidentification = $this->typeidentificationRepo->find($typeidentification->id);
        $this->assertModelData($fakeTypeidentification, $dbTypeidentification->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTypeidentification()
    {
        $typeidentification = $this->makeTypeidentification();
        $resp = $this->typeidentificationRepo->delete($typeidentification->id);
        $this->assertTrue($resp);
        $this->assertNull(Typeidentification::find($typeidentification->id), 'Typeidentification should not exist in DB');
    }
}
