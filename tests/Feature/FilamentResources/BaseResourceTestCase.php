<?php

namespace Tests\Feature\FilamentResources;

use Exception;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Livewire\Livewire;
use Tests\TestCase;

abstract class BaseResourceTestCase extends TestCase
{
    /** @var string|resource Filament resource class name. You should fill this in your class. */
    protected static string|Resource $resource;

    private static string|Model $model;

    protected static bool $hasListPage = true;

    protected static bool $hasCreatePage = true;

    protected static bool $hasViewPage = false;

    protected function setUp(): void
    {
        parent::setUp();

        static::$model = static::$resource::getModel();
    }

    /**
     * Returns with a specified page from the resource, e.g a ListRecords, CreateRecord, ViewRecord, etc. page.
     *
     * @param  string  $basePage  base page class, e.g. ListRecords::class
     */
    protected function getPageByType(string $basePage): ?string
    {
        foreach (static::$resource::getPages() as $page) {
            if (is_subclass_of($page->getPage(), $basePage)) {
                return $page->getPage();
            }
        }

        return null;
    }

    /**
     * These data will be checked on the ViewRecord page. If the resource has a view page you should fill this.
     * This will be passed to the "assertSchemaStateSet" function.
     *
     * @url https://filamentphp.com/docs/4.x/testing/testing-resources#testing-a-resource-view-page
     */
    protected function viewSchemaData(Model $model): array
    {
        return [];
    }

    public function test_can_show_empty_list(): void
    {
        if (! static::$hasListPage) {
            $this->markTestSkipped('Resource does not have a list page.');
        }

        Livewire::test($this->getPageByType(ListRecords::class))
            ->assertOk()
            ->assertCountTableRecords(0);
    }

    /**
     * @throws Exception
     */
    public function test_can_show_list_with_items(): void
    {
        if (! static::$hasListPage) {
            $this->markTestSkipped('Resource does not have a list page.');
        }

        if (! method_exists(static::$model, 'factory')) {
            throw new Exception('Model should have a factory to test.');
        }

        $item = static::$model::factory()->count(5)->create();

        Livewire::test($this->getPageByType(ListRecords::class))
            ->assertOk()
            ->assertCountTableRecords(5)
            ->assertCanSeeTableRecords($item);
    }

    public function test_can_show_create_page(): void
    {
        if (! static::$hasCreatePage) {
            $this->markTestSkipped('Resource does not have a create page.');
        }

        Livewire::test($this->getPageByType(CreateRecord::class))
            ->assertOk();
    }

    /**
     * @throws Exception
     */
    public function test_can_show_view_page(): void
    {
        if (! static::$hasViewPage) {
            $this->markTestSkipped('Resource does not have a view page.');
        }

        if (! method_exists(static::$model, 'factory')) {
            throw new Exception('Model should have a factory to test.');
        }

        $item = static::$model::factory()->create();

        if ($this->viewSchemaData($item) === []) {
            throw new Exception('viewSchemaData function should result at least one key-value pair.');
        }

        Livewire::test($this->getPageByType(ViewRecord::class), [
            'record' => $item->id,
        ])
            ->assertOk()
            ->assertSchemaStateSet($this->viewSchemaData($item));
    }
}
