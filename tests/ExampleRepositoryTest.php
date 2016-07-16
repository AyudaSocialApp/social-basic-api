<?php

use App\Models\Example;
use App\Repositories\ExampleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleRepositoryTest extends TestCase
{
    use MakeExampleTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ExampleRepository
     */
    protected $exampleRepo;

    public function setUp()
    {
        parent::setUp();
        $this->exampleRepo = App::make(ExampleRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateExample()
    {
        $example = $this->fakeExampleData();
        $createdExample = $this->exampleRepo->create($example);
        $createdExample = $createdExample->toArray();
        $this->assertArrayHasKey('id', $createdExample);
        $this->assertNotNull($createdExample['id'], 'Created Example must have id specified');
        $this->assertNotNull(Example::find($createdExample['id']), 'Example with given id must be in DB');
        $this->assertModelData($example, $createdExample);
    }

    /**
     * @test read
     */
    public function testReadExample()
    {
        $example = $this->makeExample();
        $dbExample = $this->exampleRepo->find($example->id);
        $dbExample = $dbExample->toArray();
        $this->assertModelData($example->toArray(), $dbExample);
    }

    /**
     * @test update
     */
    public function testUpdateExample()
    {
        $example = $this->makeExample();
        $fakeExample = $this->fakeExampleData();
        $updatedExample = $this->exampleRepo->update($fakeExample, $example->id);
        $this->assertModelData($fakeExample, $updatedExample->toArray());
        $dbExample = $this->exampleRepo->find($example->id);
        $this->assertModelData($fakeExample, $dbExample->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteExample()
    {
        $example = $this->makeExample();
        $resp = $this->exampleRepo->delete($example->id);
        $this->assertTrue($resp);
        $this->assertNull(Example::find($example->id), 'Example should not exist in DB');
    }
}
