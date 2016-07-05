<?php

use App\Models\Help;
use App\Repositories\HelpRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelpRepositoryTest extends TestCase
{
    use MakeHelpTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var HelpRepository
     */
    protected $helpRepo;

    public function setUp()
    {
        parent::setUp();
        $this->helpRepo = App::make(HelpRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateHelp()
    {
        $help = $this->fakeHelpData();
        $createdHelp = $this->helpRepo->create($help);
        $createdHelp = $createdHelp->toArray();
        $this->assertArrayHasKey('id', $createdHelp);
        $this->assertNotNull($createdHelp['id'], 'Created Help must have id specified');
        $this->assertNotNull(Help::find($createdHelp['id']), 'Help with given id must be in DB');
        $this->assertModelData($help, $createdHelp);
    }

    /**
     * @test read
     */
    public function testReadHelp()
    {
        $help = $this->makeHelp();
        $dbHelp = $this->helpRepo->find($help->id);
        $dbHelp = $dbHelp->toArray();
        $this->assertModelData($help->toArray(), $dbHelp);
    }

    /**
     * @test update
     */
    public function testUpdateHelp()
    {
        $help = $this->makeHelp();
        $fakeHelp = $this->fakeHelpData();
        $updatedHelp = $this->helpRepo->update($fakeHelp, $help->id);
        $this->assertModelData($fakeHelp, $updatedHelp->toArray());
        $dbHelp = $this->helpRepo->find($help->id);
        $this->assertModelData($fakeHelp, $dbHelp->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteHelp()
    {
        $help = $this->makeHelp();
        $resp = $this->helpRepo->delete($help->id);
        $this->assertTrue($resp);
        $this->assertNull(Help::find($help->id), 'Help should not exist in DB');
    }
}
