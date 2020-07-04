<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class CreateTraitClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $type = 'Trait';

    private $TraitClass;

    private $model;

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $this->setTraitClass();
        $path = $this->getPath($this->TraitClass);
        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type . ' already exists');
        }
        $this->makeDirectory($path);
        $this->files()->put($path, $this->buildClass($this->TraitClass));
        $this->info($this->type . ' created successfully');
        $this->line("<info>Created Trait :</info> $this->TraitClass");
    }

    private function setTraitClass()
    {
        $name = ucwords(strtolower($this->argument('name')));
        $this->model = $name;
        $modelClass = $this->parseName($name);
        $this->TraitClass = $modelClass . 'Trait';
        return $this;
    }


    public function replaceClass($stub, $name)
    {
        if (!$this->argument('name')) {
            throw new InvalidArgumentException("Missing required argument model name");
        }
        $stub = parent::replaceClass($stub, $name);
        return str_replace('DummyTrait', $this->model, $stub);
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Traits';
    }

    protected function getStub()
    {
        return base_path('stubs/Trait.stub');
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model class.'],
        ];
    }
    public function handle()
    {
        //
    }
}
