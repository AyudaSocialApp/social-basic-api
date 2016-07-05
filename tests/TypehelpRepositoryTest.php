<?php

use App\Models\Typehelp;
use App\Repositories\TypehelpRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypehelpRepositoryTest extends TestCase
{
    use MakeTypehelpTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TypehelpRepository
     */
    protected $typehelpRepo;

    public function setUp()
    {
        parent::setUp();
        $this->typehelpRepo = App::make(TypehelpRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTypehelp()
    {
        $typehelp = $this->fakeTypehelpData();
        $createdTypehelp = $this->typehelpRepo->create($typehelp);
        $createdTypehelp = $createdTypehelp->toArray();
        $this->assertArrayHasKey('id', $createdTypehelp);
        $this->assertNotNull($createdTypehelp['id'], 'Created Typehelp must have id specified');
        $this->assertNotNull(Typehelp::find($createdTypehelp['id']), 'Typehelp with given id must be in DB');
        $this->assertModelData($typehelp, $createdTypehelp);
    }

    /**
     * @test read
     */
    public function testReadTypehelp()
    {
        $typehelp = $this->makeTypehelp();
        $dbTypehelp = $this->typehelpRepo->find($typehelp->id);
        $dbTypehelp = $dbTypehelp->toArray();
        $this->assertModelData($typehelp->toArray(), $dbTypehelp);
    }

    /**
     * @test update
     */
    public function testUpdateTypehelp()
    {
        $typehelp = $this->makeTypehelp();
        $fakeTypehelp = $this->fakeTypehelpData();
        $updatedTypehelp = $this->typehelpRepo->update($fakeTypehelp, $typehelp->id);
        $this->assertModelData($fakeTypehelp, $updatedTypehelp->toArray());
        $dbTypehelp = $this->typehelpRepo->find($typehelp->id);
        $this->assertModelData($fakeTypehelp, $dbTypehelp->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTypehelp()
    {
        $typehelp = $this->makeTypehelp();
        $resp = $this->typehelpRepo->delete($typehelp->id);
        $this->assertTrue($resp);
        $this->assertNull(Typehelp::find($typehelp->id), 'Typehelp should not exist in DB');
    }
}
