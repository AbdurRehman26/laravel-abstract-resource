<?php
namespace Kazmi\Commands;
use Illuminate\Console\GeneratorCommand;
class ApiResourceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resource-api {name}';
    protected $routePath = 'routes/api.php';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Api Resource for Controller, Repository, Provider and Model';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->getNameInput();
        $this->call('make:resource-controller', [
            'name' => $name]);
        $this->call('make:resource-repository', [
            'name' => $name]);
        $this->call('make:model', [
            'name' => "Data\\Models\\".$name]);
        $this->call('make:provider', [
            'name' => $name."RepositoryServiceProvider"]);
        $this->files->append($this->routePath, $this->getRoute());
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        // TODO: Implement getStub() method.
    }
    protected function getRoute(){
        $name = $this->getNameInput();
        return "Route::resource('".strtolower($name)."', 'Api\\V1\\".$name."Controller')->except([
             'edit'
        ]);";
    }
}
