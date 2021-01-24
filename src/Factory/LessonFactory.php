<?php

namespace App\Factory;

use App\Entity\Lesson;
use Zenstruck\Foundry\Proxy;
use App\Repository\CoursRepository;
use Zenstruck\Foundry\ModelFactory;
use App\Repository\LessonRepository;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @method static Lesson|Proxy createOne(array $attributes = [])
 * @method static Lesson[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Lesson|Proxy findOrCreate(array $attributes)
 * @method static Lesson|Proxy random(array $attributes = [])
 * @method static Lesson|Proxy randomOrCreate(array $attributes = [])
 * @method static Lesson[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Lesson[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LessonRepository|RepositoryProxy repository()
 * @method Lesson|Proxy create($attributes = [])
 */
final class LessonFactory extends ModelFactory
{
    private $cours;

    public function __construct(CoursRepository $repository)
    {
        parent::__construct();
        $this->cours = $repository->findAll();
        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'video' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3Iiyzo9vdYA" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut facilisis pulvinar convallis. Fusce lacinia eros est, quis volutpat nisi bibendum sit amet. Aenean ut ante risus. Aliquam at egestas ex. Nunc non felis a lacus scelerisque viverra. Nulla a interdum ipsum. Donec nec ligula auctor, imperdiet nisl ac, semper mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquam id velit ac pellentesque. Integer sagittis suscipit ultricies. Nulla neque augue, ultrices vitae nunc eget, aliquam dignissim urna. Vivamus scelerisque porta mauris convallis sollicitudin. Praesent ullamcorper neque non lacus ullamcorper, eget finibus tortor posuere.',
        ]; 
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Lesson $lesson) {})
        ;
    }

    protected static function getClass(): string
    {
        return Lesson::class;
    }
}
