<?php

use App\Models\Contributor;
use App\Repositories\ContributorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContributorRepositoryTest extends TestCase
{
    use MakeContributorTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ContributorRepository
     */
    protected $contributorRepo;

    public function setUp()
    {
        parent::setUp();
        $this->contributorRepo = App::make(ContributorRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateContributor()
    {
        $contributor = $this->fakeContributorData();
        $createdContributor = $this->contributorRepo->create($contributor);
        $createdContributor = $createdContributor->toArray();
        $this->assertArrayHasKey('id', $createdContributor);
        $this->assertNotNull($createdContributor['id'], 'Created Contributor must have id specified');
        $this->assertNotNull(Contributor::find($createdContributor['id']), 'Contributor with given id must be in DB');
        $this->assertModelData($contributor, $createdContributor);
    }

    /**
     * @test read
     */
    public function testReadContributor()
    {
        $contributor = $this->makeContributor();
        $dbContributor = $this->contributorRepo->find($contributor->id);
        $dbContributor = $dbContributor->toArray();
        $this->assertModelData($contributor->toArray(), $dbContributor);
    }

    /**
     * @test update
     */
    public function testUpdateContributor()
    {
        $contributor = $this->makeContributor();
        $fakeContributor = $this->fakeContributorData();
        $updatedContributor = $this->contributorRepo->update($fakeContributor, $contributor->id);
        $this->assertModelData($fakeContributor, $updatedContributor->toArray());
        $dbContributor = $this->contributorRepo->find($contributor->id);
        $this->assertModelData($fakeContributor, $dbContributor->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteContributor()
    {
        $contributor = $this->makeContributor();
        $resp = $this->contributorRepo->delete($contributor->id);
        $this->assertTrue($resp);
        $this->assertNull(Contributor::find($contributor->id), 'Contributor should not exist in DB');
    }
}
